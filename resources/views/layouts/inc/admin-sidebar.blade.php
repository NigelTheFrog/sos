<div id="layoutSidenav_nav" class="navbar-nav-scroll sb-sidenav-dark" style="--bs-scroll-height: 100vh",>
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="item">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard Item
                </a>
                <a class="nav-link" href="avalan">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard Avalan
                </a>
                <div class="sb-sidenav-menu-heading">Master</div>
                <a class="nav-link" href="avalan">
                    <div class="sb-nav-link-icon"><i class="bi bi-person-fill-gear"></i></div>
                    User
                </a>
                <a class="nav-link" href="avalan">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Tipe
                </a>
                <a class="nav-link" href="avalan">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Company
                </a>
                <a class="nav-link" href="avalan">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Area Lokasi
                </a>
                <a class="nav-link" href="avalan">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Warna
                </a>
                <a class="nav-link" href="avalan">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Group
                </a>
                <a class="nav-link" href="avalan">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Keputusan
                </a>
                <a class="nav-link" href="avalan">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Kategori Produk
                </a>            
                <div class="sb-sidenav-menu-heading">Penjadwalan</div>
                <a class="nav-link" href="charts.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Impor Stok
                </a>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Impor Avalan
                </a>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Pengaturan
                </a>
                <div class="sb-sidenav-menu-heading">Konfirmasi</div>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Konfirmasi WRH
                </a>
                <div class="sb-sidenav-menu-heading">Resume</div>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Susunan Tim CSO
                </a>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    List Barang Selisih
                </a>
                <div class="sb-sidenav-menu-heading">Report</div>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Report Cek Stok
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            @if (Auth::user()->level == 1 )
                {{"Admin"}}
            @else
               {{"Super User"}}               
            @endif
        </div>
    </nav>
</div>