<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 't_agenda';
    protected $primaryKey = 'agenda_id';
    protected $fillable = ['event_id', 'nama_agenda', 'start_date','end_date', 'tempat', 'point_beban_kerja', 'status', 'jabatan_id', 'needs_update',
    'point_generated_at'];

    public function events()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function assignees()
    {
        return $this->hasMany(AgendaAssignee::class, 'agenda_id');
    }

    public function documents()
    {
        return $this->hasMany(AgendaDocument::class, 'agenda_id', 'agenda_id');
    }

    public function workloads()
    {
        return $this->hasMany(Workload::class, 'agenda_id');
    }

    public function position()
    {
        return $this->BelongsToMany(Position::class, 'jabatan_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($agenda) {
            $agenda->assignees()->delete();
            $agenda->documents()->delete();
            $agenda->workloads()->delete();

        });
    }


   /**
 * Generate points for agendas using TOPSIS method
 *
 * @param int $eventId Event ID
 * @param float $point Total base point for the event
 * @return array
 */
public static function generatePointsByTopsis($eventId, $point)
{
    // Fetch all agendas for specific event
    $agendas = self::where('event_id', $eventId)->get();

    if ($agendas->isEmpty()) {
        return [
            'status' => false,
            'message' => 'Tidak ada agenda yang ditemukan.'
        ];
    }

    // Prepare criteria matrix
    $criteriaMatrix = self::prepareCriteriaMatrix($agendas);

    // Normalize matrix
    $normalizedMatrix = self::normalizeMatrix($criteriaMatrix);

    // Criteria weights
    $weights = [
        'jabatan_point' => 0.8,  // 80%
        'duration' => 0.2        // 20%
    ];

    // Calculate weighted matrix
    $weightedMatrix = self::calculateWeightedMatrix($normalizedMatrix, $weights);

    // Find ideal solutions (duration is now a cost criterion)
    $idealSolutions = self::findIdealSolutions($weightedMatrix);

    // Calculate distances
    $distances = self::calculateDistances($weightedMatrix, $idealSolutions);

    // Calculate priority scores
    $priorities = self::calculatePriorities($distances);

    // Generate points
    $pointsResult = self::generatePointsFromPriorities($priorities, $point);

    // Save points to database
    self::savePointsToDatabase($pointsResult);

    return [
        'status' => true,
        'message' => 'Berhasil generate points, Harap melakukan update agenda jika pointnya berubah',
        'results' => $pointsResult
    ];
}

/**
 * Prepare criteria matrix
 */
/**
 * Prepare criteria matrix
 */
private static function prepareCriteriaMatrix($agendas)
{
    $criteriaMatrix = [];

    // Definisikan point jabatan secara statis
    $jabatanPoints = [
        'PIC' => 10,
        'PMB' => 6,
        'SKR' => 5,
        'AGT' => 1
    ];

    foreach ($agendas as $agenda) {
        // Ambil nama jabatan dari model Position
        $jabatanCode = Position::find($agenda->jabatan_id)->jabatan_code ?? 'AGT';

        // Ambil point berdasarkan kode jabatan, gunakan kode asli tanpa mengubah kapitalisasi
        $jabatanPoint = $jabatanPoints[$jabatanCode] ?? 1;

        // Calculate duration (in days)
        $startDate = Carbon::parse($agenda->start_date);
        $endDate = Carbon::parse($agenda->end_date);
        $duration = $startDate->diffInDays($endDate) + 1; // +1 to count the first day

        $criteriaMatrix[] = [
            'agenda_id' => $agenda->agenda_id,
            'jabatan_point' => $jabatanPoint,
            'duration' => $duration
        ];
    }

    return $criteriaMatrix;
}

/**
 * Normalize matrix
 */
private static function normalizeMatrix($matrix)
{
    $normalized = [];

    // Calculate square root of sum of squares for each criterion
    $jabatanSqrt = sqrt(array_sum(array_map(function($item) {
        return $item['jabatan_point'] * $item['jabatan_point'];
    }, $matrix)));

    $durationSqrt = sqrt(array_sum(array_map(function($item) {
        return $item['duration'] * $item['duration'];
    }, $matrix)));

    foreach ($matrix as $item) {
        $normalized[] = [
            'agenda_id' => $item['agenda_id'],
            'jabatan_point' => $item['jabatan_point'] / max($jabatanSqrt, 0.0001),
            'duration' => $item['duration'] / max($durationSqrt, 0.0001)
        ];
    }

    return $normalized;
}

