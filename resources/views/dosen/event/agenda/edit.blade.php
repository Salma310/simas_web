<!DOCTYPE html>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <style>
        .assignee-row {
            background: #f8f9fa;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .error-text {
            color: #dc3545;
            font-size: 80%;
        }
        .current-file {
            padding: 10px;
            margin: 10px 0;
            background: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <form action="{{ route('agenda.update', ['id' => $agenda->event_id, 'id_agenda' => $agenda->agenda_id]) }}" method="POST" enctype="multipart/form-data" id="form-edit-agenda">
    @csrf
    @method('PUT')
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Agenda</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="event_id" value="{{ $agenda->event_id }}">
                <!-- Nama -->
                <div class="mb-3">
                    <label for="nama_agenda" class="form-label">Nama Agenda</label>
                    <input type="text" name="nama_agenda" id="nama_agenda" class="form-control" value="{{ $agenda->nama_agenda }}" required>
                    <small id="error-nama_agenda" class="error-text"></small>
                </div>

                <!-- Tanggal -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                   value="{{ \Carbon\Carbon::parse($agenda->start_date)->format('Y-m-d') }}" required>
                            <small id="error-start_date" class="error-text"></small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                   value="{{ \Carbon\Carbon::parse($agenda->end_date)->format('Y-m-d') }}" required>
                            <small id="error-end_date" class="error-text"></small>
                    </div>
                </div>

                <!-- Lokasi -->
                <div class="mb-3">
                    <label for="tempat" class="form-label">Tempat</label>
                    <input type="text" name="tempat" id="tempat" class="form-control" value="{{ $agenda->tempat }}" required>
                    <small id="error-tempat" class="error-text"></small>
                </div>

                <!-- Posisi -->
                <div class="mb-3">
                    <label>Jabatan</label>
                        <select name="jabatan_id" id="jabatan_id" class="form-control" required>
                            <option value="">- Pilih Jabatan -</option>
                            @foreach($event->participants as $participant)
                                @if($participant->position)
                                    <option value="{{ $participant->position->jabatan_id }}"
                                            {{ $agenda->jabatan_id == $participant->position->jabatan_id ? 'selected' : '' }}>
                                        {{ $participant->position->jabatan_name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    <small id="error-jabatan_id" class="error-text"></small>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="not started" {{ $agenda->status == 'not started' ? 'selected' : '' }}>belum mulai</option>
                        <option value="progress" {{ $agenda->status == 'progress' ? 'selected' : '' }}>proses</option>
                        <option value="completed" {{ $agenda->status == 'completed' ? 'selected' : '' }}>selesai</option>
                    </select>
                    <small id="error-status" class="error-text"></small>
                </div>

                <!-- Dokumen Pendukung -->
                <div class="mb-3">
                    <label for="dokumen_pendukung" class="form-label">Dokumen Pendukung</label>
                    <input type="file"
                           name="dokumen_pendukung[]"
                           id="dokumen_pendukung"
                           class="form-control"
                           accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                           multiple>
                    <small class="form-text text-muted">
                        Format yang diizinkan: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG
                    </small>
                    <small id="error-dokumen_pendukung" class="error-text"></small>
                    @if($agenda->documents->count() > 0)
                        <div class="mt-2">
                            <p>Dokumen saat ini:</p>
                            @foreach($agenda->documents as $document)
                                <div class="document-item">
                                    <a href="{{ Storage::url($document->file_path) }}" target="_blank">{{ $document->file_name }}</a>
                                    <button type="button" class="btn btn-sm btn-danger delete-document" data-id="{{ $document->document_id }}">Hapus</button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Penerima Tugas -->
                <div class="mb-3">
                    <label class="form-label">Penerima Tugas</label>
                    <button type="button" class="btn btn-success btn-sm mb-2" id="addAssignee">
                        + Tambah Penerima Tugas
                    </button>
                    <div id="assigneeList">
                        @if($agenda->assignees && $agenda->assignees->count() > 0)
                            @foreach($agenda->assignees as $index => $assignee)
                                <div class="assignee-row mb-2">
                                    <div class="input-group">
                                        <select name="assignees[{{ $index }}][user_id]" class="form-control">
                                            <option value="">Pilih Petugas</option>
                                            @foreach($event->participants as $participant)
                                                @if($participant->position && $participant->position->jabatan_id == $agenda->jabatan_id)
                                                    <option value="{{ $participant->user_id }}"
                                                        {{ $assignee->user_id == $participant->user_id ? 'selected' : '' }}>
                                                        {{ $participant->user->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Preview Dokumen Progress -->
                                    @if($assignee->document_progress)
                                    <div class="mt-2 current-file">
                                        <label class="form-label">Dokumen Progress</label>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ asset('storage/' . $assignee->document_progress) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-info mr-2">
                                                Lihat Dokumen
                                            </a>
                                            <small class="text-muted">
                                                {{ basename($assignee->document_progress) }}
                                            </small>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</form>
    <script>
    $(document).ready(function() {
        $.validator.addMethod("validateFile", function(value, element, param) {
            // Jika tidak ada file yang dipilih, dianggap valid (opsional)
            if (element.files.length === 0) {
                return true;
            }

            // Validasi setiap file yang dipilih
            var isValid = true;
            $.each(element.files, function(index, file) {
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
                    isValid = false;
                    return false;
                }

                // Validasi MIME type
                if ($.inArray(file.type, allowedMimeTypes) === -1) {
                    isValid = false;
                    return false;
                }

                // Validasi ukuran file (5MB = 5242880 bytes)
                if (file.size > 5242880) {
                    isValid = false;
                    return false;
                }
            });

            return isValid;
        }, "Pastikan semua file sesuai ketentuan (maks 5MB, format: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG)");

            // Update form validation rules
            $("#form-edit-agenda").validate({
                rules: {
                    nama_agenda: {
                        required: true,
                        minlength: 3
                    },
                    start_date: {
                        required: true
                    },
                    end_date: {
                        required: true,
                        greaterThanStart: true
                    },
                    tempat: {
                        required: true
                    },
                    jabatan_id: {
                        required: true
                    },
                    status: {
                        required: true
                    },
                    'dokumen_pendukung[]': {
                        validateFile: true
                    },
                    'assignees[].user_id': {
                        required: true
                    }
                },
                messages: {
                    nama_agenda: {
                        required: "Nama agenda harus diisi",
                        minlength: "Nama agenda minimal 3 karakter"
                    },
                    start_date: "Tanggal mulai harus diisi",
                    end_date: {
                        required: "Tanggal selesai harus diisi",
                        greaterThanStart: "Tanggal selesai harus setelah tanggal mulai"
                    },
                    tempat: "Tempat harus diisi",
                    jabatan_id: "Jabatan harus dipilih",
                    status: "Status harus dipilih",
                    'dokumen_pendukung[]': {
                        validateFile: "Pastikan file sesuai ketentuan (maks 5MB, format: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG)",
                    },
                    'assignees[].user_id': "Penerima tugas harus dipilih"
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") === "dokumen_pendukung[]") {
                        error.appendTo("#error-dokumen_pendukung");
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);

                    $.ajax({
                        url: form.action,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status) {
                                $('#agendaModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                });
                                agendaTable.ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message || 'Terjadi kesalahan'
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message || 'Terjadi kesalahan pada server'
                            });
                        }
                    });
                    return false;
                }
            });

            // Custom validation untuk tanggal selesai
            $.validator.addMethod("greaterThanStart", function(value, element) {
                const startDate = $('#tanggal_mulai').val();
                return !startDate || !value || new Date(value) >= new Date(startDate);
            });

            // Inisialisasi form dengan satu penerima tugas
            $('#addAssignee').click();

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

    <script>
        // Template untuk baris penerima tugas baru
        // Definisikan fungsi getAssigneeRow
        function getAssigneeRow(index) {
            const currentJabatan = $('#jabatan_id').val();
            let options = '<option value="">Pilih Petugas</option>';

            @foreach($event->participants as $participant)
                if ("{{ $participant->position->jabatan_id ?? '' }}" === currentJabatan) {
                    options += `<option value="{{ $participant->user_id }}">{{ $participant->user->name }}</option>`;
                }
            @endforeach

            return `
                <div class="assignee-row mb-2">
                    <div class="input-group">
                        <select name="assignees[${index}][user_id]" class="form-control">
                            ${options}
                        </select>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger removeAssignee">×</button>
                        </div>
                    </div>
                </div>
            `;
        }

        // Gunakan IIFE (Immediately Invoked Function Expression) untuk mengisolasi scope
        $(document).ready(function() {
            // Deklarasikan assigneeIndex sekali saja di scope yang tepat
            let assigneeIndex = $('.assignee-row').length; // Mulai dari jumlah yang sudah ada

            // Tambah penerima tugas
            $('#addAssignee').click(function() {
                $('#assigneeList').append(getAssigneeRow(assigneeIndex));
                assigneeIndex++;
            });

            // Hapus penerima tugas
            $(document).on('click', '.removeAssignee', function() {
                if ($('.assignee-row').length > 1) {
                    $(this).closest('.assignee-row').remove();
                } else {
                    Swal.fire('Peringatan', 'Minimal harus ada satu penerima tugas!', 'warning');
                }
            });
        });

        // Hapus file
    $('.delete-document').click(function() {
            const documentId = $(this).data('id'); // Ambil data-id dari elemen HTML
            const deleteUrl = `{{ route('agenda.deleteDocument', ['id' => $agenda->event_id, 'id_agenda' => $agenda->agenda_id, 'document_id' => ':documentId']) }}`.replace(':documentId', documentId); // Ganti :documentId dengan nilai sebenarnya

            Swal.fire({
                title: 'Hapus dokumen ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl, // Gunakan URL yang sudah digantikan
                        type: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(response) {
                            if (response.status) {
                                Swal.fire('Berhasil', response.message, 'success');
                                location.reload();
                            } else {
                                Swal.fire('Gagal', response.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
