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
            display: flex;
            align-items: center;
            position: relative;
        }
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
            height: 100%;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .content .table-container table {
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
        .content .table-container table td {
            color: #555;
        }
        .content .table-container table tr:hover td {
            background-color: #f1f1f1;
        }
        .content .table-container table td .btn {
            margin-right: 5px;
            border-radius: 20px;
            padding: 8px 15px;
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
  <div class="content flex-grow-1">
   <div class="header">
    <button class="btn btn-primary" onclick="modalAction('{{ url('jenis/create') }}')">
     <i class="fas fa-plus">
     </i>
     Add Jenis Event
    </button>
    <div class="search-box">
     <input id="searchInput" onkeyup="searchTable()" placeholder="Search" type="text"/>
     <i class="fas fa-search">
     </i>
    </div>
   </div>
        <div class="table-container table-responsive mt-4">
            <table class="table" id="jenisTable">
            <thead>
            <tr>
            <th>
                NO
            </th>
            <th>
                Nama Jenis Event
            </th>
            <th>
                Kode Jenis Event
            </th>
            <th>
                Action
            </th>
            </tr>
            </thead>
            </table>
        </div>
</div>
  <div class="modal fade show" id="jenisModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="roleModalLabel" aria-hidden="true"></div>

  @push('js')
  <script>
    var jenisEvents;

    function modalAction(url = ''){
        $('#jenisModal').load(url,function(){
            $('#jenisModal').modal('show');
        });
    }

    $(document).ready(function() {
            jenisEvent = $('#jenisTable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false,
            ajax: {
                "url": "{{ route('jenis.list') }}",
                "type": "POST",
                "data": function(d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns:[
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "jenis_event_name",
                    name: "jenis_event_name",
                },
                {
                    data: "jenis_event_code",
                    name: "jenis_event_code"
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
            table = document.getElementById("jenisTable");
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
