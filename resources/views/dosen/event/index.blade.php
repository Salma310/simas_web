@extends('layouts.template')

@section('content')
    <html>

    <head>
        <style>
            body {
                background-color: #f0f2f5;
            }

            .card {
                border: none;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                position: relative;
                background-color: #fff;
                text-decoration: none;
                color: inherit;
                display: flex;
                flex-direction: column;
                height: 400px;
                /* Tinggi tetap untuk setiap card */
            }


            .card:hover {
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
                transform: scale(1.02);
                transition: 0.3s;
            }

            .card-body {
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                flex-grow: 1;
                /* Agar card mengisi ruang vertikal */
            }

            .card-title {
                font-size: 1.25rem;
                font-weight: bold;
                margin-bottom: 10px;
            }

            .card-text {
                color: #6c757d;
                flex-grow: 1;
                /* Memastikan teks berada di ruang kosong */
                overflow: hidden;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                /* Membatasi hanya 2 baris */
                -webkit-box-orient: vertical;
                text-overflow: ellipsis;
            }

            .status {
                color: #f0ad4e;
                font-weight: bold;
                position: absolute;
                top: 20px;
                right: 20px;
            }

            .icon-text {
                display: flex;
                align-items: center;
                font-size: 0.875rem;
                color: #6c757d;
            }

            .icon-text i {
                margin-right: 5px;
            }

            .label {
                font-size: 0.875rem;
                color: #6c757d;
                margin-right: 5px;
            }

            /* From Uiverse.io by garerim
                        .container-input {
                            position: relative;
                            display: flex;
                            justify-content: flex-end;
                            align-items: center;
                        }

                        .input {
                            width: 100%;
                            padding: 10px 0px 10px 20px;
                            border-radius: 9999px;
                            border: solid 1px #333;
                            transition: all .2s ease-in-out;
                            outline: none;
                            opacity: 0.8;
                        }

                        .container-input i {
                            position: absolute;
                            top: 50%;
                            right: 20px;
                            transform: translate(0, -50%);
                        }

                        .input:focus {
                            opacity: 1;
                            width: 25%;
                        } */

            .filters {
                display: flex;
                flex-direction: row;
                gap: 10px;
                /* Jarak antar label */
            }

            .filters label {
                padding: 8px 16px;
                background-color: #f8f9fa;
                border-radius: 16px;
                cursor: pointer;
                font-size: 0.9rem;
                border: 1px solid #ddd;
                transition: background-color 0.2s ease, color 0.2s ease;
            }

            .filters .active[data-status="all"] {
                background-color: #007bff;
                color: white;
            }

            .filters label[data-status="all"]:hover {
                background-color: #007bff;
                color: white;
            }

            .filters .active[data-status="not-started"] {
                background-color: #dc3545;
                color: white;
            }

            .filters label[data-status="not-started"]:hover {
                background-color: #dc3545;
                color: white;
            }


            .filters .active[data-status="in-progress"] {
                background-color: #ffc107;
                color: black;
            }

            .filters label[data-status="in-progress"]:hover {
                background-color: #ffc107;
                color: black;
            }

            .filters .active[data-status="completed"] {
                background-color: #28a745;
                color: white;
            }

            .filters label[data-status="completed"]:hover {
                background-color: #28a745;
                color: white;
            }

            .container-input {
                display: flex;
                align-items: center;
                position: relative;
            }

            .container-input input {
                width: 250px;
                padding: 8px 16px;
                border-radius: 20px;
                border: 1px solid #ddd;
                outline: none;
                transition: all 0.3s ease-in-out;
            }

            .container-input input:focus {
                border-color: #007bff;
                box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
            }

            .container-input i {
                position: absolute;
                right: 16px;
                font-size: 1rem;
                color: #6c757d;
                pointer-events: none;
                /* Ikon tidak dapat diklik */
            }
        </style>
    </head>

    <body>
        <div class="container-fluid px-3">
        <div class="d-flex flex-row justify-content-between align-items-center mb-3">
            <!-- Filter di sebelah kiri -->
            <div class="filters">
                <label for="semua" class="active" data-status="all">Semua</label>
                <label for="Belum Dimulai" data-status="not-started">Belum Dimulai</label>
                <label for="Proses" data-status="in-progress">Proses</label>
                <label for="Selesai" data-status="completed">Selesai</label>
            </div>

                <!-- Search di sebelah kanan -->
                <div class="container-input">
                    <input type="text" id="searchInput" placeholder="Search" name="text" class="input">
                    <i class="fas fa-search"></i>
                </div>
            </div>

            <div class="row">
                @foreach ($events as $event)
                    <!-- Membungkus seluruh kartu dengan <a> -->
                    <a href="{{ route('dosen.event.show', $event->event_id) }}"
                        class="col-md-4 mb-3" style="text-decoration: none;">
                        <div class="card" style="width:100%; height:100%;">
                            <div class="card-body d-flex flex-column justify-content-between">
                                @if ($event->status == 'completed')
                                    <div class="status text-success">Selesai</div>
                                @elseif($event->status == 'progress')
                                    <div class="status text-warning">Proses</div>
                                @else
                                    <div class="status text-danger">Belum Dimulai</div>
                                @endif
                                <h5 class="card-title">{{ $event->event_name }}</h5>
                                @foreach ($jenisEvent as $j)
                                    @if ($j->jenis_event_id == $event->jenis_event_id)
                                        <h6 class="card-text mt-0" style="font-size: 1.1rem;">
                                            {{ $j->jenis_event_name }}</h6>
                                    @endif
                                @endforeach
                                <p class="card-text">{{ $event->event_description }}</p>
                                <div class="d-flex flex-row justify-content-between align-content-end">
                                    <div class="icon-text">
                                        <div class="d-flex flex-column">
                                            <span class="label">Tanggal</span>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-calendar-alt"></i>
                                                <span>{{ \Carbon\Carbon::parse($event->end_date)->format('F d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="icon-text">
                                        <div class="d-flex flex-column">
                                            <span class="label">Jml Anggota</span>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-users"></i>
                                                <span>{{ $event->participants_count }} </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <!-- Pagination Links -->
            {{-- <nav aria-label="Page navigation" class="mt-5">
                <ul class="pagination justify-content-end" id="pagination">
                    @if ($events->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $events->previousPageUrl() }}">Previous</a>
                        </li>
                    @endif

                    @for ($i = 1; $i <= $events->lastPage(); $i++)
                        <li class="page-item {{ $events->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $events->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($events->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $events->nextPageUrl() }}">Next</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">Next</span>
                        </li>
                    @endif
                </ul>
            </nav> --}}
            <div class="modal fade show" id="eventModal" tabindex="-1" role="dialog" data-backdrop="static"
                aria-labelledby="eventModalLabel" aria-hidden="true"></div>
        </div>
    </body>

    </html>
    <script>
        function modalAction(url = '') {
            $('#eventModal').load(url, function() {
                $('#eventModal').modal('show');
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.querySelector('.input');
            const eventCards = document.querySelectorAll('.card');

            searchInput.addEventListener('input', function() {
                const searchValue = searchInput.value.toLowerCase();

                eventCards.forEach(card => {
                    const eventName = card.querySelector('.card-title').textContent.toLowerCase();
                    const eventDescription = card.querySelector('.card-text').textContent
                        .toLowerCase();

                    if (eventName.includes(searchValue) || eventDescription.includes(searchValue)) {
                        card.parentElement.style.display = 'block'; // Tampilkan card
                    } else {
                        card.parentElement.style.display = 'none'; // Sembunyikan card
                    }

                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const filters = document.querySelectorAll(".filters label");
            const eventCards = document.querySelectorAll(".card");

            filters.forEach(filter => {
                filter.addEventListener("click", function() {
                    // Hapus kelas 'active' dari semua filter
                    filters.forEach(f => f.classList.remove("active"));

                    // Tambahkan kelas 'active' ke filter yang diklik
                    this.classList.add("active");

                    // Dapatkan status dari filter yang diklik
                    const status = this.getAttribute("data-status");

                    // Tampilkan atau sembunyikan kartu berdasarkan status
                    eventCards.forEach(card => {
                        const cardStatus = card.querySelector(".status");
                        const cardStatusText = cardStatus.textContent.toLowerCase();

                        // Sesuaikan pencocokan status
                        if (status === "all") {
                            card.parentElement.style.display =
                            "block"; // Tampilkan semua kartu
                        } else if (
                            (status === "not-started" && cardStatusText ===
                            "belum dimulai") ||
                            (status === "in-progress" && cardStatusText === "proses") ||
                            (status === "completed" && cardStatusText === "selesai")
                        ) {
                            card.parentElement.style.display =
                            "block"; // Tampilkan kartu sesuai status
                        } else {
                            card.parentElement.style.display = "none"; // Sembunyikan kartu
                        }
                    });
                });
            });
        });
    </script>
@endsection
