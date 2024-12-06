@extends('layouts.template')

@section('content')
<html>
<head>
    <title>List Agenda</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-action {
            display: flex;
            gap: 5px;
        }
        .btn-action .btn {
            padding: 5px 10px;
        }
        .btn-back {
            background-color: #e0e0e0;
            color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>List Agenda</h2>
            @if (isset($event) && $event)
            <a href="javascript:void(0)" onclick="modalAction('{{ route('agenda.create', ['id' => $event->event_id]) }}')" class="btn btn-primary">Tambah Agenda</a>
            @else
                <span class="text-danger">Event tidak ditemukan</span>
            @endif
        </div>
        <table id="agendaTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Agenda</th>
                    <th>Tanggal Mulai</th>
                    <th>Deadline</th>
                    <th>Tempat</th>
                    <th>Beban Kerja</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('dosen.event.show', ['id' => $event->event_id]) }}" class="btn btn-back">Kembali</a>
        </div>
        <div class="modal fade show" id="agendaModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="eventModalLabel" aria-hidden="true"></div>
    </div>
</body>
</html>
@push('js')
<script>
    var agendaTable;
    function modalAction(url = ''){
        $('#agendaModal').load(url,function(){
            $('#agendaModal').modal('show');
        });
    }
    $(document).ready(function () {
        // Inisialisasi DataTables
            agendaTable = $('#agendaTable').DataTable({
            processing: true, // Tampilkan loading saat memproses data
            serverSide: true, // Aktifkan server-side processing
            searching: true,  // Aktifkan fitur pencarian
            ajax: {
                "url": "{{ route('agenda.list', ['id' => $event->event_id]) }}",
                "type": "POST",
                "data": function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.event_id = "{{ $event->event_id ?? null }}";
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false
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
                    name: "point_beban_kerja"
                },
                {
                    data: "status",
                    name: "status",
                    render: function (data, type, row) {
                    // Sesuaikan badge berdasarkan status
                        switch (data) {
                            case "not started":
                                return '<span class="badge bg-secondary">not started</span>';
                            case "progress":
                                return '<span class="badge bg-success">progress</span>';
                            case "done":
                                return '<span class="badge bg-primary">done</span>';
                            default:
                                return '<span class="badge bg-warning">Tidak Dikenal</span>';
                        }
                    }
                },
                {
                    data: "aksi",
                    name: "aksi",
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

</script>
@endpush
@endsection
