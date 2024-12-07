@extends('layouts.template')

@section('content')
<title>User</title>
    <style>
        body {
            background-color: #f5f5f5;
        }
        .content {
                padding: 15px;
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
        .filter_role_user {
            width: 250px;
            font-size: 14px;
            border-radius: 8px;
        }

    </style>
    <div class="content flex-grow-1">
        <div class="header">
            <button class="btn btn-primary" onclick="modalAction('{{ url('user/create_ajax') }}')">
                <i class="fas fa-plus"></i> Add User
            </button>
            <div class="search-box">
                <input id="searchInput" onkeyup="searchTable()" placeholder="Search" type="text"/>
                <i class="fas fa-search"></i>
            </div>
        </div>
        <div class="table-container table-responsive mt-4">
            <div class="d-flex flex-row justify-content-start">
                <label class="mr-3 mt-1">Filter: </label>
                <select name="role_id" id="role_id" class="form-control form-control mb-3 d-inline filter_role_user">
                    <option value="">- Semua -</option>
                    @foreach ($role as $l)
                        <option value="{{ $l->role_id }}">{{ $l->role_name }}</option>
                    @endforeach
                </select>
            </div>
            <table class="table table-lg" id="table_user">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

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
        dataUser = $('#table_user').DataTable({
            //serverSide: true, jika ingin menggunakan server side processing
            serverSide: true,
            processing: true,
            // Hide search box and entries dropdown
            // filter: false,
            searching: false,
            // info:false
            // lengthChange: false,
            // paging: false,        // Hides pagination
            // info: false,          // Hides 'Showing x to y of z entries' info
            // ordering: false,      // Disables column ordering (optional)
            ajax: {
                "url": "{{ url('user/list') }}",
                "dataType": "json",
                "type" : "POST",
                "data" : function (d){
                    d.role_id = $('#role_id').val();
                }
            },
            columns : [
                {
                    //nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-left",
                    orderable: false,
                    searchable:false,
                },{
                    data: "username",
                    className: "",
                    // orderable: true, jika ingin kolom ini bisa diurutkan
                    orderable: true,
                    // searchable: true, jika ingin kolom ini bisa dicari
                    searchable: true
                },{
                    data: "name",
                    className: "",
                    orderable: true,
                    searchable: true
                },{
                    // mengambil data level hasil dari ORM berelasi
                    data: "role.role_name",
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
