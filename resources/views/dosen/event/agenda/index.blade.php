@extends('layouts.template')

@section('content')
<div class="content flex-grow-1">
    <div class="header">
        <div class="group-btn">
            <button class="btn btn-primary" onclick="modalAction('{{ route('agenda.create', ['id' => $event->event_id]) }}')">
                <i class="fas fa-plus"></i>Add Agenda
            </button>
            @if (isset($event) && $event)
            <button onclick="generateAllPoints({{ $event->event_id }})" class="btn btn-warning">
                <i class="fas fa-calculator"></i>Generate Point
            </button>
            @endif
        </div>
        <!--<div class="search-box">-->
        <!--    <input id="searchInput" type="text" placeholder="Search..." />-->
        <!--    <i class="fas fa-search"></i>-->
        <!--</div>-->
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table id="agendaTable" class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Agenda</th>
                        <th>Tanggal Mulai</th>
                        <th>Deadline</th>
                        <th>Tempat</th>
                        <th>Beban Kerja</th>
                        <th>Status</th>
                        <th>Status Update</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('dosen.event.show', ['id' => $event->event_id]) }}" class="btn btn-light">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="modal fade" id="agendaModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="eventModalLabel" aria-hidden="true"></div>

<style>
body {
    background-color: #f4f7f6;
    font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

.content {
    padding: 15px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    background-color: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    flex-wrap: wrap;
    gap: 15px;
}

.header:hover {
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.group-btn {
    display: flex;
    align-items: center;
    gap: 15px;
}

.search-box {
    position: relative;
    flex-grow: 0;
}

.search-box input {
    border-radius: 25px;
    border: 2px solid #e0e0e0;
    padding: 12px 20px 12px 40px;
    width: 300px;
    font-size: 16px;
    background-color: #f9f9f9;
    transition: all 0.4s ease;
}

.search-box input:focus {
    border-color: #4a90e2;
    background-color: white;
    box-shadow: 0 0 15px rgba(74, 144, 226, 0.2);
    outline: none;
}

.search-box i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #a0a0a0;
    transition: color 0.3s ease;
}

.search-box input:focus + i {
    color: #4a90e2;
}

.btn {
    border-radius: 25px;
    padding: 12px 25px;
    font-size: 16px;
    font-weight: 600;
    display: flex;
    align-items: center;
    transition: all 0.4s ease;
}

.btn i {
    margin-right: 10px;
}

.btn-primary {
    background: linear-gradient(to right, #4a90e2, #2c3e50);
    border: none;
    box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
}

.btn-warning {
    background: linear-gradient(to right, #f1c40f, #f39c12);
    border: none;
    color: white;
    box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3);
}

.btn-warning:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(243, 156, 18, 0.4);
}

.btn-light {
    background-color: #f1f3f4;
    color: #34495e;
    border: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.btn-light:hover {
    background-color: #e0e2e4;
    transform: translateY(-2px);
}

.table-container {
    background-color: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.filter-select {
    width: 250px;
    font-size: 14px;
    border-radius: 8px;
    border: 2px solid #e0e0e0;
    padding: 8px 12px;
    background-color: #f9f9f9;
    transition: all 0.3s ease;
}

.filter-select:focus {
    border-color: #4a90e2;
    box-shadow: 0 0 10px rgba(74, 144, 226, 0.1);
    outline: none;
}

.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
    margin-top: -10px;
}

.table thead {
    background-color: #f4f7f6;
}

.table th {
    padding: 15px;
    text-align: left;
    font-weight: 600;
    color: #2c3e50;
    border-bottom: 2px solid #e0e0e0;
    white-space: nowrap;
}

.table td {
    padding: 15px;
    color: #34495e;
    background-color: #f9f9f9;
    transition: all 0.3s ease;
    vertical-align: middle;
}

.table tbody tr {
    margin-bottom: 10px;
    transition: transform 0.3s ease;
}

.table tbody tr:hover {
    transform: translateX(5px);
}

.table tbody tr:hover td {
    background-color: #f1f3f4;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.table td .badge {
    padding: 8px 12px;
    border-radius: 20px;
    font-weight: 500;
    font-size: 12px;
}

.badge-success {
    background-color: #2ecc71;
    color: white;
}

.badge-warning {
    background-color: #f1c40f;
    color: white;
}

.badge-danger {
    background-color: #e74c3c;
    color: white;
}

/* Responsive Styles */
@media (max-width: 1200px) {
    .search-box input {
        width: 250px;
    }
}

@media (max-width: 992px) {
    .header {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-box {
        width: 100%;
    }
    
    .search-box input {
        width: 100%;
    }
    
    .group-btn {
        justify-content: flex-start;
    }
}

@media (max-width: 768px) {
    .content {
        padding: 10px;
    }
    
    .table-container {
        padding: 15px;
    }
    
    .group-btn {
        flex-wrap: wrap;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
    
    .filter-select {
        width: 100%;
    }
    
    .table th,
    .table td {
        padding: 10px;
        font-size: 14px;
    }
}

/* Custom Scrollbar */
.table-responsive {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e0 #f1f5f9;
}

.table-responsive::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background-color: #cbd5e0;
    border-radius: 3px;
}

/* DataTables Custom Styling */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 20px;
    padding: 5px 12px;
    margin: 0 3px;
    border: none !important;
    background: #f1f3f4 !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #e0e2e4 !important;
    color: #2c3e50 !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #4a90e2 !important;
    color: white !important;
}
</style>



@push('js')
<script>
    var agendaTable;
    function modalAction(url = ''){
        $('#agendaModal').load(url,function(){
            $('#agendaModal').modal('show');
        });
    }
    $(document).ready(function () {
        agendaTable = $('#agendaTable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false,
            ajax: {
                "url": "{{ route('agenda.list', ['id' => $event->event_id]) }}",
                "type": "POST",
                "data": function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.event_id = "{{ $event->event_id ?? null }}";
                    d.status = $('#status_filter').val();
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: "nama_agenda",
                    name: "nama_agenda"
                },
                {
                    data: "start_date",
                    name: "start_date"
                },
                {
                    data: "end_date",
                    name: "end_date"
                },
                {
                    data: "tempat",
                    name: "tempat"
                },
                {
                    data: "point_beban_kerja",
                    name: "point_beban_kerja",
                    className: 'text-center'
                },
                {
                    data: "status",
                    name: "status",
                    className: 'text-center',
                    render: function (data, type, row) {
                        switch (data) {
                            case "not started":
                                return '<span class="badge bg-secondary">belum mulai</span>';
                            case "progress":
                                return '<span class="badge bg-success">proses</span>';
                            case "completed":
                                return '<span class="badge bg-primary">selesai</span>';
                            default:
                                return '<span class="badge bg-warning">Tidak Dikenal</span>';
                        }
                    }
                },
                {
                    data: "update_status",
                    name: "update_status",
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: "aksi",
                    name: "aksi",
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }
            ],
            language: {
                processing: '<i class="fas fa-spinner fa-spin"></i> Memuat data...',
                search: "Pencarian:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data yang ditampilkan",
                infoFiltered: "(difilter dari _MAX_ total data)",
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    next: '<i class="fas fa-angle-right"></i>',
                    previous: '<i class="fas fa-angle-left"></i>'
                }
            }
        });
         // Search functionality
        $('#searchInput').on('keyup', function() {
            agendaTable.search(this.value).draw();
        });

        // Filter functionality
        $('#status_filter').on('change', function() {
            agendaTable.ajax.reload();
        });
    });

    function generateAllPoints(eventId) {
        Swal.fire({
            title: 'Generate Points Seluruh Agenda',
            text: 'Apakah Anda yakin ingin generate points untuk semua agenda dalam event ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Generate!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('agenda.generate-all-points', ['id' => $event->event_id]) }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        event_id: eventId
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Sedang diproses...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500
                            });
                            agendaTable.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON.message || 'Terjadi kesalahan saat generate points'
                        });
                    }
                });
            }
        });
    }
</script>
@endpush
@endsection

