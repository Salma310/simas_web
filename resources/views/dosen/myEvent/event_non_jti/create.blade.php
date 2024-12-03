<form action="{{ url('/event/non-jti/add') }}" method="POST" id="form-tambah-non-jti">
    @csrf
    <div id="modal-non-jti" class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:15px;">
            <div class="modal-header -primary" style="background-color: #007bff">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Event Non JTI</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto; max-height:600px; scrollbar-width: thin;">
                <!-- Nama Event -->
                <div class="form-group">
                    <label>Nama Event</label>
                    <input type="text" name="event_name" id="event_name" class="form-control"
                        placeholder="Isi nama event" required>
                </div>

                <!-- Kode Event -->
                <div class="form-group">
                    <label>Kode Event</label>
                    <input type="text" name="event_code" id="event_code" class="form-control"
                        placeholder="Isi kode event" required>
                </div>

                <!-- PIC -->
                <div class="form-group">
                    <label>PIC</label>
                    <input type="text" name="pic" id="pic" class="form-control" placeholder="Isi Nama PIC" required>
                </div>

                <!-- Tanggal Pelaksanaan -->
                <div class="form-group">
                    <label>Tanggal Pelaksanaan</label>
                    <input type="date" name="event_date" id="event_date" class="form-control" required>
                </div>

                <!-- Deskripsi Event -->
                <div class="form-group">
                    <label>Deskripsi Event</label>
                    <textarea name="event_description" id="event_description" class="form-control"
                        placeholder="Deskripsi event" rows="3"></textarea>
                </div>

                <!-- Surat Tugas -->
                <div class="form-group">
                    <label>Surat Tugas</label>
                    <input type="file" name="assignment_letter" id="assignment_letter" class="form-control-file"
                        accept=".jpg, .png, .pdf" required>
                    <small class="form-text text-muted">JPG, PNG, atau PDF. Maksimal ukuran file 10MB.</small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </div>
</form>
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