@extends('layouts.template')

@section('content')
<div class="container-fluid px-4 py-0">
     <!--Header Section -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center bg-white p-5 rounded-xl shadow-lg">
                <div>
                    <h2 class="display-6 fw-bold mb-2">List Agenda</h2>
                    <p class="text-muted fs-5 mb-0">Update progres agenda kegiatan</p>
                </div>
                @if (isset($event) && $event)
                    <div class="d-flex align-items-center">
                        <span class="badge bg-gradient px-4 py-3 fs-6 rounded-pill">{{$event->event_name}}</span>
                    </div>
                @else
                    <span class="badge bg-danger-subtle text-danger px-4 py-3 fs-6 rounded-pill">Event tidak ditemukan</span>
                @endif
            </div>
        </div>
    </div>

     <!--Filter Section -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="bg-white p-4 rounded-xl shadow-lg">
                <div class="row g-4">
                    <div class="col-md-5">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0" id="searchAgenda" placeholder="Cari agenda...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select form-select-lg" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="not started">Belum Mulai</option>
                            <option value="progress">Proses</option>
                            <option value="completed">Selesai</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!--Loading Indicator -->
    <div id="loadingIndicator" class="text-center py-5 d-none">
        <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

     <!--Agenda Cards -->
    <div class="row g-4" id="agendaCards">
         Cards will be populated by AJAX 
    </div>

     <!--Empty State -->
    <div id="emptyState" class="text-center py-5 d-none">
        <div class="empty-state-container bg-light rounded-xl p-5">
            <i class="fas fa-calendar-times fa-4x text-muted mb-4"></i>
            <h4 class="mb-3">Tidak ada agenda ditemukan</h4>
            <p class="text-muted fs-5">Coba ubah filter atau kata kunci pencarian</p>
        </div>
    </div>

     <!--Back Button -->
    <div class="d-flex justify-content-end mt-5">
        <a href="{{ route('dosen.event.show', ['id' => $event->event_id]) }}"
           class="btn btn-light btn-lg shadow-lg px-5 rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

     <!--Modal -->
    <div class="modal fade" id="agendaModal" tabindex="-1" role="dialog" data-backdrop="static"></div>
</div>

<style>
    /* Modern styling */
    .container-fluid {
        max-width: 1920px;
    }

    .rounded-xl {
        border-radius: 1rem !important;
    }

    .bg-gradient {
        background: linear-gradient(135deg, #00b09b, #96c93d);
        color: white;
    }

    /* Card styling */
    .agenda-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 1rem;
        overflow: hidden;
    }

    .agenda-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }

    .agenda-card .card-body {
        padding: 2rem;
    }

    /* Status indicators */
    .status-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
        position: relative;
    }

    .status-indicator::after {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        border-radius: 50%;
        border: 2px solid currentColor;
        opacity: 0.2;
    }

    .status-not-started { 
        background-color: #6c757d;
        color: #6c757d;
    }
    
    .status-progress { 
        background-color: #00b09b;
        color: #00b09b;
    }
    
    .status-completed { 
        background-color: #96c93d;
        color: #96c93d;
    }

    /* Meta information */
    .agenda-meta {
        font-size: 0.95rem;
        color: #6c757d;
        line-height: 1.8;
    }

    .workload-badge {
        background: linear-gradient(135deg, #f6f8fa, #e9ecef);
        color: #495057;
        padding: 0.5rem 1rem;
        border-radius: 1rem;
        font-size: 0.9rem;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    /* Button styling */
    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background: linear-gradient(135deg, #00b09b, #96c93d);
        border: none;
        padding: 0.5rem 1.5rem;
    }

    /* Input styling */
    .form-control, .form-select {
        border: 1px solid #e9ecef;
        padding: 0.75rem 1rem;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(0,176,155,0.25);
        border-color: #00b09b;
    }

    /* Empty state */
    .empty-state-container {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }

    /* Badge styling */
    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
    }
</style>

@push('js')
<script>
    let currentAgendas = [];

    function modalAction(url = '') {
        $('#agendaModal').load(url, function() {
            $('#agendaModal').modal('show');
        });
    }

    function fetchAgendas() {
    $('#loadingIndicator').removeClass('d-none');
    $('#agendaCards').html('');
    $('#emptyState').addClass('d-none');

    $.ajax({
        url: "{{ route('agenda.listAGT', ['id' => $event->event_id]) }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            event_id: "{{ $event->event_id ?? null }}"
        },
        success: function(response) {
            // Pastikan response.data adalah array
            currentAgendas = response.data || [];
            filterAndDisplayAgendas();
        },
        error: function(xhr, status, error) {
            console.error('Error fetching agendas:', error);
            $('#agendaCards').html(`
                <div class="col-12 text-center py-4">
                    <div class="alert alert-danger">
                        Terjadi kesalahan saat memuat data. Silakan coba lagi.
                    </div>
                </div>
            `);
        },
        complete: function() {
            $('#loadingIndicator').addClass('d-none');
        }
    });
}

