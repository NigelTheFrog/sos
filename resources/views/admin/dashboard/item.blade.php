@extends('layouts.master')

@section('title', 'Dashboard Item')

@section('content')

    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard Item</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard Item</li>
        </ol>
        <div class="row">
            <div class="col-xl-3 col">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body" id="title">
                        <h3 class="text-dark">{{ $countItemBlmProses }}</h3>
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
            <div class="col-xl-3">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body" id="title">
                        <h3>{{ $countItemSdgProses }}</h3>
                        <p>Item sedang proses</p>
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
                        <h3>{{ $countItemOk }}</h3>
                        <p>Item OK</p>
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
                        <h3>{{ $countItemSelisih }}</h3>
                        <p>Item Selisih</p>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#" id="btnItemBlmProses"
                            data-bs-toggle="modal" onclick="openModalSelisih(this)">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="ModalItemBlmProses" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="mdlMoreLabel">Item Belum Proses</h1>
                        <button type="button" onclick="closeModalBlmProses(this)" class="btn-close align-middle"
                            data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body" id="itemBlmProses">
                        @include('admin.dashboard.table.item.item-belum-proses')
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="ModalItemSdgProses" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="mdlMoreLabel">Item Sedang Proses</h1>
                        <button type="button" class="btn-close align-middle" data-bs-dismiss="modal"
                            onclick="closeModalSdgProses(this)" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body" id="itemSdgProses">
                        @include('admin.dashboard.table.item.item-sedang-proses')
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="ModalItemOk" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="mdlMoreLabel">Item Belum Proses</h1>
                        <button type="button" class="btn-close align-middle" data-bs-dismiss="modal"
                            onclick="closeModalOk(this)" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body" id="itemOk">
                        @include('admin.dashboard.table.item.item-ok')
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="ModalItemSelisih" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="mdlMoreLabel">Item Belum Proses</h1>
                        <button type="button" class="btn-close align-middle" data-bs-dismiss="modal"
                            onclick="closeModalSelisih(this)" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body" id="itemSelisih">
                        @include('admin.dashboard.table.item.item-selisih')
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <div class="row justify-content-between pt-2 ps-4 pe-3">
                    <div class="col">
                        <h3 class="card-title">Hasil Stock Opname</h3>
                    </div>
                    <div class="col-3">
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" id="searchModItem" type="search" placeholder="Search"
                                aria-label="Search">
                        </form>
                    </div>
                    <div id="main-table-item">
                        @include('admin.dashboard.table.main-table-item')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var intervalItemBlmProses = undefined;
        var intervalItemSdgProses = undefined;
        var intervalItemOk = undefined;
        var intervalItemSelisih = undefined;

        setInterval(function(event) {
            $.ajax({
                url: "{{ url('admin/dashboard/main-table-item') }}",
                type: 'GET',
                success: function(data) {
                    $('#main-table-item').html(data);
                }
            });
        }, 1000);


        function openModalBlmProses(button) {
            $('#ModalItemBlmProses').modal('show');
            intervalItemBlmProses = setInterval(function() {
                $.ajax({
                    url: "{{ url('admin/dashboard/banner-item/1') }}",
                    type: 'GET',
                    success: function(data) {
                        $('#itemBlmProses').html(data);
                        console.log(data);
                    }
                });
            }, 1000);
        }

        function closeModalBlmProses(button) {
            if (typeof myTimeout != undefined) clearTimeout(intervalItemBlmProses);
            $('#ModalItemBlmProses').modal('hide');
        }

        function openModalSdgProses(button) {
            $('#ModalItemSdgProses').modal('show');
            intervalItemSdgProses = setInterval(function() {
                $.ajax({
                    url: "{{ url('admin/dashboard/banner-item/2') }}",
                    type: 'GET',
                    success: function(data) {
                        $('#itemSdgProses').html(data);
                        console.log(data);
                    }
                });
            }, 1000);
        }

        function closeModalSdgProses(button) {
            if (typeof myTimeout != undefined) clearTimeout(intervalItemSdgProses);
            $('#ModalItemSdgProses').modal('hide');
        }

        function openModalOk(button) {
            $('#ModalItemOk').modal('show');
            intervalItemOk = setInterval(function() {
                $.ajax({
                    url: "{{ url('admin/dashboard/banner-item/3') }}",
                    type: 'GET',
                    success: function(data) {
                        $('#itemOk').html(data);
                        console.log(data);
                    }
                });
            }, 1000);
        }

        function closeModalOk(button) {
            if (typeof myTimeout != undefined) clearTimeout(intervalItemOk);
            $('#ModalItemOk').modal('hide');
        }

        function openModalSelisih(button) {
            $('#ModalItemSelisih').modal('show');
            intervalItemSelisih = setInterval(function() {
                $.ajax({
                    url: "{{ url('admin/dashboard/banner-item/4') }}",
                    type: 'GET',
                    success: function(data) {
                        $('#itemSelisih').html(data);
                        console.log(data);
                    }
                });
            }, 1000);
        }

        function closeModalSelisih(button) {
            if (typeof myTimeout != undefined) clearTimeout(intervalItemSelisih);
            $('#ModalItemSelisih').modal('hide');
        }
    </script>
@endsection
