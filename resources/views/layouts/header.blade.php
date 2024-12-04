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
      <h4 class="mt-1 font-weight-bold">{{ ucwords($title) }}</h4>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      @if (Auth::user()->role->role_id != 1)
      <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-bell"></i>
              <span
                  class="badge badge-warning navbar-badge">{{ Auth()->user()->unreadNotifications->count() }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header">Notifications</span>
              @if (Auth()->user()->unreadNotifications->count() > 0)
                  @foreach (Auth()->user()->unreadNotifications as $notification)
                      <div class="dropdown-divider"></div>
                      <a href="{{ url($notification->data['url']) }}" class="dropdown-item">
                          <p class="dropdown-item-title font-weight-bold">
                              {{ $notification->data['title'] }}
                              <span
                                  class="float-right text-muted text-sm font-weight-normal">{{ $notification->created_at->diffForHumans() }}</span>
                          </p>
                          <p class="notification-text">{{ $notification->data['message'] }}</p>
                      </a>
                  @endforeach
              @else
                  <div class="dropdown-item">No Notifications</div>
              @endif
              <div class="dropdown-divider"></div>
          </div>
      </li>
  @endif
      <li class="nav-item pb-3">
        <a class="nav-link" href="{{ url('/profile') }}" role="button">
          <img src="{{ auth()->user()->picture ? asset('storage/picture/' . auth()->user()->picture) : asset('images/defaultUser.png') }}" alt="Profile Image" class="img-circle" style="width: 35px; height: 35px; object-fit: cover;">
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
