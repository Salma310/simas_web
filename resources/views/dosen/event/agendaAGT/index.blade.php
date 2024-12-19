@extends('layouts.template')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded-lg shadow-sm">
                <div>
                    <h2 class="mb-0">List Agenda</h2>
                    <p class="text-muted mb-0">Update progres agenda kegiatan</p>
                </div>
                @if (isset($event) && $event)
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success px-3 py-2">{{$event->event_name}}</span>
                    </div>
                @else
                    <span class="badge bg-danger px-3 py-2">Event tidak ditemukan</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white p-3 rounded-lg shadow-sm">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="searchAgenda" placeholder="Cari agenda...">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="not started">belum mulai</option>
                            <option value="progress">proses</option>
                            <option value="completed">selesai</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div id="loadingIndicator" class="text-center py-4 d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Agenda Cards -->
    <div class="row" id="agendaCards">
        <!-- Cards will be populated by AJAX -->
    </div>

    <!-- Empty State -->
    <div id="emptyState" class="text-center py-5 d-none">
        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
        <h5>Tidak ada agenda ditemukan</h5>
        <p class="text-muted">Coba ubah filter atau kata kunci pencarian</p>
    </div>

    <!-- Back Button -->
    <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('dosen.event.show', ['id' => $event->event_id]) }}"
           class="btn btn-light shadow-sm px-4">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="agendaModal" tabindex="-1" role="dialog" data-backdrop="static"></div>
</div>

<style>
    .agenda-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .agenda-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }

    .status-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }

    .status-not-started { background-color: #6c757d; }
    .status-progress { background-color: #198754; }
    .status-completed { background-color: #0d6efd; }

    .agenda-meta {
        font-size: 0.875rem;
        color: #6c757d;
    }

    .workload-badge {
        background-color: #f8f9fa;
        color: #212529;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .action-buttons .btn {
        padding: 0.25rem 0.75rem;
        font-size: 0.875rem;
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
