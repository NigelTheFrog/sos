<div id="layoutSidenav_nav" class="navbar-nav-scroll sb-sidenav-dark" style="--bs-scroll-height: 100%; 
/* background-color: rgb(44, 44, 44) */
">
    <nav class="sb-sidenav accordion" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <?php if(Auth::user()->level == 1 || Auth::user()->level == 2): ?>
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="<?php echo e(route('item.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt" style="font-size: 20px"></i>
                        </div>
                        Dashboard Item
                    </a>
                    <a class="nav-link" href="<?php echo e(route('avalan.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt" style="font-size: 20px"></i>
                        </div>
                        Dashboard Avalan
                    </a>
                    <div class="sb-sidenav-menu-heading">Master</div>
                    <a class="nav-link" href="<?php echo e(route('user.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="nav-icon fas fa-user-cog" style="font-size: 20px"></i>
                        </div>
                        User
                    </a>
                    <a class="nav-link" href="<?php echo e(route('tipe-user.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="nav-icon fas fa-users" style="font-size: 20px"></i>
                        </div>
                        Tipe User
                    </a>
                    <a class="nav-link" href="<?php echo e(route('company.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="nav-icon fas fa-sitemap" style="font-size: 20px"></i>
                        </div>
                        Company
                    </a>
                    <a class="nav-link" href="<?php echo e(route('area-lokasi.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="nav-icon fas fa-warehouse" style="font-size: 20px"></i>
                        </div>
                        Area Lokasi
                    </a>
                    <a class="nav-link" href="<?php echo e(route('warna.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="nav-icon fas fa-paint-brush"
                                style="font-size: 20px"></i></div>
                        Warna
                    </a>
                    <a class="nav-link" href="<?php echo e(route('group.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="nav-icon fas fa-object-group"
                                style="font-size: 20px"></i></div>
                        Group
                    </a>
                    <a class="nav-link" href="<?php echo e(route('keputusan.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-file-signature" style="font-size: 20px"></i>
                        </div>
                        Keputusan
                    </a>
                    <a class="nav-link" href="<?php echo e(route('kategori-produk.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-cubes-stacked pe-1"
                                style="font-size: 20px"></i></div>
                        Kategori Produk
                    </a>
                    <div class="sb-sidenav-menu-heading">Penjadwalan</div>
                    <a class="nav-link" href="<?php echo e(route('import-stok.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="nav-icon fas fa-file-import"
                                style="font-size: 20px"></i></div>
                        Impor Stok
                    </a>
                    <a class="nav-link" href="<?php echo e(route('import-avalan.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="nav-icon fas fa-file-import"
                                style="font-size: 20px"v></i></div>
                        Impor Avalan
                    </a>
                    <a class="nav-link" href="<?php echo e(route('pengaturan.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-bars-progress" style="font-size: 20px"></i>
                        </div>
                        Pengaturan CSO
                    </a>
                    <div class="sb-sidenav-menu-heading">Konfirmasi</div>
                    <a class="nav-link" href="<?php echo e(route("konfirmasi-wrh.index")); ?>">
                        <div class="sb-nav-link-icon"><i class="nav-icon fas fa-user-check" style="font-size: 20px"></i>
                        </div>
                        Konfirmasi WRH
                    </a>
                    <div class="sb-sidenav-menu-heading">Resume Item</div>
                    <a class="nav-link" href="<?php echo e(route('susunan-tim-cso.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="bi bi-people-fill" style="font-size: 20px"></i></div>
                        Susunan Tim CSO Item
                    </a>
                    <a class="nav-link" href="<?php echo e(route('barang-selisih.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-clipboard-list" style="font-size: 20px"></i>
                        </div>
                        List Barang Selisih Item
                    </a>
                    <div class="sb-sidenav-menu-heading">Resume Avalan</div>
                    <a class="nav-link" href="<?php echo e(route('susunan-tim-cso-avalan.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="bi bi-people-fill" style="font-size: 20px"></i></div>
                        Susunan Tim CSO Avalan
                    </a>
                    <a class="nav-link" href="<?php echo e(route('avalan-selisih.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-clipboard-list" style="font-size: 20px"></i>
                        </div>
                        List Barang Selisih Avalan
                    </a>
                    <div class="sb-sidenav-menu-heading">Report</div>
                    <a class="nav-link" href="<?php echo e(route('cek-stok.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="nav-icon fas fa-file-alt" style="font-size: 20px"></i>
                        </div>
                        Report Cek Stok Item
                    </a>
                    <a class="nav-link" href="<?php echo e(route('cek-stok-avalan.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="nav-icon fas fa-file-alt" style="font-size: 20px"></i>
                        </div>
                        Report Cek Stok Avalan
                    </a>
                <?php elseif(Auth::user()->level == 3): ?>
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="<?php echo e(route('item.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt" style="font-size: 20px"></i>
                        </div>
                        Dashboard Item
                    </a>
                    <a class="nav-link" href="<?php echo e(route('avalan.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt" style="font-size: 20px"></i>
                        </div>
                        Dashboard Avalan
                    </a>
                <?php elseif(Auth::user()->level == 4): ?>
                <div class="sb-sidenav-menu-heading">CEK STOK</div>
                <a class="nav-link" href="<?php echo e(route('item.index')); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt" style="font-size: 20px"></i>
                    </div>
                    Dashboard Item
                </a>                 
                <?php else: ?>
                    <div class="sb-sidenav-menu-heading">Konfirmasi</div>
                    <a class="nav-link" href="<?php echo e(route("konfirmasi-wrh.index")); ?>">
                        <div class="sb-nav-link-icon"><i class="nav-icon fas fa-user-check" style="font-size: 20px"></i>
                        </div>
                        Konfirmasi WRH
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php if(Auth::user()->level == 1): ?>
                <?php echo e('Admin'); ?>

            <?php elseif(Auth::user()->level == 2): ?>
                <?php echo e('Super User'); ?>

            <?php elseif(Auth::user()->level == 3): ?>
                <?php echo e('Analisator'); ?>

            <?php elseif(Auth::user()->level == 4): ?>
                <?php echo e('Checker'); ?>

            <?php else: ?>
                <?php echo e('WRH'); ?>

            <?php endif; ?>
        </div>
    </nav>
</div>
<?php /**PATH /var/www/html/sos-dev/resources/views/layouts/inc/admin-sidebar.blade.php ENDPATH**/ ?>