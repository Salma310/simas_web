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
      @if (Auth::user()->role->role_id != 1 && Auth::user()->role->role_id != 2)
      <li class="nav-item dropdown mt-2">
          <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-bell" style="font-size: 17px;"></i>
              <span class="badge badge-warning navbar-badge text-dark font-weight-bold" style="font-size: 12px;">{{ Auth()->user()->unreadNotifications->count() }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header">Notifications</span>
              @if (Auth()->user()->unreadNotifications->count() > 0)
                  @foreach (Auth()->user()->unreadNotifications as $notification)
                      <div class="dropdown-divider"></div>
                      <a  class="dropdown-item">
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
  <li class="nav-item pb-3 d-flex align-items-center mt-1">
    <a class="nav-link navbar-profile position-relative" href="{{ url('/profile') }}" role="button">
      <p class="d-inline edit-profile">Edit Profile</p>
      <img src="{{ auth()->user()->picture ? asset('storage/picture/' . auth()->user()->picture) : asset('images/defaultUser.png') }}" 
      alt="Profile Image" 
      class="img-circle profile-img" 
      style="width: 35px; height: 35px; object-fit: cover;">
      <p class="name d-inline ml-2 font-weight-bold">{{ auth()->user()->name }}</p>
    </a>
  </li>  
    </ul>
  </nav>
  <!-- /.navbar -->
<style>
.navbar-profile {
  display: flex;
  align-items: center;
  position: relative;
  overflow: hidden;
}

.profile-img {
  margin-top: 5px;
}

.name {
  margin-left: 10px; 
  margin-top: 20px;
  opacity: 1;
  transform: translateY(0); 
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.edit-profile {
  position: absolute;
  left: 60px;
  top: 25%; 
  transform: translateY(20px); 
  opacity: 0;
  font-weight: bold;
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.navbar-profile:hover .name {
  opacity: 0;
  transform: translateY(-10px);
}

.navbar-profile:hover .edit-profile {
  opacity: 1;
  transform: translateY(0);
}
</style>