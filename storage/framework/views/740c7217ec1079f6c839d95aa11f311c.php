<div class="col">
    <div class="card bg-warning text-white mb-4">
        <div class="card-body" id="title">
            <h3 class="text-dark"><?php echo e($countItemBlmProses); ?></h3>
            <p class="text-dark">Item belum proses</p>
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
            <h3><?php echo e($countItemOk); ?></h3>
            <p>Item OK</p>
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
            <h3><?php echo e($countItemSelisih); ?></h3>
            <p>Item Selisih</p>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="#" id="btnItemBlmProses"
                data-bs-toggle="modal" onclick="openModalSelisih(this)">View Details</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div><?php /**PATH /var/www/html/sos-dev/resources/views/admin/dashboard/banner/banner-item.blade.php ENDPATH**/ ?>