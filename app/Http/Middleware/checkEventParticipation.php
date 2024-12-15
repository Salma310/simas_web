<?php
// app/Http/Middleware/CheckEventParticipation.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;

class CheckEventParticipation
{
    public function handle($request, Closure $next, $requiredJabatan = null)
    {
        $eventId = $request->route('id');
        $user = Auth::user();

        // Find the event and the user's participation
        $event = Event::findOrFail($eventId);
        $userParticipation = $event->participants
            ->where('user_id', $user->user_id)
            ->first();

        // Check if user is a participant
        if (!$userParticipation) {
            abort(403, 'You are not a participant in this event');
        }

        // If a specific role is required, check it
        if ($requiredJabatan === 'pic' && $userParticipation->position->jabatan_id != 1) {
            abort(403, 'Only PIC can access this page');
        }

        return $next($request);
    }
}
