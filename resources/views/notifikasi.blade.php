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
                    @foreach ($notifikasi as $n)
                    <div class="notification-item">
                        <div>
                            <h5>{{$n->title}}</h5>
                            <p>{{$n->message}}</p>
                            <small>Now</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endempty
<style>
    .notification-item {
        display: flex;
        margin-bottom: 10px;
    }

    .notification-item p {
        margin-bottom: 0;
    }
</style>