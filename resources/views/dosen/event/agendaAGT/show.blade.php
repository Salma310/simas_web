<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">
                <i class="fas fa-calendar-alt me-2"></i>Detail Agenda
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
        </div>
        <div class="modal-body">
            <div class="row g-4">
                <!-- Agenda Info Section -->
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h4 class="mb-0">{{ $agenda->nama_agenda }}</h4>
                        <div class="status-editor">
                            <select id="agendaStatus" class="form-select" onchange="updateStatus(this.value, {{ $agenda->agenda_id }}, {{ $agenda->event_id }})">
                                <option value="Not Started" {{ $agenda->status === 'not started' ? 'selected' : '' }}>belum mulai</option>
                                <option value="progress" {{ $agenda->status === 'progress' ? 'selected' : '' }}>proses</option>
                                <option value="completed" {{ $agenda->status === 'completed' ? 'selected' : '' }}>selesai</option>
                            </select>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <i class="far fa-calendar-alt text-primary me-2"></i>
                                        <label class="fw-bold">Tanggal Mulai</label>
                                        <p class="ms-4">{{ \Carbon\Carbon::parse($agenda->start_date)->format('d F Y') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <i class="far fa-calendar-check text-primary me-2"></i>
                                        <label class="fw-bold">Tanggal Selesai</label>
                                        <p class="ms-4">{{ \Carbon\Carbon::parse($agenda->end_date)->format('d F Y') }}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="detail-item">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        <label class="fw-bold">Tempat</label>
                                        <p class="ms-4">{{ $agenda->tempat }}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="detail-item">
                                        <i class="fas fa-users text-primary me-2"></i>
                                        <label class="fw-bold">Petugas</label>
                                        <div class="ms-4 mt-2">
                                            @forelse($agenda->assignees as $assignee)
                                                <span class="badge bg-light text-dark border me-2 mb-2 p-2">
                                                    <i class="fas fa-user me-1"></i>
                                                    {{ $assignee->user->name }}
                                                </span>
                                            @empty
                                                <p class="text-muted fst-italic">Belum ada petugas</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="detail-item">
                                        <i class="fas fa-chart-line text-primary me-2"></i>
                                        <label class="fw-bold">Point Beban Kerja</label>
                                        <p class="ms-4">
                                            <span class="badge bg-info px-3 py-2">
                                                {{ $agenda->point_beban_kerja }} poin
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen Pendukung Section -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-book me-2"></i>Dokumen Pendukung (Pedoman)
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="document-preview-container">
                                @if(isset($agenda->documents) && count($agenda->documents) > 0)
                                    @foreach($agenda->documents as $document)
                                        <div class="document-preview-item">
                                            @php
                                                $extension = pathinfo($document->file_name, PATHINFO_EXTENSION);
                                            @endphp

                                            @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                                                <img src="{{ asset('storage/' . $document->file_path) }}"
                                                     class="img-preview"
                                                     alt="Document Preview">
                                            @elseif($extension === 'pdf')
                                                <embed src="{{ asset('storage/' . $document->file_path) }}"
                                                       type="application/pdf"
                                                       class="pdf-preview">
                                            @else
                                                <div class="document-icon">
                                                    <i class="fas fa-file-{{ $extension === 'doc' || $extension === 'docx' ? 'word' : 'excel' }} fa-3x text-info"></i>
                                                    <p class="mt-2">{{ $document->file_name }}</p>
                                                </div>
                                            @endif

                                            <div class="document-actions mt-2">
                                                <form action="{{ route('document.download', [
                                                    'id' => $agenda->event_id,
                                                    'id_agenda' => $agenda->agenda_id,
                                                    'id_document' => $document->document_id
                                                ]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-info" title="Download">
                                                        <i class="fas fa-download"></i>
                                                    </button>

                                                    <a href="{{ asset('storage/' . $document->file_path) }}"
                                                        class="btn btn-sm btn-secondary"
                                                        target="_blank"
                                                        title="Buka di Tab Baru">
                                                         <i class="fas fa-external-link-alt"></i>
                                                     </a>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted py-4">
                                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                                        <p>Belum ada dokumen pendukung</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Document Upload Progress Section -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-file-upload me-2"></i>Upload Dokumen Progress
                            </h6>
                        </div>
                        <div class="card-body">
                            <form id="progressForm"
                                action="{{ route('agenda.uploadProgress', ['id' => $agenda->event_id, 'id_agenda' => $agenda->agenda_id]) }}"
                                method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <div class="custom-file-upload">
                                        <input type="file"
                                            class="form-control"
                                            id="dokumen_progress"
                                            name="dokumen_progress"
                                            accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                                        <small class="text-muted d-block mt-2">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Format yang didukung: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG (Maks. 5MB)
                                        </small>
                                    </div>
                                </div>
                                <div id="uploadPreview" class="mt-3"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                <i class="fas fa-times me-1"></i>Tutup
            </button>
            <button type="submit" form="progressForm" class="btn btn-success">
                <i class="fas fa-upload me-1"></i>Upload Dokumen Progress
            </button>
        </div>
    </div>
</div>

<style>
    .modal-header {
        border-radius: 0.375rem 0.375rem 0 0;
    }

    .detail-item {
        margin-bottom: 1rem;
    }

    .detail-item label {
        display: block;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }

    .detail-item p {
        margin-bottom: 0;
    }

    .custom-file-upload {
        position: relative;
        padding: 1rem;
        background-color: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 0.375rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .custom-file-upload:hover {
        border-color: #6c757d;
        background-color: #fff;
    }

    .status-editor {
        min-width: 150px;
    }

    .document-preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        padding: 1rem;
    }

    .document-preview-item {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 1rem;
        text-align: center;
        background-color: #fff;
        transition: all 0.2s ease;
    }

    .document-preview-item:hover {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .img-preview {
        max-width: 100%;
        height: auto;
        max-height: 200px;
        object-fit: contain;
    }

    .pdf-preview {
        width: 100%;
        height: 200px;
        border: none;
    }

    .document-icon {
        color: #6c757d;
        padding: 2rem;
    }

    .document-icon p {
        font-size: 0.875rem;
        margin-top: 0.5rem;
        word-break: break-word;
    }

    .document-actions {
        margin-top: 1rem;
    }

    @media (max-width: 768px) {
        .modal-lg {
            max-width: 95%;
            margin: 1rem auto;
        }

        .document-preview-container {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
    }
</style>

<script>
function updateStatus(status, agendaId, eventId) {
    const statusSelect = document.getElementById('agendaStatus');
    const originalColor = statusSelect.style.backgroundColor;
    statusSelect.style.backgroundColor = '#e9ecef';
    statusSelect.disabled = true;

    // Gunakan interpolasi string JavaScript yang benar
    fetch(`agenda/${agendaId}/updateStatus`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            statusSelect.style.backgroundColor = '#d4edda';
            setTimeout(() => {
                statusSelect.style.backgroundColor = originalColor;
            }, 1000);
        } else {
            alert('Gagal mengubah status');
            statusSelect.value = statusSelect.getAttribute('data-previous-value');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengubah status');
        statusSelect.value = statusSelect.getAttribute('data-previous-value');
    })
    .finally(() => {
        statusSelect.disabled = false;
    });
}

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Store initial status value
        const statusSelect = document.getElementById('agendaStatus');
        if (statusSelect) {
            statusSelect.setAttribute('data-previous-value', statusSelect.value);
        }

        // Initialize PDF previews
        initializePDFPreviews();

        // Add drag and drop support for file upload
        const dropZone = document.querySelector('.custom-file-upload');
        const fileInput = document.getElementById('dokumen_progress');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropZone.classList.add('border-primary');
        }

        function unhighlight() {
            dropZone.classList.remove('border-primary');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;

            // Trigger change event
            const event = new Event('change');
            fileInput.dispatchEvent(event);
        }
    });

    // Preview for PDF files
    function initializePDFPreviews() {
        const pdfEmbeds = document.querySelectorAll('embed[type="application/pdf"]');
        pdfEmbeds.forEach(embed => {
            embed.addEventListener('error', function() {
                const container = this.parentElement;
                container.innerHTML = `
                    <div class="document-icon">
                        <i class="fas fa-file-pdf fa-3x text-danger"></i>
                        <p class="mt-2">PDF Viewer tidak tersedia</p>
                        <a href="${this.src}" class="btn btn-sm btn-primary mt-2" target="_blank">
                            <i class="fas fa-external-link-alt me-1"></i>Buka PDF
                        </a>
                    </div>
                `;
            });
        });
    }
