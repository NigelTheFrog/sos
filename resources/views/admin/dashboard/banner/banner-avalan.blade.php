<div class="col-xl-3 col">
    <div class="card bg-warning text-white mb-4">
        <div class="card-body" id="title">
            <h3 class="text-dark">{{ $countAvalanBlmProses }}</h3>
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
<div class="col-xl-3">
    <div class="card bg-primary text-white mb-4">
        <div class="card-body" id="title">
            <h3>{{ $countAvalanSdgProses }}</h3>
            <p>Avalan sedang proses</p>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="#" id="btnItemSdgProses"
                data-bs-toggle="modal" onclick="openModalSdgProses(this)">View Details</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>
<div class="col-xl-3">
    <div class="card bg-success text-white mb-4">
        <div class="card-body">
            <h3>{{ $countAvalanOk }}</h3>
            <p>Avalan OK</p>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="#" id="btnItemOk" data-bs-toggle="modal"
                onclick="openModalOk(this)">View Details</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>
<div class="col-xl-3">
    <div class="card bg-danger text-white mb-4">
        <div class="card-body">
            <h3>{{ $countAvalanSelisih }}</h3>
            <p>Avalan Selisih</p>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="#" id="btnItemBlmProses"
                data-bs-toggle="modal" onclick="openModalSelisih(this)">View Details</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>