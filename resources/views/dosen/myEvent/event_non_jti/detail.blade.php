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
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('/event') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #007bff">
                <h5 class="modal-title" id="exampleModalLabel">{{ $event->event_name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Eksternal</strong></p>
                <p>{{ $event->event_description }}</p>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Pelaksanaan:</strong></p>
                        <p>{{ \Carbon\Carbon::parse($event->start_date)->format('d F Y') }}</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ url('event/download-surat-tugas/'.$event->id) }}" class="btn btn-primary">
                            <i class="fas fa-download"></i> Surat Tugas
                        </a>
                    </div>
                </div>
                <hr>
                <p><strong>Nama PIC:</strong></p>
                <p>{{ $event->pic->name }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
@endempty
<script>
    $(document).ready(function() {
        $("#form-tambah-non-jti").validate({
            rules: {
                event_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                event_code: {
                    required: true,
                    minlength: 3,
                    maxlength: 10
                },
                pic: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                event_date: {
                    required: true,
                    date: true
                },
                event_description: {
                    required: true,
                    minlength: 5
                },
                assignment_letter: {
                    required: true,
                    extension: "jpg|png|pdf",
                    filesize: 10485760 // 10MB in bytes
                }
            },
            messages: {
                assignment_letter: {
                    extension: "Hanya file JPG, PNG, atau PDF yang diperbolehkan.",
                    filesize: "File tidak boleh lebih dari 10MB."
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status) {
                            $('#modal-non-jti').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            // Reload data table or list
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            }
        });
    });
</script>    