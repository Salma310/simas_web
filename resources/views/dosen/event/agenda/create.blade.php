<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <style>
        body {
            background-color: #f8f9fa;
        }
        .modal-content {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        .modal-header {
            border-bottom: none;
            background-color: #007bff;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-title {
            margin: 0;
            font-size: 1.25rem;
        }
        .close {
            color: white;
            opacity: 0.8;
            font-size: 1.5rem;
            border: none;
            background: none;
        }
        .close:hover {
            color: white;
            opacity: 1;
        }
        .modal-body {
            padding: 20px;
        }
        .form-label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
        }
        .error-text {
            font-size: 0.875rem;
            color: #dc3545;
            margin-top: 5px;
        }
        .modal-footer {
            border-top: none;
            padding: 15px 20px;
            display: flex;
            justify-content: flex-end;
        }
        .btn {
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-yellow {
            background-color: #ffc107;
            color: black;
            margin-right: 10px;
        }
        .btn-yellow:hover {
            background-color: #e0a800;
        }
        .btn-blue {
            background-color: #007bff;
            color: white;
        }
        .btn-blue:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Modal -->
    <form action="{{ route('agenda.store', ['id' => $event->event_id]) }}" method="POST" enctype="multipart/form-data" id="form-tambah-agenda">
        @csrf
        <div id="agendaModal" class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Agenda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="event_id" value="{{ $event->event_id }}">

                    <div class="mb-3 form-group">
                        <label for="nama_agenda" class="form-label">Nama Agenda</label>
                        <input type="text" name="nama_agenda" id="nama_agenda" class="form-control" required>
                        <small id="error-nama_agenda" class="error-text"></small>
                    </div>

                    <div class="form-row">
                        <div class="mb-3 form-group col-md-6">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                            <small id="error-start_date" class="error-text"></small>
                        </div>
                        <div class="mb-3 form-group col-md-6">
                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                            <small id="error-end_date" class="error-text"></small>
                        </div>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="tempat" class="form-label">Tempat</label>
                        <input type="text" name="tempat" id="tempat" class="form-control" required>
                        <small id="error-tempat" class="error-text"></small>
                    </div>

                    <div class="mb-3 form-group">
                        <label>Jabatan</label>
                        <select name="jabatan_id" id="jabatan_id" class="form-control" required>
                            <option value="">- Pilih Jabatan -</option>
                            @foreach($event->participants as $participant)
                                @if($participant->position)
                                    <option value="{{ $participant->position->jabatan_id }}">
                                        {{ $participant->position->jabatan_name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <small id="error-jabatan_id" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">Pilih Status</option>
                            <option value="not started">not started</option>
                            <option value="progress">progress</option>
                            <option value="done">done</option>
                        </select>
                        <small id="error-status" class="error-text"></small>
                    </div>

                    <!-- Tambahkan input file setelah bagian status -->
                    <div class="mb-3 form-group">
                        <label for="dokumen_pendukung" class="form-label">Dokumen Pendukung</label>
                        <input type="file"
                               name="dokumen_pendukung[]"
                               id="dokumen_pendukung"
                               class="form-control"
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"multiple>
                        <small id="error-dokumen_pendukung" class="error-text text-danger"></small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-yellow" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-blue" id="submit-agenda">Tambah</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function () {
            $.validator.addMethod("validateFile", function(value, element, param) {
            // Jika tidak ada file yang dipilih, dianggap valid (opsional)
            if (element.files.length === 0) {
                return true;
            }

            // Ambil file yang dipilih
            var file = element.files[0];

            // Daftar ekstensi yang diizinkan
            var allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png'];

            // Daftar MIME type yang diizinkan
            var allowedMimeTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'image/jpeg',
                'image/png'
            ];

            // Ambil ekstensi file
            var fileExtension = file.name.split('.').pop().toLowerCase();

            // Validasi ekstensi
            if ($.inArray(fileExtension, allowedExtensions) === -1) {
                return false;
            }

            // Validasi MIME type
            if ($.inArray(file.type, allowedMimeTypes) === -1) {
                return false;
            }

            // Validasi ukuran file (5MB = 5242880 bytes)
            if (file.size > 5242880) {
                return false;
            }

            return true;
        }, "File harus berupa PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, atau PNG dengan ukuran maksimal 5MB");


        // Tambahkan metode validasi kustom untuk tanggal
        $.validator.addMethod("greaterThan", function (value, element, param) {
            var startDate = $(param).val();
            return Date.parse(value) >= Date.parse(startDate);
        }, "Tanggal selesai harus setelah atau sama dengan tanggal mulai");

        // Validasi form dengan jQuery Validation
        $("#form-tambah-agenda").validate({
            rules: {
                nama_agenda: { required: true, minlength: 3 },
                start_date: { required: true, date: true },
                end_date: { required: true, date: true, greaterThan: "#start_date" },
                tempat: { required: true },
                jabatan_id: { required: true, number: true },
                status: { required: true },
                'dokumen_pendukung[]': {
                    validateFile: true
                }
            },
            messages: {
                end_date: {
                    greaterThan: "Tanggal selesai harus setelah tanggal mulai"
                },
                dokumen_pendukung: {
                    validateFile: "Pastikan file sesuai ketentuan (maks 5MB, format: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG)"
                }
            },
            submitHandler: function (form) {
            console.log("submitHandler berjalan");
            var formData = new FormData(form);

            // Nonaktifkan tombol submit dan ubah teksnya
            $('#submit-agenda').prop('disabled', true).text('Mengirim...');

            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            console.log(percentComplete);
                        }
                    }, false);
                    return xhr;
                },
                success: function (response) {
                    console.log(response);
                    if (response.status) {
                        $('#agendaModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        }).then((result) => {
                            if (result.isConfirmed || result.isDismissed) {
                                agendaTable.ajax.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Terjadi kesalahan'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan pada server. Silakan coba lagi.'
                    });
                },
                complete: function () {
                    $('#submit-agenda').prop('disabled', false).text('Tambah');
                }
            });

            return false; // Mencegah submit form biasa
        }
        });

        // Validasi saat memilih file
        $("#dokumen_pendukung").on('change', function () {
            var file = this.files[0];
            if (file) {
                console.log("File dipilih:");
                console.log("Nama: " + file.name);
                console.log("Ukuran: " + file.size + " bytes");
                console.log("Tipe: " + file.type);
            }
        });
    });
    </script>

</body>
</html>
