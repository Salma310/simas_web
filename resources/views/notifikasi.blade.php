@empty($notifikasi)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Notifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Notifikasi Kosong</h5>
                    Tidak ada notifikasi sama sekali
                </div>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-md float-right mr-3" role="document">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Notifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="notification-section">
                    <h6 class="notification-category">Today</h6>
                    <div class="notification-item">
                        <img src="adminlte/dist/img/avatar.png" alt="User" class="notification-avatar">
                        <div>
                            <p><strong>Admin</strong> berhasil mengatur acara awal tahun</p>
                            <small>Now</small>
                        </div>
                    </div>
                    <div class="notification-item">
                        <img src="adminlte/dist/img/avatar.png" alt="User" class="notification-avatar">
                        <div>
                            <p><strong>Admin</strong> menambahkan anda ke acara Interkom</p>
                            <small>Now</small>
                        </div>
                    </div>
                    <div class="notification-item">
                        <img src="adminlte/dist/img/avatar.png" alt="User" class="notification-avatar">
                        <div>
                            <p><strong>Admin</strong> berhasil mengatur acara akhir tahun</p>
                            <small>Now</small>
                        </div>
                    </div>
                </div>

                <div class="notification-section">
                    <h6 class="notification-category">Yesterday</h6>
                    <div class="notification-item">
                        <img src="adminlte/dist/img/avatar.png" alt="User" class="notification-avatar">
                        <div>
                            <p><strong>Dina S,Tr</strong> memberikan agenda kegiatan</p>
                            <small>7d ago</small>
                        </div>
                    </div>
                    <div class="notification-item">
                        <img src="adminlte/dist/img/avatar.png" alt="User" class="notification-avatar">
                        <div>
                            <p><strong>Dina S,Tr</strong> memberikan agenda kegiatan</p>
                            <small>7d ago</small>
                        </div>
                    </div>
                </div>

                <div class="notification-section">
                    <h6 class="notification-category">Last Week</h6>
                    <div class="notification-item">
                        <img src="adminlte/dist/img/avatar.png" alt="User" class="notification-avatar">
                        <div>
                            <p><strong>Annisa S,Tr</strong> memberikan agenda kegiatan</p>
                            <small>7d ago</small>
                        </div>
                    </div>
                    <div class="notification-item">
                        <img src="adminlte/dist/img/avatar.png" alt="User" class="notification-avatar">
                        <div>
                            <p><strong>Annisa S,Tr</strong> memberikan agenda kegiatan</p>
                            <small>7d ago</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endempty
<style>
    .notification-header {
        padding: 15px;
        border-bottom: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .notification-body {
        padding: 15px;
    }

    .notification-category {
        font-weight: bold;
        margin-top: 10px;
        color: #555;
    }

    .notification-item {
        display: flex;
        margin-bottom: 10px;
    }

    .notification-item p {
        margin-bottom: 0;
    }

    .notification-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }
</style>