function filterAndDisplayAgendas() {
    const searchTerm = $('#searchAgenda').val().toLowerCase();
    const statusFilter = $('#filterStatus').val();

    // Pastikan currentAgendas adalah array
    if (!Array.isArray(currentAgendas)) {
        console.error('currentAgendas bukan array:', currentAgendas);
        currentAgendas = [];
    }

    const filteredAgendas = currentAgendas.filter(agenda => {
        if (!agenda) return false;  // Skip jika agenda undefined/null

        const matchesSearch =
            (agenda.nama_agenda?.toLowerCase()?.includes(searchTerm) || false) ||
            (agenda.tempat?.toLowerCase()?.includes(searchTerm) || false);

        const matchesStatus = !statusFilter || agenda.status === statusFilter;
        return matchesSearch && matchesStatus;
    });

    $('#agendaCards').html('');

    if (filteredAgendas.length === 0) {
        $('#emptyState').removeClass('d-none');
    } else {
        $('#emptyState').addClass('d-none');
        filteredAgendas.forEach(agenda => {
            $('#agendaCards').append(renderAgendaCard(agenda));
        });
    }
}

// Pastikan format data sesuai sebelum render
function renderAgendaCard(data) {
    if (!data) return '';  // Return empty string if data is null/undefined

    let statusClass = {
        'not started': 'status-not-started',
        'progress': 'status-progress',
        'completed': 'status-completed'
    }[data.status] || 'status-not-started';  // Default status if undefined

    let statusText = {
        'not started': 'Belum Mulai',
        'progress': 'Proses',
        'completed': 'Selesai'
    }[data.status] || 'Not Started';  // Default text if undefined

    // Format dates to dd-mm-yy
    const formatDate = (dateStr) => {
        if (!dateStr) return '';
        const date = new Date(dateStr);
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = date.getFullYear().toString().slice(-2);
        return `${day}-${month}-${year}`;
    };

    const startDate = formatDate(data.start_date);
    const endDate = formatDate(data.end_date);

    // Handle multiple assignees with nested user relationship
    const renderAssignees = () => {
        if (!data.assignees || !data.assignees.length) {
            return '<span class="text-muted">Belum ada petugas</span>';
        }

        // Get first 2 assignees to display
        const displayedAssignees = data.assignees.slice(0, 2);
        const remainingCount = data.assignees.length - 2;

        let assigneeHTML = displayedAssignees.map(assignee =>
            `<span class="badge bg-light text-dark me-1 mb-1">
                ${assignee.user ? assignee.user.name : 'Unnamed'}
            </span>`
        ).join('');

        // Add remaining count if there are more assignees
        if (remainingCount > 0) {
            assigneeHTML += `<span class="badge bg-secondary">+${remainingCount} lainnya</span>`;
        }

        return assigneeHTML;
    };

    const detailUrl = `agenda/${data.agenda_id}/showAGT`;

    return `
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card agenda-card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title mb-0">${data.nama_agenda || ''}</h5>
                        <span class="workload-badge">
                            <i class="fas fa-chart-line me-1"></i>
                            ${data.point_beban_kerja || 0} poin
                        </span>
                    </div>

                    <div class="agenda-meta mb-3">
                        <div class="mb-2">
                            <i class="far fa-calendar-alt me-2"></i>
                            ${startDate} - ${endDate}
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            ${data.tempat || ''}
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-users me-2"></i>
                            <div class="d-inline-block">
                                ${renderAssignees()}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="status-indicator ${statusClass}"></span>
                            <span>${statusText}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <button
                                class="btn btn-sm btn-primary ms-2"
                                onclick="modalAction('${detailUrl}')">
                                <i class="fas fa-edit me-1"></i> Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}
    $(document).ready(function() {
        fetchAgendas();

        // Search and filter handlers
        $('#searchAgenda').on('keyup', filterAndDisplayAgendas);
        $('#filterStatus').on('change', filterAndDisplayAgendas);
    });
</script>
@endpush
@endsection
