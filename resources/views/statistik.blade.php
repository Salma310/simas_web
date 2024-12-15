@extends('layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Beban Kerja Dosen</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 70%;
            max-width: 1000px;
            text-align: center;
        }

        canvas {
            margin: 20px 0;
            display: block;
            max-width: 100%;
            height: auto;
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-size: 14px;
        }

        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container-fluid d-flex justify-content-center">
        <div class="card">
            <h3 class="text-left">Beban Kerja Dosen</h3>
            <canvas id="bobotChart"></canvas>
            <div class="navigation-buttons">
                <button id="prevBtn" onclick="prevPage()" disabled>Previous</button>
                <button id="nextBtn" onclick="nextPage()">Next</button>
            </div>
        </div>
    </div>

    <div class="modal fade show" id="myModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="roleModalLabel" aria-hidden="true"></div>

    <script>
        const ctx = document.getElementById('bobotChart').getContext('2d');

        const allData = @json($data);

    const itemsPerPage = 6;
    let currentPage = 0;

    function getPageData(page) {
        const start = page * itemsPerPage;
        const end = start + itemsPerPage;
        return allData.slice(start, end);
    }

    function updateChart() {
        const pageData = getPageData(currentPage);
        const labels = pageData.map(item => item.name);
        const data = pageData.map(item => item.total_events);

        chart.data.labels = labels;
        chart.data.datasets[0].data = data;
        chart.update();

        document.getElementById('prevBtn').disabled = currentPage === 0;
        document.getElementById('nextBtn').disabled = (currentPage + 1) * itemsPerPage >= allData.length;
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
                label: "Beban Kerja",
                data: [],
                backgroundColor: "#007bff",
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                title: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true
                    }
                }
            }
        }
    });

    // Initialize the chart with the first page of data
    updateChart();
    </script>
</body>
</html>
@endsection