/**
 * Calculate weighted matrix
 */
private static function calculateWeightedMatrix($normalizedMatrix, $weights)
{
    $weightedMatrix = [];

    foreach ($normalizedMatrix as $item) {
        $weightedMatrix[] = [
            'agenda_id' => $item['agenda_id'],
            'jabatan_point' => $item['jabatan_point'] * $weights['jabatan_point'],
            'duration' => $item['duration'] * $weights['duration']
        ];
    }

    return $weightedMatrix;
}

/**
 * Find ideal solutions (duration is now a cost criterion)
 */
private static function findIdealSolutions($weightedMatrix)
{
    return [
        'positive' => [
            'jabatan_point' => max(array_column($weightedMatrix, 'jabatan_point')),
            'duration' => min(array_column($weightedMatrix, 'duration')) // Changed to min for cost criterion
        ],
        'negative' => [
            'jabatan_point' => min(array_column($weightedMatrix, 'jabatan_point')),
            'duration' => max(array_column($weightedMatrix, 'duration')) // Changed to max for cost criterion
        ]
    ];
}

/**
 * Calculate distances
 */
private static function calculateDistances($weightedMatrix, $idealSolutions)
{
    $distances = [];

    foreach ($weightedMatrix as $item) {
        $positiveDistance = sqrt(
            pow($item['jabatan_point'] - $idealSolutions['positive']['jabatan_point'], 2) +
            pow($item['duration'] - $idealSolutions['positive']['duration'], 2)
        );

        $negativeDistance = sqrt(
            pow($item['jabatan_point'] - $idealSolutions['negative']['jabatan_point'], 2) +
            pow($item['duration'] - $idealSolutions['negative']['duration'], 2)
        );

        $distances[] = [
            'agenda_id' => $item['agenda_id'],
            'positive_distance' => $positiveDistance,
            'negative_distance' => $negativeDistance
        ];
    }

    return $distances;
}

/**
 * Calculate priorities
 */
private static function calculatePriorities($distances)
{
    $priorities = [];

    foreach ($distances as $distance) {
        // Ensure we don't divide by zero
        $totalDistance = $distance['positive_distance'] + $distance['negative_distance'];
        $priority = $totalDistance > 0 ?
            $distance['negative_distance'] / $totalDistance :
            0.5; // Default to middle priority if both distances are 0

        $priorities[] = [
            'agenda_id' => $distance['agenda_id'],
            'priority' => $priority
        ];
    }

    return $priorities;
}

/**
 * Generate points based on priorities
 */
private static function generatePointsFromPriorities($priorities, $point)
{
    $pointsResult = [];
    $totalPriority = array_sum(array_column($priorities, 'priority'));

    // Increase minimum point percentage to ensure no zero points
    $minPointPercentage = 0.1; // Minimal 10% dari total point
    $reservedPoints = $point * $minPointPercentage * count($priorities);
    $remainingPoints = $point - $reservedPoints;

    foreach ($priorities as $priority) {
        // Calculate base point (guaranteed minimum)
        $basePoint = ($point * $minPointPercentage);

        // Add additional points based on priority
        $additionalPoints = $totalPriority > 0 ?
            ($priority['priority'] / $totalPriority) * $remainingPoints :
            0;

        $calculatedPoint = $basePoint + $additionalPoints;

        $pointsResult[] = [
            'agenda_id' => $priority['agenda_id'],
            'priority' => $priority['priority'],
            'calculated_point' => round($calculatedPoint, 2)
        ];
    }

    // Verify total points and adjust if necessary
    $totalCalculatedPoint = array_sum(array_column($pointsResult, 'calculated_point'));
    if (abs($totalCalculatedPoint - $point) > 0.01) {
        $difference = $point - $totalCalculatedPoint;
        $lastIndex = count($pointsResult) - 1;
        $pointsResult[$lastIndex]['calculated_point'] = round($pointsResult[$lastIndex]['calculated_point'] + $difference, 2);
    }

    return $pointsResult;
}

/**
 * Save points to database
 */
private static function savePointsToDatabase($pointsResult)
{
    foreach ($pointsResult as $result) {
        self::where('agenda_id', $result['agenda_id'])
            ->update([
                'point_beban_kerja' => $result['calculated_point'],
                'needs_update' => true,
                'point_generated_at' => now()
            ]);
    }
}
}
