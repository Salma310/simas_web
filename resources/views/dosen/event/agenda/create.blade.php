<html>
<head>
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
    <form action="{{ route('agenda.store', ['id' => $event->event_id]) }}" method="POST" id="form-tambah-agenda">
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
                        <div class="custom-file">
                            <input type="file"
                                name="dokumen_pendukung"
                                id="dokumen_pendukung"
                                class="form-control"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                            <small class="text-muted">
                                Jenis file yang diizinkan: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG
                                (Maks. 5MB)
                            </small>
                            <small id="error-dokumen_pendukung" class="error-text"></small>
                        </div>
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
        $(document).ready(function() {
            $("#form-tambah-agenda").validate({
                rules: {
                    nama_agenda: { required: true, minlength: 3 },
                    start_date: { required: true, date: true },
                    end_date: { required: true, date: true, greaterThan: "#start_date" },
                    tempat: { required: true },
                    jabatan_id: { required: true, number: true },
                    status: { required: true }
                    dokumen_pendukung: {
                        extension: "pdf|doc|docx|xls|xlsx|jpg|jpeg|png",
                        filesize: 5242880 // 5 MB dalam bytes
                    }
                },
                messages: {
                    end_date: {
                        greaterThan: "Tanggal selesai harus setelah tanggal mulai"
                    }
                    dokumen_pendukung: {
                        extension: "Harap unggah file dengan format yang diizinkan",
                        filesize: "Ukuran file maksimal 5 MB"
                    }
                },
                submitHandler: function(form) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: $(form).attr('action'),
                        type: 'POST',
                        data: new FormData(form),  // Gunakan FormData untuk file upload
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $('button[type="submit"]').prop('disabled', true);
                        },
                        success: function(response) {
                            if (response.status) {
                                form.reset();
                                $('#agendaModal').modal('hide');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });

                                // Refresh DataTable
                                if (agendaTable) {
                                    agendaTable.ajax.reload();
                                }

                            } else {
                                $('.error-text').text('');
                                if (response.msgField) {
                                    $.each(response.msgField, function(prefix, val) {
                                        $('#error-' + prefix).text(val[0]);
                                    });
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan pada server'
                            });
                        },
                        complete: function() {
                            $('button[type="submit"]').prop('disabled', false);
                        }
                    });
                    return false;
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.next(".error-text"));
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>
</html>
