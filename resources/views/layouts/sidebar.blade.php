<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <!-- Data Event Section -->
            <li class="nav-header">Data Event</li>
            <li class="nav-item">
                <a href="{{ url('/event') }}" class="nav-link">
                    <i class="nav-icon fas fa-calendar"></i>
                    <p>Event</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/jenis') }}" class="nav-link">
                    <i class="nav-icon fas fa-table"></i>
                    <p>Jenis Event</p>
                </a>
            </li>

            <!-- Data User Section -->
            <li class="nav-header">Data User</li>
            <li class="nav-item">
                <a href="{{ url('/user') }}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>User</p>
                </a>
            </li>
            <li class="nav-item border-bottom border-light">
                <a href="{{ url('/role') }}" class="nav-link">
                    <i class="nav-icon far fa-list-alt"></i>
                    <p>Role User</p>
                </a>
            </li>

            <li class="nav-item mt-2">
                <a href="{{ url('/statistik') }}" class="nav-link">
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <p>Statistik</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/profile') }}" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Profile</p>
                </a>
            </li>
            <!-- Button Logout -->
            <li class="nav-item logout">
                <a href="{{ url('/logout') }}" class="nav-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-power-off"></i>
                    <p>Logout</p>
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
</div>

<style>
    .nav-sidebar .nav-link.active {
        background-color: #E0E0E0 !important;
        color: #4894FE !important;
    }
    .nav-item.logout{
        margin-top:250px;
    }
</style>
