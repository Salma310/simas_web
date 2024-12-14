<form action="{{ url('/myevent/non-jti/add') }}" method="POST" id="form-tambah-non-jti" enctype="multipart/form-data">
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

                <!-- Jenis Event -->
                <div class="form-group">
                    <label>Kode Jenis Event</label>
                    <input type="text" name="jenis_event_id" id="jenis_event_id" class="form-control"
                        placeholder="Pilih kode Jenis Event" required>
                </div>

                <!-- Kode Event -->
                <div class="form-group">
                    <label>Kode Event</label>
                    <input type="text" name="event_code" id="event_code" class="form-control"
                        placeholder="Isi kode event" required>
                </div>

                <!-- Tanggal Mulai dan Tanggal Selesai -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                    </div>
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
                    <input type="file" name="assign_letter" id="assign_letter" class="form-control-file" required>
                    <small class="form-text text-muted">JPG, JPEG, PNG, atau PDF. Maksimal ukuran file 10MB.</small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </div>
</form>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $("#form-tambah-non-jti").validate({
            rules: {
                event_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                jenis_event_id: {
                    required: true,
                    number: true
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
                start_date: {
                    required: true,
                    date: true
                },
                end_date: {
                    required: true,
                    date: true,
                    greaterThan: "#start_date"
                }    
                event_description: {
                    required: true,
                    minlength: 5
                },
                assign_letter: {
                    required: true,
                    extension: "jpg|jpeg|png|pdf",
                    filesize: 10240 // 10MB in bytes
                }
            },
            messages: {
                assign_letter: {
                    extension: "Hanya file JPG, JPEG, PNG, atau PDF yang diperbolehkan.",
                    filesize: "File tidak boleh lebih dari 10MB."
                }
            },
            submitHandler: function(form) {
                const formData = new FormData(form);
                $.ajax({
                    url: form.action,
                    type: 'POST',
                    data: formData,
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
                    },
                    error: function(xhr, status, error) {
                        console.error("Status: " + status);
                        console.error("Error: " + error);
                        console.error("Response: " + xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal mengirim data.'
                        });
                    }
                });
                return false;
            }
        });
    });
</script>