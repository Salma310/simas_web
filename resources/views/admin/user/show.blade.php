<style>
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
</style>
@empty($user)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/user') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data User</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped detail-table">
                    <tr>
                        <th class="text-right col-3">Role :</th>
                        <td class="col-9">{{ $user->role->role_name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Username :</th>
                        <td class="col-9">{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Nama :</th>
                        <td class="col-9">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Email :</th>
                        @if ($user->email == null)
                            <td><span class="badge badge-danger">Email Masih Kosong</span></td>
                        @else
                            <td>{{ $user->email }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th class="text-right col-3">No Telp :</th>
                        @if ($user->phone == null)
                            <td><span class="badge badge-danger">No Telp Masih Kosong</span></td>
                        @else
                            <td>{{ $user->phone }}</td>
                        @endif
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
@endempty
