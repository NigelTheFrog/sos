<div class="row" >
    <div class="col-xl-3 col">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body" id="title">
                <h3 class="text-dark">{{ $countItemBlmProses }}</h3>
                <p class="text-dark">Item belum proses</p>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href=# id="btnItemBlmProses"
                    data-bs-mytitle="Ini Modal Belum Proses" data-bs-toggle="modal"
                    data-bs-target="#ModalItemBlmProses">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body" id="title">
                <h3>{{ $countItemSdgProses }}</h3>
                <p>Item sedang proses</p>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#" id="btnItemBlmProses" data-bs-toggle="modal"
                    data-bs-target="#ModalItemSdgProses">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                <h3>{{ $countItemOk }}</h3>
                <p>Item OK</p>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#" id="btnItemOk" data-bs-toggle="modal"
                    data-bs-target="#ModalItemOk">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">
                <h3>{{ $countItemSelisih }}</h3>
                <p>Item Selisih</p>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#" id="btnItemBlmProses" data-bs-toggle="modal"
                    data-bs-target="#ModalItemSelisih">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>
