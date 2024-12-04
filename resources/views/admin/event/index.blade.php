@extends('layouts.template')

@section('content')
    <html>

    <head>
        <title>
            Jenis Event
        </title>
        <style>
            body {
                background-color: #f4f7f6;
                font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            }

            .content {
                padding: 30px;
            }

            .content .header {
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
                /* Agar elemen turun jika ruang tidak cukup */
            }

            .group-btn {
                display: flex;
                align-items: center;
                gap: 30px;
                /* Jarak antar tombol */
            }

            .content .header:hover {
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            }

            .content .header .search-box {
                margin-left: auto;
                /* Memastikan search box berada di kanan */
                display: flex;
                align-items: center;
                position: relative;
            }

            .content .header .search-box input {
                border-radius: 25px;
                border: 2px solid #e0e0e0;
                padding: 12px 20px 12px 40px;
                width: 300px;
                font-size: 16px;
                background-color: #f9f9f9;
                transition: all 0.4s ease;
            }

            .content .header .search-box input:focus {
                border-color: #4a90e2;
                background-color: white;
                box-shadow: 0 0 15px rgba(74, 144, 226, 0.2);
                outline: none;
            }

            .content .header .search-box i {
                position: absolute;
                left: 15px;
                color: #a0a0a0;
                transition: color 0.3s ease;
            }

            .content .header .search-box input:focus+i {
                color: #4a90e2;
            }

            .content .header .btn-primary {
                background: linear-gradient(to right, #4a90e2, #2c3e50);
                border: none;
                border-radius: 25px;
                padding: 12px 25px;
                font-size: 16px;
                font-weight: 600;
                display: flex;
                align-items: center;
                transition: all 0.4s ease;
                box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
            }

            .content .header .btn-primary:hover {
                transform: translateY(-3px);
                box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
            }

            .content .header .btn-primary i {
                margin-right: 10px;
            }

            .content .table-container {
                background-color: white;
                border-radius: 12px;
                padding: 25px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                overflow-x: auto;
            }

            .content .table-container table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0 10px;
            }

            .content .table-container table thead {
                background-color: #f4f7f6;
            }

            .content .table-container table th {
                padding: 15px;
                text-align: left;
                font-weight: 600;
                color: #2c3e50;
                border-bottom: 2px solid #e0e0e0;
            }

            .content .table-container table td {
                padding: 15px;
                color: #34495e;
                background-color: #f9f9f9;
                transition: all 0.3s ease;
            }

            .content .table-container table tr {
                margin-bottom: 10px;
            }

            .content .table-container table tr:hover td {
                background-color: #f1f3f4;
                transform: scale(1.01);
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

            .content .table-container table td .btn {
                /* margin: 0 5px; */
                border-radius: 20px;
                padding: 8px 15px;
                font-size: 14px;
                transition: all 0.3s ease;
            }

            .content .table-container table td .btn-light {
                background-color: #f1f3f4;
                color: #34495e;
                border: none;
            }

            .content .table-container table td .btn-light:hover {
                background-color: #e0e2e4;
                transform: translateY(-2px);
            }

            .content .table-container table td .btn-light.text-danger:hover {
                background-color: #ffebee;
                color: #d32f2f;
            }

            .filter_jenis_event {
                width: 250px;
                /* Sesuaikan ukuran lebar filter */
                /* padding: 10px; */
                /* Sesuaikan padding untuk kenyamanan */
                font-size: 14px;
                /* Ukuran teks lebih besar */
                border-radius: 8px;
                /* Rounded edge */
            }
        </style>
    </head>

    <body>
        <div class="content flex-grow-1">
            <div class="header">
                <div class="group-btn">
                    <button class="btn btn-primary" onclick="modalAction('{{ url('event/create_ajax') }}')">
                        <i class="fas fa-plus"></i>Add Event</button>
                    <div>
                        <label class="mt-0">Filter Jenis Event</label>
                        <select name="jenis_event_id" id="jenis_event_id" class="form-control form-control-sm  mt-0 mb-2 filter_jenis_event">
                            <option value="">- Semua -</option>
                            @foreach ($jenisEvent as $l)
                                <option value="{{ $l->jenis_event_id }}">{{ $l->jenis_event_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="search-box">
                    <input id="searchInput" onkeyup="searchTable()" placeholder="Search" type="text" />
                    <i class="fas fa-search">
                    </i>
                </div>
            </div>
            <div class="table-container table-responsive mt-4">
                <table class="table" id="eventTable">
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>
                                Nama Event
                            </th>
                            <th>
                                PIC
                            </th>
                            <th>
                                Tanggal Event
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Point
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="modal fade show" id="eventModal" tabindex="-1" role="dialog" data-backdrop="static"
            aria-labelledby="roleModalLabel" aria-hidden="true"></div>

        @push('js')
            <script>
                var dataEvent;

                function modalAction(url = '') {
                    $('#eventModal').load(url, function() {
                        $('#eventModal').modal('show');
                    });
                }

                $(document).ready(function() {
                    dataEvent = $('#eventTable').DataTable({
                        processing: true,
                        serverSide: true,
                        searching: false,
                        lengthChange: false,
                        ajax: {
                            "url": "{{ url('event/list') }}",
                            "datatypes": "json",
                            "type": "POST",
                            "data" : function ( d ) {
                                d.jenis_event_id = $('#jenis_event_id').val();
                            }
                        },
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex",
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: "event_name",
                                className: "",
                                orderable: true,
                                searchable: true,
                            },
                            {
                                data: 'participant_name',
                                name: 'participant_name',
                                orderable: false,
                                searchable: true
                            }, {
                                data: "end_date",
                                className: "",
                                orderable: true,
                                searchable: true,
                                render: function(data) {
                                    if (data) {
                                        var date = new Date(data);
                                        var day = ("0" + date.getDate()).slice(-2);
                                        var month = ("0" + (date.getMonth() + 1)).slice(-2);
                                        var year = date.getFullYear();
                                        return day + '-' + month + '-' + year;
                                    }
                                    return data;
                                }
                            },
                            {
                                data: "status",
                                className: "",
                                orderable: false,
                                searchable: false,
                            },
                            {
                                data: "point",
                                className: "",
                                orderable: true,
                                searchable: false
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

                $('#jenis_event_id').on('change', function() {
                    dataEvent.ajax.reload();
                });

                function searchTable() {
                    var input, filter, table, tr, td, i, j, txtValue;
                    input = document.getElementById("searchInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("eventTable");
                    tr = table.getElementsByTagName("tr");

                    for (i = 1; i < tr.length; i++) {
                        tr[i].style.display = "none";
                        td = tr[i].getElementsByTagName("td");
                        for (j = 0; j < td.length; j++) {
                            if (td[j]) {
                                txtValue = td[j].textContent || td[j].innerText;
                                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                    tr[i].style.display = "";
                                    break;
                                }
                            }
                        }
                    }
                }
            </script>
        </body>

        </html>
    @endpush
@endsection
