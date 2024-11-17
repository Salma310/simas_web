@extends('layouts.template')

@section('content')

<div class="container-fluid px-4">
    <!-- Statistik Utama -->
    <div class="row d-flex justify-content-between">
        <!-- Jumlah User -->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="small-box bg-info" style="border-radius: 15px;">
            <div class="inner">
              <h3>20</h3>
              <p>Jumlah Event</p>
            </div>
            <div class="icon">
              <i class="fas fa-calendar"></i>
            </div>
            <a href="#" class="small-box-footer" style="border-radius: 0 0 15px 15px;">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        
        <!-- Jumlah Event -->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="small-box bg-success" style="border-radius:15px;">
            <div class="inner">
              <h3>25</h3>
              <p>Jumlah User</p>
            </div>
            <div class="icon">
              <i class="fas fa-user"></i>
            </div>
            <a href="#" class="small-box-footer" style="border-radius: 0 0 15px 15px;">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        
        <!-- Rata-Rata Sesi -->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="small-box bg-warning" style="border-radius: 15px;">
            <div class="inner">
              <h3>2m 34s</h3>
              <p>Rata-Rata Sesi</p>
            </div>
            <div class="icon">
              <i class="fas fa-clock"></i>
            </div>
            <a href="#" class="small-box-footer" style="border-radius: 0 0 15px 15px;">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
    </div>

    <!-- Chart dan Event Aktif -->
    <div class="row d-flex justify-content-between">
      <div class="col-lg-9">
          <div class="card" style="border-radius: 15px">
              <div class="card-header">
                  <h3 class="card-title">Event</h3>
              </div>
              <div class="card-body">
                  <div class="row d-flex justify-content-around">
                      <!-- Grafik Donut 1 -->
                      <div class="col-6 col-md-2 text-center">
                          <canvas id="donutChart1"></canvas>
                          <div class="knob-label">Event Done</div>
                      </div>
                      <!-- Grafik Donut 2 -->
                      <div class="col-6 col-md-2 text-center">
                          <canvas id="donutChart2"></canvas>
                          <div class="knob-label">Event In Progress</div>
                      </div>
                      <!-- Grafik Donut 3 -->
                      <div class="col-6 col-md-2 text-center">
                          <canvas id="donutChart3"></canvas>
                          <div class="knob-label">Total Event</div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  
      <!-- Active Progress Event -->
      <div class="col-lg-3 mb-4">
          <div class="card" style="border-radius: 15px">
              <div class="card-body">
                  <h5 class="card-title">Active Progress Event</h5>
                  <p class="card-text text-secondary">Event dalam waktu dekat</p>
                  <ul class="list-group list-group-flush">
                      <li class="list-group-item">Seminar - 14/10/2024</li>
                      <li class="list-group-item">Pelatihan - 20/10/2024</li>
                      <li class="list-group-item">JTI Fest - 05/11/2024</li>
                      <li class="list-group-item">Fun Sport JTI - 01/12/2024</li>
                  </ul>
              </div>
          </div>
      </div>
  </div>
  

    <!-- Grafik Session Bulanan -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card" style="border-radius: 15px">
                <div class="card-body">
                    <h5 class="card-title">Session</h5>
                    <div>
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
    // Contoh inisialisasi Chart.js untuk sesi bulanan
    const ctx = document.getElementById('sessionChart').getContext('2d');
    const sessionChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Sessions',
                data: [100, 200, 150, 300, 250, 100, 220, 190, 200, 180, 220, 240],
                backgroundColor: '#007bff',
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

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
    const donut1 = new Chart(document.getElementById('donutChart1'), {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Remaining'],
            datasets: [{
                data: [62, 38],
                backgroundColor: ['#28a745', '#e9ecef'],
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                tooltip: { enabled: false },
                legend: { display: false },
            },
        },
        plugins: [{
            id: 'centerText1',
            afterDraw: chart => addCenterText(chart, '62%'),
        }],
    });

    // Donut Chart 2
    const donut2 = new Chart(document.getElementById('donutChart2'), {
        type: 'doughnut',
        data: {
            labels: ['In Progress', 'Remaining'],
            datasets: [{
                data: [22, 78],
                backgroundColor: ['#ffc107', '#e9ecef'],
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                tooltip: { enabled: false },
                legend: { display: false },
            },
        },
        plugins: [{
            id: 'centerText2',
            afterDraw: chart => addCenterText(chart, '22%'),
        }],
    });

    // Donut Chart 3
    const donut3 = new Chart(document.getElementById('donutChart3'), {
        type: 'doughnut',
        data: {
            labels: ['Total Events', 'Remaining'],
            datasets: [{
                data: [81, 19],
                backgroundColor: ['#007bff', '#e9ecef'],
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                tooltip: { enabled: false },
                legend: { display: false },
            },
        },
        plugins: [{
            id: 'centerText3',
            afterDraw: chart => addCenterText(chart, '81%'),
        }],
    });
</script>

@endsection
