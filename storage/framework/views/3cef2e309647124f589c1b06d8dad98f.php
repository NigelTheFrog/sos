<div class="col">
    <div class="card bg-warning text-white mb-4">
        <div class="card-body" id="title">
            <h3 class="text-dark"><?php echo e($countAvalanBlmProses); ?></h3>
            <p class="text-dark">Avalan belum proses</p>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href=# id="btnItemBlmProses"
                data-bs-mytitle="Ini Modal Belum Proses" onclick="openModalBlmProses(this)"
                data-bs-target="#ModalItemBlmProses">View Details</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>

<div class="col">
    <div class="card bg-success text-white mb-4">
        <div class="card-body">
            <h3><?php echo e($countAvalanOk); ?></h3>
            <p>Avalan OK</p>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="#" id="btnItemOk" data-bs-toggle="modal"
                onclick="openModalOk(this)">View Details</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>
<div class="col">
    <div class="card bg-danger text-white mb-4">
        <div class="card-body">
            <h3><?php echo e($countAvalanSelisih); ?></h3>
            <p>Avalan Selisih</p>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="#" id="btnItemBlmProses"
                data-bs-toggle="modal" onclick="openModalSelisih(this)">View Details</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div><?php /**PATH /var/www/html/sos-dev/resources/views/admin/dashboard/banner/banner-avalan.blade.php ENDPATH**/ ?>