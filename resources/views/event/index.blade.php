@extends('layouts.template')

@section('content')

<html>
 <head>
  <title>
   Event
  </title>
  <style>
   body {
            background-color: #f5f5f7;
        }
        .card {
            /* margin: 20px auto; */
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header{
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
        tr:hover td{
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
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header .btn-first{
            display: flex;
            gap: 10px;
        }
  </style>
 </head>
 <body>
   <div class="header">
    <div class="btn-group btn-first">
     <button class="btn btn-outline-secondary">
      <span>&#x1F50D;</span>
      Filters
     </button>
     <button class="btn btn-primary" onclick="window.location.href='{{ url('event/create') }}'">
      <span>&#x2795;</span>
      Add Event
     </button>
    </div>
    <div class="search-box">
     <input id="searchInput" onkeyup="searchTable()" placeholder="Search" type="text"/>
     <i class="fas fa-search">
     </i>
    </div>
   </div>
   <div class="card">
   <table class="table table-bordered" id="eventTable">
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
