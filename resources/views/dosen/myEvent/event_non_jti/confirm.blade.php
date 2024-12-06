@empty($event)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('/event') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/event/' . $event->event_id . '/delete_ajax') }}" method="POST" id="form-delete-non-jti">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-md" role="document">
            <div class="modal-content" style="border-radius: 15px; padding: 20px;">
                <div class="modal-body">
                    <h5 class="font-weight-bold" style="color: #212529;">Nama Event</h5>
                    <div class="alert alert-warning text-center" style="border-radius: 8px;">
                        <h6 class="font-weight-bold">Konfirmasi !!!</h6>
                        <p>Apakah Anda ingin menghapus data di bawah ini?</p>
                    </div>
                    <div class="form-group">
                        <label>Eksternal</label>
                        <p style="color: #212529;">{{ $event->event_description }}</p>
                    </div>
                    <div class="form-group">
                        <label>Pelaksanaan</label>
                        <p style="color: #212529;">{{ $event->start_date }}</p>
                    </div>
                    <div class="form-group">
                        <label>Nama PIC</label>
                        <input type="text" class="form-control" value="{{ $event->eventParticipant->user->name }}" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal" style="width: 100px;">Batal</button>
                    <button type="submit" class="btn btn-danger" style="width: 100px;">Hapus</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-delete-non-jti").validate({
                rules: {},
                submitHandler: function(form) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#ffc107',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: form.action,
                                type: form.method,
                                data: $(form).serialize(),
                                success: function(response) {
                                    if (response.status) {
                                        $('#modal-master').modal('hide');
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil',
                                            text: response.message
                                        });
                                        dataEvent.ajax.reload();
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal',
                                            text: response.message
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Terjadi Kesalahan',
                                        text: xhr.responseJSON.message
                                    });
                                }
                            });
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endempty
