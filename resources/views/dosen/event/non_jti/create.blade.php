<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<form action="{{ url('event_dosen/non-jti/store') }}" method="POST" id="form-tambah-non-jti" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Tambah Event Non JTI</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
                <div class="container-fluid">
                    <!-- Basic Event Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_code">Kode Event</label>
                                <input type="text" name="event_code" id="event_code"
                                       class="form-control" placeholder="Isi kode event" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_name">Nama Event</label>
                                <input type="text" name="event_name" id="event_name"
                                       class="form-control" placeholder="Isi nama event" required>
                            </div>
                        </div>
                    </div>

                    <!-- Event Type -->
                    <div class="form-group">
                        <label for="jenis_event_id">Jenis Event</label>
                        <select name="jenis_event_id" id="jenis_event_id" class="form-control" required>
                            <option value="">- Pilih Jenis Event -</option>
                            @foreach ($jenisEvent as $item)
                                @if($item->jenis_event_id == 3)
                                    <option value="{{ $item->jenis_event_id }}">
                                        {{ $item->jenis_event_name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Event Dates -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date"
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date"
                                       class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <!-- Event Description -->
                    <div class="form-group">
                        <label for="event_description">Deskripsi Event</label>
                        <textarea name="event_description" id="event_description"
                                  class="form-control" rows="3"
                                  placeholder="Deskripsi event"></textarea>
                    </div>

                    <!-- Assignment Letter Upload -->
                    <div class="form-group">
                        <label for="assign_letter">Surat Tugas</label>
                        <div class="custom-file">
                            <input type="file" name="assign_letter" id="assign_letter"
                                   class="custom-file-input" required>
                            <label class="custom-file-label" for="assign_letter">Pilih file...</label>
                        </div>
                        <small class="form-text text-muted">
                            Format: JPG, JPEG, PNG, atau PDF. Maksimal ukuran file 10MB.
                        </small>
                    </div>

                    <!-- Participants Section -->
                    <div id="dynamic-fields">
                        <div class="participant-row mb-3">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <select name="participant[0][jabatan_id]" class="form-control" required>
                                            <option value="">Pilih Jabatan</option>
                                            @foreach($jabatan as $j)
                                                <option value="{{ $j->jabatan_id }}">
                                                    {{ $j->jabatan_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Partisipan</label>
                                        <select name="participant[0][user_id]" class="form-control" required>
                                            <option value="">Pilih Dosen</option>
                                            @foreach($user as $dosen)
                                                <option value="{{ $dosen->user_id }}">
                                                    {{ $dosen->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </div>
</form>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- JavaScript -->
<script>
$(document).ready(function() {
    // Add custom validation method for file size
    $.validator.addMethod('filesize', function(value, element, param) {
    if (element.files.length > 0) {
        return element.files[0].size <= param * 1024 * 1024; // Convert to MB
    }
    return true;
}, 'Ukuran file tidak boleh lebih dari {0} MB');

    // Add custom validation method for file extension
    $.validator.addMethod('extension', function(value, element, param) {
        param = typeof param === 'string' ? param.replace(/,/g, '|') : 'png|jpe?g|pdf';
        return this.optional(element) || value.match(new RegExp('\\.(' + param + ')$', 'i'));
    }, 'Format file tidak valid');
    
    // Setup AJAX CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Custom file input
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Form validation
    $("#form-tambah-non-jti").validate({
        rules: {
            event_code: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
            event_name: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            jenis_event_id: {
                required: true
            },
            start_date: {
                required: true
            },
            end_date: {
                required: true
            },
            event_description: {
                required: true,
                minlength: 5
            },
            assign_letter: {
                required: true,
                extension: "jpg,jpeg,png,pdf",
                filesize: 10 // 10MB in KB
            }
        },
        messages: {
            event_code: {
                required: "Kode event wajib diisi",
                minlength: "Kode event minimal 3 karakter",
                maxlength: "Kode event maksimal 50 karakter"
            },
            event_name: {
                required: "Nama event wajib diisi",
                minlength: "Nama event minimal 3 karakter",
                maxlength: "Nama event maksimal 100 karakter"
            },
            jenis_event_id: {
                required: "Jenis event wajib dipilih"
            },
            start_date: {
                required: "Tanggal mulai wajib diisi"
            },
            end_date: {
                required: "Tanggal selesai wajib diisi"
            },
            event_description: {
                required: "Deskripsi event wajib diisi",
                minlength: "Deskripsi minimal 5 karakter"
            },
            assign_letter: {
                required: "Surat tugas wajib diupload",
                extension: "File harus berformat JPG, JPEG, PNG, atau PDF",
                filesize: "Ukuran file tidak boleh lebih dari 10MB"
            }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData(form);

            $.ajax({
                url: form.action,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.close();

                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message || 'Data berhasil disimpan',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#modal-non-jti').modal('hide');
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message || 'Terjadi kesalahan',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.close();

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = '<ul>';
                        Object.keys(errors).forEach(key => {
                            errorMessage += `<li>${errors[key][0]}</li>`;
                        });
                        errorMessage += '</ul>';

                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            html: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal mengirim data. Silakan coba lagi.',
                            confirmButtonText: 'OK'
                        });
                    }

                    console.error("Error details:", {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });
                }
            });
            return false;
        }
    });
});
</script>