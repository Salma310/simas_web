@extends('layouts.template')

@section('content')
    <html>

    <head>
        <style>
            body {
                background-color: #f0f2f5;
            }

            .card {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                border: none;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                position: relative;
                background-color: #fff;
                text-decoration: none;
                color: inherit;
            }

            .card:hover {
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
                transform: scale(1.02);
                transition: 0.3s;
            }

            .card-body {
                flex-grow: 1;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            .card-title {
                font-size: 1.25rem;
                font-weight: bold;
                margin-bottom: 10px;
            }

            .card-text {
                color: #6c757d;
                overflow: hidden;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                /* Batasi maksimal 4 baris */
                -webkit-box-orient: vertical;
                text-overflow: ellipsis;
                max-height: 60px;
                /* Sesuaikan dengan jumlah baris yang ingin ditampilkan */
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
                    <a href="javascript:void(0)" onclick="modalAction('{{ route('event.show', $event->event_id) }}')"
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
                                <h5 class="card-title mb-0">{{ $event->event_name }}</h5>
                                @foreach ($jenisEvent as $j)
                                    @if ($j->jenis_event_id == $event->jenis_event_id)
                                        <h6 class="card-text mt-0" style="font-size: 1.1rem;">
                                            {{ $j->jenis_event_name }}</h6>
                                    @endif
                                @endforeach
                                <p class="card-text" data-full-text="{{ $event->event_description }}">
                                    {{ $event->event_description }}
                                </p>
                                {{-- <span class="read-more" style="color: #007bff; cursor: pointer; display: none;">Lihat lebih lanjut</span> --}}

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

        document.addEventListener("DOMContentLoaded", function() {
            const cards = document.querySelectorAll('.card');

            cards.forEach(card => {
                const cardText = card.querySelector('.card-text');
                const readMore = card.querySelector('.read-more');

                // Cek apakah teks melampaui dua baris
                if (cardText.scrollHeight > cardText.offsetHeight) {
                    readMore.style.display = 'inline'; // Tampilkan teks "Lihat lebih lanjut"
                } else {
                    readMore.style.display = 'none'; // Sembunyikan jika tidak perlu
                }

                // Interaksi untuk "Lihat lebih lanjut"
                readMore.addEventListener('click', function() {
                    cardText.style.display = 'block'; // Tampilkan teks penuh
                    cardText.style.webkitLineClamp = 'unset'; // Batalkan pembatasan baris
                    readMore.style.display = 'none'; // Sembunyikan tombol
                });
            });
        });
    </script>
@endsection
