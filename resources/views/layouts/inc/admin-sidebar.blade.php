<div id="layoutSidenav_nav" class="navbar-nav-scroll sb-sidenav-dark" style="--bs-scroll-height: 100vh",>
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="../dashboard/item">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt" style="font-size: 20px"></i></div>
                    Dashboard Item
                </a>
                <a class="nav-link" href="../dashboard/avalan">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt" style="font-size: 20px"></i></div>
                    Dashboard Avalan
                </a>
                <div class="sb-sidenav-menu-heading">Master</div>
                <a class="nav-link" href="../master/user">
                    <div class="sb-nav-link-icon"><i class="nav-icon fas fa-user-cog" style="font-size: 20px"></i></div>
                    User
                </a>
                <a class="nav-link" href="../master/tipe-user">
                    <div class="sb-nav-link-icon"><i class="nav-icon fas fa-users" style="font-size: 20px"></i></div>
                    Tipe User
                </a>
                <a class="nav-link" href="../master/company">
                    <div class="sb-nav-link-icon"><i class="nav-icon fas fa-sitemap" style="font-size: 20px"></i></div>
                    Company
                </a>
                <a class="nav-link" href="../master/area-lokasi">
                    <div class="sb-nav-link-icon"><i class="nav-icon fas fa-warehouse" style="font-size: 20px"></i></div>
                    Area Lokasi
                </a>
                <a class="nav-link" href="../master/warna">
                    <div class="sb-nav-link-icon"><i class="nav-icon fas fa-paint-brush" style="font-size: 20px"></i></div>
                    Warna
                </a>
                <a class="nav-link" href="../master/group">
                    <div class="sb-nav-link-icon"><i class="nav-icon fas fa-object-group" style="font-size: 20px"></i></div>
                    Group
                </a>
                <a class="nav-link" href="../master/keputusan">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-file-signature" style="font-size: 20px"></i></div>
                    Keputusan
                </a>
                <a class="nav-link" href="../master/kategori-produk">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-cubes-stacked pe-1" style="font-size: 20px"></i></div>
                    Kategori Produk
                </a>            
                <div class="sb-sidenav-menu-heading">Penjadwalan</div>
                <a class="nav-link" href="../penjadwalan/impor-stok">
                    <div class="sb-nav-link-icon"><i class="nav-icon fas fa-file-import" style="font-size: 20px"></i></div>
                    Impor Stok
                </a>
                <a class="nav-link" href="../penjadwalan/impor-avalan">
                    <div class="sb-nav-link-icon"><i class="nav-icon fas fa-file-import" style="font-size: 20px"v></i></div>
                    Impor Avalan
                </a>
                <a class="nav-link" href="../penjadwalan/pengaturan">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-bars-progress" style="font-size: 20px"></i></div>
                    Pengaturan CSO
                </a>
                <div class="sb-sidenav-menu-heading">Konfirmasi</div>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="nav-icon fas fa-user-check" style="font-size: 20px"></i></div>
                    Konfirmasi WRH
                </a>
                <div class="sb-sidenav-menu-heading">Resume</div>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="bi bi-people-fill" style="font-size: 20px"></i></div>
                    Susunan Tim CSO
                </a>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-clipboard-list" style="font-size: 20px"></i></div>
                    List Barang Selisih
                </a>
                <div class="sb-sidenav-menu-heading">Report</div>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="nav-icon fas fa-file-alt" style="font-size: 20px"></i></div>
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