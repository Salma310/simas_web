<div class="sidebar">
  <!-- Sidebar Search Form -->
  <div class="form-inline mt-2">
      <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
              <button class="btn btn-sidebar">
                  <i class="fas fa-search fa-fw"></i>
              </button>
          </div>
      </div>
  </div>
  
  <!-- Sidebar Menu -->
  <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <!-- Dashboard -->
          <li class="nav-item">
              {{-- <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}"> --}}
                <a href="{{ url('/') }}" class="nav-link">

                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
              </a>
          </li>
          
          <!-- Data Pengguna Section -->
          <li class="nav-header">Data Pengguna</li>
          <li class="nav-item">
              <a href="{{ url('/level') }}" class="nav-link">
                  <i class="nav-icon fas fa-layer-group"></i>
                  <p>Level User</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ url('/user') }}" class="nav-link">
                  <i class="nav-icon far fa-user"></i>
                  <p>Data User</p>
              </a>
          </li>
          
          <!-- Data Barang Section -->
          <li class="nav-header">Data Barang</li>
          <li class="nav-item">
              <a href="{{ url('/kategori') }}" class="nav-link">
                  <i class="nav-icon far fa-bookmark"></i>
                  <p>Kategori Barang</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ url('/barang') }}" class="nav-link">
                  <i class="nav-icon far fa-list-alt"></i>
                  <p>Data Barang</p>
              </a>
          </li>

            <!-- Data Supplier Section -->
            <li class="nav-header">Data Supplier</li>
            <li class="nav-item">
                <a href="{{ url('/supplier') }}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Data Supplier</p>
                </a>
            </li>
          
          <!-- Data Transaksi Section -->
          <li class="nav-header">Data Transaksi</li>
          <li class="nav-item">
              <a href="{{ url('/stok') }}" class="nav-link">
                  <i class="nav-icon fas fa-cubes"></i>
                  <p>Stok Barang</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ url('/barang') }}" class="nav-link">
                  <i class="nav-icon fas fa-cash-register"></i>
                  <p>Transaksi Penjualan</p>
              </a>
          </li>

          <br><br><br><br><br><br><br>
           <!-- Button Logout -->
            <li class="nav-item">
                <a href="{{ url('/logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
      </ul>
  </nav>
</div>
