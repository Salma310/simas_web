{{-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{  config('app.name', ' PWL Laravel Starter Code') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-fee/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head> --}}
{{-- <body class="hold-transition sidebar-mini"> --}}
<!-- Site wrapper -->
{{-- <div class="wrapper"> --}}
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <h4 class="mt-1 font-weight-bold">{{ ucfirst($activeMenu) }}</h4>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item pt-2">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
        </a>
      </li>
      <li class="nav-item pb-3">
        <a class="nav-link" href="{{ url('/') }}" role="button">
          <img src="{{ asset('adminlte/dist/img/avatar5.png') }}" alt="Profile Image" class="img-circle" style="width: 35px; height: 35px; object-fit: cover;">
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
