@extends('layouts.template')

@section('content')
<html>
 <head>
  <title>
   Jenis Event
  </title>
  <style>
   body {
            background-color: #f5f5f5;
        }
<<<<<<< HEAD
        .content .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .content .header .search-box {
=======
        .card {
            /* margin: 20px auto; */
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
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
        .search-bar {
>>>>>>> b74c308c61163dcaaa6cce92da4e2252b1b550f7
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
<<<<<<< HEAD
        .content .header .search-box input {
            border-radius: 20px;
            border: 1px solid #ccc;
            padding: 10px 20px;
            width: 250px;
            transition: all 0.3s ease;
        }
        .content .header .search-box input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .content .header .search-box i {
            position: absolute;
            right: 15px;
            color: #aaa;
        }
        .content .header .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        .content .header .btn-primary i {
            margin-right: 10px;
        }
        .content .header .btn-primary:hover {
            background-color: #0056b3;
        }
        .content .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .content .table-container table {
=======
        .search-bar input {
            width: 300px;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        table {
>>>>>>> b74c308c61163dcaaa6cce92da4e2252b1b550f7
            width: 100%;
            border-collapse: collapse;
        }
        .content .table-container table th, .content .table-container table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f5f5f5;
            transition: background-color 0.3s ease;
        }
        .content .table-container table th {
            background-color: #f5f5f5;
            font-weight: bold;
            color: #333;
        }
<<<<<<< HEAD
        .content .table-container table td {
            color: #555;
        }
        .content .table-container table tr:hover td {
            background-color: #f1f1f1;
        }
        .content .table-container table td .btn {
            margin-right: 5px;
            border-radius: 5px;
=======
        .status-completed {
            background-color: #c3f7e2;
            color: #00b894;
>>>>>>> b74c308c61163dcaaa6cce92da4e2252b1b550f7
            padding: 5px 10px;
            transition: all 0.3s ease;
        }
        .content .table-container table td .btn-light {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
        }
        .content .table-container table td .btn-light:hover {
            background-color: #e0e0e0;
        }
        .content .table-container table td .btn-light.text-danger:hover {
            background-color: #f8d7da;
        }
  </style>
 </head>
 <body>
<<<<<<< HEAD
  <div class="content flex-grow-1">
   <div class="header">
    <button class="btn btn-primary" onclick="modalAction('{{ url('event/create_ajax') }}')">
     <i class="fas fa-plus">
     </i>
     Add Event
    </button>
    <div class="search-box">
     <input id="searchInput" onkeyup="searchTable()" placeholder="Search" type="text"/>
     <i class="fas fa-search">
     </i>
    </div>
   </div>
   <div class="table-container mt-4">
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
        Action
       </th>
      </tr>
     </thead>
     <tbody>

     </tbody>
    </table>
   </div>
  </div>
  <div class="modal fade show" id="eventModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="roleModalLabel" aria-hidden="true"></div>

  @push('js')
  <script>
    var dataEvent;

    function modalAction(url = ''){
        $('#eventModal').load(url,function(){
            $('#eventModal').modal('show');
        });
    }

    $(document).ready(function() {
            dataEvent = $('#eventTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ url('event/list') }}",
                "datatypes": "json",
                "type": "POST",
            },
            columns:[
                {
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
                },
                {
                    data: "status",
                    className: "",
                    orderable: false,
                    searchable: false,
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
=======
  <div class="card">
   <div class="header">
    <div class="btn-group btn-first">
     <button class="btn btn-outline-secondary">
      <span>&#x1F50D;</span>
      Filters
     </button>
     <button class="btn btn-primary">
      <span>&#x2795;</span>
      Add Event
     </button>
    </div>
   </div>
   <div class="search-bar">
    <input class="form-control" placeholder="Search" type="text"/>
   </div>
   <table class="table table-bordered">
    <thead>
     <tr>
      <th>
       No
      </th>
      <th>
       Event Name
      </th>
      <th>
       PIC
      </th>
      <th>
       Event Date
      </th>
      <th>
       STATUS
      </th>
      <th>
       Action
      </th>
     </tr>
    </thead>
    <tbody>
     <tr>
      <td>
       00001
      </td>
      <td>
       Pelatihan IT
      </td>
      <td>
       Nasywa Salma
      </td>
      <td>
       04 Sep 2024
      </td>
      <td>
       <span class="status-completed">
        Completed
       </span>
      </td>
      <td>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-light">
             <i class="fas fa-qrcode">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-edit">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-trash">
             </i>
            </button>
        </div>
      </td>
     </tr>
     <tr>
      <td>
       00002
      </td>
      <td>
       Seminar Masyarakat
      </td>
      <td>
       Nabilah Rahmah
      </td>
      <td>
       28 May 2024
      </td>
      <td>
       <span class="status-processing">
        Processing
       </span>
      </td>
      <td>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-light">
             <i class="fas fa-qrcode">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-edit">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-trash">
             </i>
            </button>
        </div>
      </td>
     </tr>
     <tr>
      <td>
       00003
      </td>
      <td>
       Nortis Goes to Campus
      </td>
      <td>
       M Wildan
      </td>
      <td>
       23 Nov 2024
      </td>
      <td>
       <span class="status-rejected">
        Rejected
       </span>
      </td>
      <td>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-light">
             <i class="fas fa-qrcode">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-edit">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-trash">
             </i>
            </button>
        </div>
      </td>
     </tr>
     <tr>
      <td>
       00004
      </td>
      <td>
       IGDX Bootcamp
      </td>
      <td>
       Adam Safrila
      </td>
      <td>
       05 Feb 2024
      </td>
      <td>
       <span class="status-completed">
        Completed
       </span>
      </td>
      <td>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-light">
             <i class="fas fa-qrcode">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-edit">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-trash">
             </i>
            </button>
        </div>
      </td>
     </tr>
     <tr>
      <td>
       00005
      </td>
      <td>
       Internal Competition
      </td>
      <td>
       A Faqih
      </td>
      <td>
       29 Jul 2024
      </td>
      <td>
       <span class="status-processing">
        Processing
       </span>
      </td>
      <td>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-light">
             <i class="fas fa-qrcode">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-edit">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-trash">
             </i>
            </button>
        </div>
      </td>
     </tr>
     <tr>
      <td>
       00006
      </td>
      <td>
       Hacktoberfest
      </td>
      <td>
       Syava Aprilia
      </td>
      <td>
       15 Aug 2024
      </td>
      <td>
       <span class="status-completed">
        Completed
       </span>
      </td>
      <td>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-light">
             <i class="fas fa-qrcode">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-edit">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-trash">
             </i>
            </button>
        </div>
      </td>
     </tr>
     <tr>
      <td>
       00007
      </td>
      <td>
       Play IT
      </td>
      <td>
       Fida Cahya
      </td>
      <td>
       21 Dec 2024
      </td>
      <td>
       <span class="status-processing">
        Processing
       </span>
      </td>
      <td>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-light">
             <i class="fas fa-qrcode">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-edit">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-trash">
             </i>
            </button>
        </div>
      </td>
     </tr>
     <tr>
      <td>
       00008
      </td>
      <td>
       Level Up Softskill
      </td>
      <td>
       Siti Faiqoh
      </td>
      <td>
       30 Apr 2024
      </td>
      <td>
       <span class="status-on-hold">
        On Hold
       </span>
      </td>
      <td>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-light">
             <i class="fas fa-qrcode">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-edit">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-trash">
             </i>
            </button>
        </div>
      </td>
     </tr>
     <tr>
      <td>
       00009
      </td>
      <td>
       Workshop
      </td>
      <td>
       Faridiyani Y
      </td>
      <td>
       09 Jan 2024
      </td>
      <td>
       <span class="status-in-transit">
        In Transit
       </span>
      </td>
      <td>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-light">
             <i class="fas fa-qrcode">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-edit">
             </i>
            </button>
            <button class="btn btn-light">
             <i class="fas fa-trash">
             </i>
            </button>
        </div>
      </td>
     </tr>
    </tbody>
   </table>
   <div class="d-flex justify-content-between">
    <p>
     Showing 1-09 of 78
    </p>
    <nav>
     <ul class="pagination">
      <li class="page-item">
       <a class="page-link" href="#">
        <span>&#x276E;</span>
       </a>
      </li>
      <li class="page-item">
       <a class="page-link" href="#">
        <span>&#x276F;</span>
       </a>
      </li>
     </ul>
    </nav>
   </div>
  </div>
 </body>
</html>

@endsection
>>>>>>> b74c308c61163dcaaa6cce92da4e2252b1b550f7
