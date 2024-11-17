@extends('layouts.template')

@section('content')
<html>
<head>
    <title>Role User</title>
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
    </style>
</head>
<body>
<div class="content flex-grow-1">
    <div class="header">
        <button class="btn btn-primary" onclick="modalAction('{{ url('role/create') }}')">
            <i class="fas fa-plus"></i> Add Role User
        </button>
        <div class="search-box">
            <input id="searchInput" onkeyup="searchTable()" placeholder="Search" type="text"/>
            <i class="fas fa-search"></i>
        </div>
    </div>
    <div class="table-container mt-4">
        <table class="table" id="roleTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Role</th>
                    <th>Kode Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here by JavaScript -->
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade show" id="roleModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="roleModalLabel" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    function searchTable() {
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById("searchRoleInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("table_role");  // Ganti ID tabel menjadi "table_role"
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {  // Mulai dari 1 untuk melewatkan header
            tr[i].style.display = "none";  // Sembunyikan baris
            td = tr[i].getElementsByTagName("td");
            for (j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {  // Cari berdasarkan teks
                        tr[i].style.display = "";  // Tampilkan baris jika ada kecocokan
                        break;  // Keluar dari loop jika sudah ditemukan
                    }
                }
            }
        }
    }

    function modalAction(url = '') {
        $('#roleModal').load(url, function() {
            $('#roleModal').modal('show');
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        fetch('{{ route('role.getAll') }}')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#roleTable tbody');
                tableBody.innerHTML = ''; // Kosongkan isi tabel
                data.forEach((role, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${role.role_name}</td>
                        <td>${role.role_code}</td>
                        <td>
                            <button class="btn btn-light" onclick="modalAction('/role/edit/${role.role_id}')"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-light text-danger" onclick="deleteRole(${role.role_id})"><i class="fas fa-trash"></i></button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            });
    });

    function deleteRole(id) {
        if(confirm('Are you sure you want to delete this role?')) {
            fetch('{{ route('role.getAll') }}', { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Role deleted successfully!');
                        location.reload();
                    } else {
                        alert('Failed to delete role!');
                    }
                });
        }
    }

    function searchTable() {
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("roleTable");
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
