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
    @empty($jenis)
    <div id="modal-master" class="modal-dialog modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang Anda cari tidak ditemukan
                </div>
                <a href="{{ url('/jenis') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
    @else
    <!-- Modal -->
    <form action="{{ url('/jenis/' . $jenis->jenis_event_id . '/update') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roleModalLabel">Edit Data Jenis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 form-group">
                        <label for="jenis_event_code" class="form-label">Kode Jenis</label>
                        <input type="text" name="jenis_event_code" id="jenis_event_code" class="form-control" value="{{ $jenis->jenis_event_code }}" required>
                        <small id="error-jenis_event_code" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="jenis_event_name" class="form-label">Nama Jenis</label>
                        <input type="text" name="jenis_event_name" id="jenis_event_name" class="form-control" value="{{ $jenis->jenis_event_name }}" required>
                        <small id="error-jenis_event_name" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-yellow" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-blue" id="submit-btn">Simpan</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
        $("#form-edit").validate({
            rules: {
                jenis_event_code: { required: true, minlength: 3, maxlength: 10 },
                jenis_event_name: { required: true, minlength: 3, maxlength: 100 },
            },
            submitHandler: function(form) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: $(form).attr('action'),
                    type: 'PUT',
                    data: $(form).serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        $('button[type="submit"]').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.status) {
                            form.reset();
                            $('#jenisModal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });

                            // Refresh DataTable
                            if (jenisEvent) {
                                jenisEvent.ajax.reload();
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
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
    </script>
    @endempty
</body>
</html>
