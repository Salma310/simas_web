@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Beban Kerja Dosen</h3>
            <div class="d-flex align-items-center">
                <label for="periodFilter" class="mr-2">Pilih Periode:</label>
                <select id="periodFilter" class="form-control">
                    @foreach($periods as $period)
                        <option value="{{ $period->period }}" {{ $selectedPeriod == $period->period ? 'selected' : '' }}>
                            {{ $period->period }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:60vh; width:100%">
                <canvas id="bobotChart"></canvas>
            </div>
            <div class="navigation-buttons mt-3 d-flex justify-content-between">
                <button id="prevBtn" class="btn btn-primary" onclick="prevPage()" disabled>Previous</button>
                <div id="pageInfo" class="align-self-center"></div>
                <button id="nextBtn" class="btn btn-primary" onclick="nextPage()">Next</button>
            </div>
        </div>
    </div>

    <!-- Tabel Detail -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Detail Beban Kerja</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Dosen</th>
                            <th>Total Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($workloadData as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $data->user->name }}</td>
                                <td>{{ number_format($data->total_points, 1) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('bobotChart').getContext('2d');

    const workloadData = @json($workloadData);
    const itemsPerPage = 38;
    let currentPage = 0;

    // Ubah format data untuk chart
    const allData = workloadData.map(item => ({
        name: item.user.name,
        value: item.total_points
    }));

    function updatePageInfo() {
        const totalPages = Math.ceil(allData.length / itemsPerPage);
        document.getElementById('pageInfo').textContent =
            `Halaman ${currentPage + 1} dari ${totalPages}`;
    }

    function getPageData(page) {
        const start = page * itemsPerPage;
        const end = start + itemsPerPage;
        return allData.slice(start, end);
    }

    function updateChart() {
        const pageData = getPageData(currentPage);
        const labels = pageData.map(item => item.name);
        const data = pageData.map(item => item.value);

        chart.data.labels = labels;
        chart.data.datasets[0].data = data;
        chart.update();

        document.getElementById('prevBtn').disabled = currentPage === 0;
        document.getElementById('nextBtn').disabled =
            (currentPage + 1) * itemsPerPage >= allData.length;

        updatePageInfo();
    }

    function nextPage() {
        if ((currentPage + 1) * itemsPerPage < allData.length) {
            currentPage++;
            updateChart();
        }
    }

    function prevPage() {
        if (currentPage > 0) {
            currentPage--;
            updateChart();
        }
    }

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: "Total Poin",
                data: [],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Statistik Beban Kerja Periode ' + @json($selectedPeriod),
                    font: {
                        size: 16
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Poin'
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });

    // Initialize the chart
    updateChart();

    // Handle period filter changes
    document.getElementById('periodFilter').addEventListener('change', function() {
        window.location.href = '{{ route("statistik.index") }}?period=' + this.value;
    });
</script>
@endsection
