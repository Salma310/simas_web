<style>
    /* Reset default styling */
    .modal-dialog {
        max-width: 800px;
        margin: 1.75rem auto;
    }

    .modal-content {
        border-radius: 15px !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }

    .modal-header {
        background: linear-gradient(to right, #4a90e2, #2c3e50) !important;
        color: white !important;
        border-top-left-radius: 15px !important;
        border-top-right-radius: 15px !important;
        padding: 15px !important;
    }

    .modal-title {
        font-weight: 700 !important;
        color: white !important;
    }

    .modal-body {
        background-color: #f8f9fa !important;
        padding: 25px !important;
    }

    .table {
        margin-bottom: 20px !important;
        border-collapse: collapse; /* Menghilangkan space antara border */
    }

    .detail-table th {
        background: linear-gradient(to right, #4a90e2, #2c3e50) !important; /* Gaya gradien */
        color: white !important;
        font-weight: 700 !important;
        border-bottom: 2px solid #dee2e6 !important;
        padding: 12px !important; /* Menambahkan padding */
        text-align: left; /* Rata kiri untuk header */
    }

    .detail-table td {
        vertical-align: middle !important;
        transition: all 0.3s ease !important;
        padding: 12px !important; /* Menambahkan padding */
        border-bottom: 1px solid #dee2e6; /* Garis pemisah halus */
    }

    .table tr:hover {
        background-color: rgba(74,144,226,0.1) !important; /* Warna hover yang lebih lembut */
        box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important; /* Efek bayangan saat hover */
    }

    .table th, .table td {
        border-radius: 5px; /* Sudut melengkung untuk sel */
    }

    .table-responsive-sm {
        overflow-x: auto; /* Memastikan tabel responsif */
    }

    /* Gaya untuk tabel partisipan dan agenda */
    .table-participant, .table-agenda {
        margin-top: 20px; /* Jarak antar tabel */
    }

    .table-participant th, .table-agenda th {
        background-color: #007bff; /* Gaya header untuk tabel partisipan dan agenda */
        color: white;
    }

    .table-participant td, .table-agenda td {
        background-color: #f8f9fa; /* Warna latar belakang untuk sel */
    }

    .btn-warning {
        background: linear-gradient(to right, #ff9800, #f44336) !important;
        border: none !important;
        color: white !important;
        transition: all 0.3s ease !important;
    }

    .btn-warning:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 15px rgba(244,67,54,0.3) !important;
    }

    .alert-danger {
        background-color: #f8d7da !important;
        color: #721c24 !important;
        border-radius: 10px !important;
    }
</style>
@empty($event)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/event') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped detail-table">
                    <tr>
                        <th class="text-right col-3">Nama Event :</th>
                        <td class="col-9">{{ $event->event_name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Kode Event :</th>
                        <td class="col-9">{{ $event->event_code }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Jenis Event :</th>
                        <td class="col-9">{{ $event->jenisEvent->jenis_event_name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Tanggal Mulai :</th>
                        <td class="col-9">{{ $event->start_date }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Tanggal Selesai :</th>
                        <td class="col-9">{{ $event->end_date }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Deskripsi Event :</th>
                        <td class="col-9">{{ $event->event_description }}</td>
                    </tr>
                </table>

                <!-- Tabel untuk Jabatan dan Partisipan -->
                <h5 class="mt-4">Daftar Partisipan dan Jabatan</h5>
                <table class="table table-responsive-sm table-bordered table-striped detail-table">
                    <thead>
                        <tr>
                            <th class="text-center">Partisipan</th>
                            <th class="text-center">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($eventParticipant as $participant)
                        <tr>
                            <td>{{ $participant->user->name }}</td>
                            <td>{{ $participant->position->jabatan_name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <h5 class="mt-4">List Agenda</h5>
                <table class="table table-sm table-bordered table-striped detail-table">
                    <thead>
                        <tr>
                            <th class="text-center">Agenda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agenda as $a)
                        <tr>
                            <td>{{ $a->nama_agenda }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
@endempty
