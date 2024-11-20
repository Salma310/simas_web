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
    <form action="{{ url('/event/' . $event->event_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #007bff">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Event Non JTI</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y: auto; max-height:600px;">
                    <div class="form-group">
                        <label>Nama Event</label>
                        <input value="{{ $event->event_name }}" type="text" name="event_name" id="event_name"
                            class="form-control" required>
                        <small id="error-event_name" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Kode Event</label>
                        <input value="{{ $event->event_code }}" type="text" name="event_code" id="event_code"
                            class="form-control" required>
                        <small id="error-event_code" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>PIC</label>
                        <select name="pic_id" id="pic_id" class="form-control" required>
                            <option value="">Pilih PIC</option>
                            @foreach ($picList as $pic)
                                <option value="{{ $pic->id }}" {{ $pic->id == $event->pic_id ? 'selected' : '' }}>
                                    {{ $pic->name }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-pic_id" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Pelaksanaan</label>
                        <input value="{{ $event->start_date }}" type="date" name="start_date" id="start_date" class="form-control" required>
                        <small id="error-start_date" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Event</label>
                        <textarea name="event_description" id="event_description" class="form-control" placeholder="Deskripsi event"
                            rows="3">{{ $event->event_description }}</textarea>
                        <small id="error-event_description" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Surat Tugas</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="surat_tugas.pdf" disabled>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-danger">X</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </div>
        </div>
    </form>
@endempty
<script>
    $(document).on('click', '.btn-danger', function() {
    // Contoh aksi hapus file
        alert('Surat Tugas akan dihapus.');
    });
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