@extends('layouts.template')

@section('content')
    <div class="container-fluid px-4 pt-0">
        <div class="row">
            <div class="col-9">
                <!-- Statistik Utama -->
                <div class="row d-flex flex-row">
                    <!-- Jumlah User -->
                    <div class="col-lg-4 col-md-6 mb-1">
                        <div class="small-box bg-info" style="border-radius: 15px;">
                            <div class="inner">
                                <h3>{{ $event->Count('event_id') }}</h3>
                                <p>Jumlah Event</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <a href="{{ url('/event') }}" class="small-box-footer" style="border-radius: 0 0 15px 15px;">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Jumlah Event -->
                    <div class="col-lg-4 col-md-6 mb-1">
                        <div class="small-box bg-success" style="border-radius:15px;">
                            <div class="inner">
                                <h3>{{ $user->Count('user_id') }}</h3>
                                <p>Jumlah User</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <a href="{{ url('/user') }}" class="small-box-footer" style="border-radius: 0 0 15px 15px;">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Rata-Rata Sesi -->
                    <div class="col-lg-4 col-md-6 mb-1">
                        <div class="small-box bg-warning" style="border-radius: 15px;">
                            <div class="inner">
                                <h3 id="viewCountDisplay"></h3>
                                <p>Jumlah View</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <p class="small-box-footer text-dark" style="border-radius: 0 0 15px 15px;">
                                Jumlah View Dashboard
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Chart dan Event Aktif -->
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="card" style="border-radius: 15px">
                            <div class="card-header">
                                <h3 class="card-title">Event</h3>
                            </div>
                            <div class="card-body">
                                <div class="row d-flex justify-content-around">
                                    <!-- Grafik Donut 1 -->
                                    <div class="col-4 col-md-2 text-center">
                                        <canvas id="donutChart1"></canvas>
                                        <div class="knob-label">Event Completed</div>
                                    </div>
                                    <!-- Grafik Donut 2 -->
                                    <div class="col-4 col-md-2 text-center">
                                        <canvas id="donutChart2"></canvas>
                                        <div class="knob-label">Event In Progress</div>
                                    </div>
                                    <!-- Grafik Donut 3 -->
                                    <div class="col-4 col-md-2 text-center">
                                        <canvas id="donutChart3"></canvas>
                                        <div class="knob-label">Event Not Started</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card" style="border-radius: 15px; height: auto;">
                    <div class="card-body">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Active Progress Event</h5>
                                <p class="card-text text-secondary">Event dalam waktu dekat</p>
                            </div>
                            <div class="ml-auto">
                                @if (Auth::user()->role->role_name == 'Admin')
                                <a href="{{ url('/event') }}"><i class="fas fa-arrow-up text-dark" style="transform: rotate(45deg); font-size:20px;"></i></a>
                                @elseif (Auth::user()->role->role_name == 'Pimpinan')
                                <a href="{{ url('/event_pimpinan') }}"><i class="fas fa-arrow-up text-dark" style="transform: rotate(45deg); font-size:20px;"></i></a>
                                @endif
                            </div>
                        </div>
                        @php
                            use Carbon\Carbon;
                            $hari_ini = Carbon::now()->toDateString(); // Format 'Y-m-d'
                            $eventsBesok = $event->filter(function ($event) use ($hari_ini) {
                                return $event->end_date > $hari_ini; // Filter event dengan end_date setelah hari ini
                            });
                        @endphp

                        @if ($eventsBesok->isNotEmpty())
                            <ul class="list-group list-group-flush" style="max-height: 325px; overflow-y: auto;scrollbar-color:black transparent;scrollbar-width: thin;">
                                @foreach ($eventsBesok as $e)
                                    <li class="list-group-item">
                                        {{ $e->event_name }}
                                        <p class="mb-0 mt-1">{{ \Carbon\Carbon::parse($e->end_date)->translatedFormat('l, d-m-Y') }}</p>
                                    </li>
                                    
                                @endforeach
                            </ul>
                        @else
                            <p class="card-text">Tidak ada event dalam waktu dekat.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card" style="border-radius: 15px">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah User Login</h5>
                        <div style="width: auto; height: 400px; margin: 0 auto;padding-bottom:15px;">
                            <!-- Placeholder untuk chart Session Bulanan -->
                            <canvas id="sessionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js atau library lainnya untuk rendering chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ambil data dari server (PHP)
    const dailyLogins = @json($dailyLogins);

    // Ambil label tanggal dan jumlah login
    const dateLabels = Object.keys(dailyLogins); // Tanggal
    const loginCounts = Object.values(dailyLogins); // Jumlah login

    // Gunakan data ini untuk membuat grafik
    const ctx = document.getElementById('sessionChart').getContext('2d');
    const sessionChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dateLabels,
            datasets: [{
                label: 'Jumlah User Login',
                data: loginCounts,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                tension: 0.3,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    ticks: {
                        autoSkip: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            return `Tanggal: ${context[0].label}`;
                        },
                        label: function(context) {
                            return `Login: ${context.raw}`;
                        }
                    }
                }
            }
        }
    });

    // Fungsi untuk menambahkan teks di tengah grafik
    function addCenterText(chart, text) {
        const ctx = chart.ctx;
        const { width, height } = chart.chartArea;
        ctx.save();
        ctx.font = 'bold 16px Arial';
        ctx.fillStyle = '#333';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText(text, width / 2, height / 2);
        ctx.restore();
    }



        // Donut Chart 1
        <?php
        $totalEvent = DB::table('m_event')->count();
        
        // Pastikan total event tidak nol
        if ($totalEvent > 0) {
            $eventCompleted = DB::table('m_event')->where('status', 'completed')->count();
            $persentaseCompleted = round(($eventCompleted / $totalEvent) * 100);
            $persentaseSisa1 = round((($totalEvent - $eventCompleted) / $totalEvent) * 100);
        
            $eventProgress = DB::table('m_event')->where('status', 'progress')->count();
            $persentaseProgress = round(($eventProgress / $totalEvent) * 100);
            $persentaseSisa2 = round((($totalEvent - $eventProgress) / $totalEvent) * 100);
        
            $eventNotStarted = DB::table('m_event')->where('status', 'not started')->count();
            $persentaseNotStarted = round(($eventNotStarted / $totalEvent) * 100);
            $persentaseSisa3 = round((($totalEvent - $eventNotStarted) / $totalEvent) * 100);
        } else {
            // Jika tidak ada event, set nilai default
            $persentaseCompleted = 0;
            $persentaseSisa1 = 0;
            $persentaseProgress = 0;
            $persentaseSisa2 = 0;
            $persentaseNotStarted = 0;
            $persentaseSisa3 = 0;
        }
        ?>

        const donut1 = new Chart(document.getElementById('donutChart1'), {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Remaining'],
                datasets: [{
                    data: [
                        <?= $persentaseCompleted ?>, // Persentase Completed
                        <?= $persentaseSisa1 ?> // Persentase Remaining
                    ],
                    backgroundColor: ['#28a745', '#e9ecef'],
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    tooltip: {
                        enabled: false
                    },
                    legend: {
                        display: false
                    },
                },
            },
            plugins: [{
                id: 'centerText1',
                afterDraw: chart => addCenterText(chart, '<?= $persentaseCompleted ?>%'),
            }],
        });


        // Donut Chart 2
        const donut2 = new Chart(document.getElementById('donutChart2'), {
            type: 'doughnut',
            data: {
                labels: ['Progress', 'Remaining'],
                datasets: [{
                    data: [
                        <?= $persentaseProgress ?>,
                        <?= $persentaseSisa2 ?>
                    ],
                    backgroundColor: ['#ffc107', '#e9ecef'],
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    tooltip: {
                        enabled: false
                    },
                    legend: {
                        display: false
                    },
                },
            },
            plugins: [{
                id: 'centerText2',
                afterDraw: chart => addCenterText(chart, '<?= $persentaseProgress ?>%'),
            }],
        });

        // Donut Chart 3
        const donut3 = new Chart(document.getElementById('donutChart3'), {
            type: 'doughnut',
            data: {
                labels: ['Not Started', 'Remaining'],
                datasets: [{
                    data: [
                        <?= $persentaseNotStarted ?>,
                        <?= $persentaseSisa3 ?>
                    ],
                    backgroundColor: ['#007bff', '#e9ecef'],
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    tooltip: {
                        enabled: false
                    },
                    legend: {
                        display: false
                    },
                },
            },
            plugins: [{
                id: 'centerText3',
                afterDraw: chart => addCenterText(chart, '<?= $persentaseNotStarted ?>%'),
            }],
        });

        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        // Get view count from localStorage
        let viewCount = localStorage.getItem('dashboardViews') || 0;

        // Increment view count
        viewCount++;

        // Save updated view count to localStorage
        localStorage.setItem('dashboardViews', viewCount);

        // Display the view count
        document.getElementById('viewCountDisplay').textContent = `${viewCount} views`;
    </script>
@endsection