</script>
<script>
    // Form submission handler
    document.addEventListener('DOMContentLoaded', function() {
        // Ensure Sweetalert2 is loaded
        if (typeof Swal === 'undefined') {
            console.error('Sweetalert2 is not loaded');
            return;
        }

        const progressForm = document.getElementById('progressForm');
        const fileInput = document.getElementById('dokumen_progress');
        const uploadPreview = document.getElementById('uploadPreview');

        if (!progressForm) return;

        // File input change handler for preview
        fileInput?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) {
                uploadPreview.innerHTML = '';
                return;
            }

            // Show file info preview
            uploadPreview.innerHTML = `
                <div class="alert alert-info">
                    <i class="fas fa-file me-2"></i>
                    <strong>${file.name}</strong>
                    <span class="ms-2">(${formatFileSize(file.size)})</span>
                </div>
            `;
        });

        progressForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = progressForm.querySelector('button[type="submit"]');
            if (!submitBtn) return;

            const file = fileInput?.files[0];
            if (!file) {
                Swal.fire({
                    title: 'Peringatan',
                    text: 'Silakan pilih file terlebih dahulu',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffc107'
                });
                return;
            }

            // Validate file size and type
            const maxSize = 5 * 1024 * 1024; // 5MB
            const allowedTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'image/jpeg',
                'image/png'
            ];

            if (file.size > maxSize) {
                Swal.fire({
                    title: 'Kesalahan',
                    text: 'Ukuran file maksimal 5MB',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545'
                });
                return;
            }

            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    title: 'Kesalahan',
                    text: 'Tipe file tidak didukung',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545'
                });
                return;
            }

            // Show Sweetalert2 confirmation before submission
            const result = await Swal.fire({
                title: 'Konfirmasi Upload',
                text: `Anda akan mengupload file: ${file.name}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Upload',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d'
            });

            // Proceed only if user confirms
            if (!result.isConfirmed) return;

            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Uploading...';
            submitBtn.disabled = true;

            try {
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Accept': 'application/json'
                    }
                });

                // Parse response
                const data = await response.json();

                // Check for successful response
                if (response.status === 'success') {
                    // Clear form and preview
                    progressForm.reset();
                    uploadPreview.innerHTML = '';

                    // Show success message using Sweetalert2
                    await Swal.fire({
                        title: 'Berhasil!',
                        text: data.message || 'Dokumen progress berhasil diupload',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#28a745'
                    });

                    // Optionally refresh the documents list or close modal
                    refreshDocumentsList();
                } else {
                    // Handle server-side validation or other errors
                    throw new Error(data.message || 'Gagal mengupload dokumen');
                }
            } catch (error) {
                console.error('Error:', error);

                // Show error message using Sweetalert2
                Swal.fire({
                    title: 'Gagal!',
                    text: error.message || 'Terjadi kesalahan saat upload dokumen',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545'
                });
            } finally {
                // Restore button state
                submitBtn.innerHTML = '<i class="fas fa-upload me-1"></i>Upload Dokumen Progress';
                submitBtn.disabled = false;
            }
        });
    });

    // Helper functions
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function refreshDocumentsList() {
        // Placeholder for document list refresh logic
        console.log('Refreshing documents list');
        // Implement actual refresh logic if needed
    }
</script>

