@extends('layouts.template')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">

@section('content')
<title>Agenda</title>
    
    <div class="header">
        <div class="btn-group btn-first">
            <h4 class="mt-1">List Agenda</h4>
        </div>
        <div class="search-box">
            <button class="btn btn-primary" onclick="modalAction('{{ url('agenda/create_ajax') }}')">
                <span>&#x2795;</span> Tambah Agenda
            </button>
        </div>
    </div>
    <div class="card card-outline card-primary">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{  session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{  session('error') }}</div>
            @endif
            <table class="table-container mt-4" id="table_agenda">
                <thead>
                    <tr><th>No</th><th>Nama Agenda</th><th>Tempat</th><th>Tanggal</th><th>Bobot</th><th>Aksi</th></tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('js')
<script>
    function searchTable() {
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("table_user");
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
    function modalAction(url = ''){
        $('#myModal').load(url,function(){
            $('#myModal').modal('show');
        });
    }

    var dataUser;
    $(document).ready(function(){
        dataUser = $('#table_agenda').DataTable({
            serverSide: true,
            processing: true,
            searching: false,
            ajax: {
                "url": "{{ url('myevent/agenda/list') }}",
                "dataType": "json",
                "type" : "POST",
                "data" : function (d){
                    d.agenda_id = $('#agenda_id').val();
                }
            },
            columns : [
                {
                    //nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable:false
                },{
                    data: "nama_agenda",
                    className: "",
                    // orderable: true, jika ingin kolom ini bisa diurutkan
                    orderable: true,
                    // searchable: true, jika ingin kolom ini bisa dicari
                    searchable: true
                },{
                    data: "tempat",
                    className: "",
                    orderable: true,
                    searchable: true
                },{
                    data: "waktu",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "point_beban_kerja",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "aksi",
                    className: "",
                    orderable: false,
                }
            ]
        });

        $('#role_id').on('change', function() {
            dataUser.ajax.reload();
        });

    });
</script>
@endpush
@push('css')
<style>
    body {
        background-color: #f5f5f7;
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
        border-radius: 5px;
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
    #table_user {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    #table_user th, td {
        border: 1px solid #dee2e6;
    }
    #table_user th, td {
        padding: 15px;
        text-align: left;
    }
    #table_user th {
        background-color: #f8f9fa;
    }
    #table_user tr:hover td {
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

    /* Status badge styling */
    .status-completed {
        background-color: #d4edda;
        color: #155724;
        padding: 5px 10px;
        border-radius: 8px;
    }

    .status-processing {
        background-color: #d1ecf1;
        color: #0c5460;
        padding: 5px 10px;
        border-radius: 8px;
    }

    .status-rejected {
        background-color: #f8d7da;
        color: #721c24;
        padding: 5px 10px;
        border-radius: 8px;
    }

    /* Action buttons styling */
    /* .action-button {
        display: inline-block;
        margin: 0 2px;
        padding: 8px;
        color: #fff;
        border-radius: 5px;
        font-size: 14px;
    } */

    .action-detail {
        background-color: #17a2b8;
    }

    .action-edit {
        background-color: #ffc107;
    }

    .action-delete {
        background-color: #dc3545;
    }

</style>
@endpush
