@extends('layouts.template')

@section('content')
<html>
<head>
    <title>Event</title>
    <style>
        body {
            background-color: #f5f5f7;
        }
        .card {
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-first {
            display: inline-block;
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-outline-secondary {
            background-color: #fff;
            color: #6c757d;
            border: 1px solid #6c757d;
        }
        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }
        .btn-light {
            background-color: #f8f9fa;
            color: #6c757d;
            border: 1px solid #dee2e6;
            border-radius: 15px;
        }
        .header .search-box {
            display: flex;
            align-items: center;
            position: relative;
        }
        .header .search-box input {
            border-radius: 20px;
            border: 1px solid #ccc;
            padding: 10px 20px;
            width: 250px;
            transition: all 0.3s ease;
        }
        .header .search-box input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .header .search-box i {
            position: absolute;
            right: 15px;
            color: #aaa;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        tr:hover td {
            background-color: #f1f1f1;
        }
        .status-completed {
            background-color: #c3f7e2;
            color: #00b894;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status-processing {
            background-color: #e0d7f7;
            color: #6c5ce7;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status-rejected {
            background-color: #f7d7d7;
            color: #d63031;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status-on-hold {
            background-color: #f7e7d7;
            color: #e17055;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status-in-transit {
            background-color: #d7e7f7;
            color: #0984e3;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .pagination {
            display: flex;
            justify-content: flex-end;
            list-style: none;
            padding: 0;
        }
        .pagination li {
            margin: 0 5px;
        }
        .pagination a {
            display: block;
            padding: 10px 15px;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        .pagination a:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="btn-group btn-first">
            <button class="btn btn-outline-secondary">
                <span>&#x1F50D;</span> Filters
            </button>
            <button class="btn btn-primary" onclick="window.location.href='{{ url('event/create') }}'">
                <span>&#x2795;</span> Add Event
            </button>
        </div>
        <div class="search-box">
            <input id="searchInput" onkeyup="searchTable()" placeholder="Search" type="text" />
            <i class="fas fa-search"></i>
        </div>
    </div>
    <div class="card">
        <table class="table table-bordered" id="eventTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Event Name</th>
                    <th>PIC</th>
                    <th>Event Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr>
                        <td>{{ $event->no }}</td>
                        <td>{{ $event->name }}</td>
                        <td>{{ $event->pic }}</td>
                        <td>{{ $event->date }}</td>
                        <td>
                            <span class="{{ $event->status_class }}">{{ $event->status }}</span>
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-light"><i class="fas fa-qrcode"></i></button>
                                <button class="btn btn-light"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-light"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <p>Showing 1-{{ count($events) }} of {{ $totalEvents }}</p>
            <nav>
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#"><span>&#x276E;</span></a></li>
                    <li class="page-item"><a class="page-link" href="#"><span>&#x276F;</span></a></li>
                </ul>
            </nav>
        </div>
    </div>

    <script>
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
@endsection


$(document).ready(function() {
    $('#yourTableID').DataTable({
        // Hide search box and entries dropdown
        searching: false,
        lengthChange: false,

        // Define columns
        columnDefs: [
            {
                // Target the last column (Actions column) for customization
                targets: -1,
                orderable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-info btn-sm" onclick="viewDetail(${row[0]})">
                            <i class="fa fa-eye"></i> <!-- Icon for Detail -->
                        </button>
                        <button class="btn btn-warning btn-sm" onclick="editRecord(${row[0]})">
                            <i class="fa fa-edit"></i> <!-- Icon for Edit -->
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteRecord(${row[0]})">
                            <i class="fa fa-trash"></i> <!-- Icon for Delete -->
                        </button>
                    `;
                }
            }
        ]
    });
});



render: function(data, type, row) {
    return `
        <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-light" onclick="viewDetail(${row[0]})">
                <i class="fas fa-qrcode"></i> <!-- Icon for Detail -->
            </button>
            <button class="btn btn-light" onclick="editRecord(${row[0]})">
                <i class="fas fa-edit"></i> <!-- Icon for Edit -->
            </button>
            <button class="btn btn-light" onclick="deleteRecord(${row[0]})">
                <i class="fas fa-trash"></i> <!-- Icon for Delete -->
            </button>
        </div>
    `;
}


// $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/show_ajax') . '\')" class="btn btn btn-light"> <i class="fas fa-qrcode"></i></button> ';
// $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/edit_ajax') . '\')" class="btn btn btn-light"><i class="fas fa-edit"></i></button> ';
// $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/delete_ajax') . '\')" class="btn btn btn-light"> <i class="fas fa-trash"></i></button> ';
