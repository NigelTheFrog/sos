@extends('layouts.master')

@section('title', 'Dashboard Avalan')

@section('content')

    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard Avalan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard Avalan</li>
        </ol>
        <div class="row">
            @include("admin.dashboard.banner.banner-avalan")
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
                </div>

                <div class="card-body" id="main-table-avalan">
                    @include("admin.dashboard.table.avalan.main-table-avalan")
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="ModalAvalanBlmProses" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="mdlMoreLabel">Avalan Belum Proses</h1>
                    <button type="button" onclick="closeModalBlmProses(this)" class="btn-close align-middle" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="row justify-content-between mb-2">
                        <div class="col-1">
                            <button type="submit" class="btn btn-primary" name="simpan"><i
                                    class="bi bi-floppy-fill"></i>
                                Simpan</button>
                        </div>
                        <div class="col-1 me-3">
                            <a href="{{url("admin/dashboard/print-avalan/1")}}"class="btn btn-primary bi bi-printer-fill"> </i>
                                Cetak</button></a>                                                               
                        </div>
                    </div>

                    <div id="avalanBlmProses">
                        @include('admin.dashboard.table.avalan.avalan-belum-proses')
                    </div>                    
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="ModalAvalanSdgProses" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="mdlMoreLabel">Avalan Sedang Proses</h1>
                    <button type="button" onclick="closeModalSdgProses(this)" class="btn-close align-middle" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body" >
                    <div class="row justify-content-between mb-2">
                        <div class="col-1">
                            <button type="submit" class="btn btn-primary" name="simpan"><i
                                    class="bi bi-floppy-fill"></i>
                                Simpan</button>
                        </div>
                        <div class="col-1 me-3">
                                <a href="{{url("admin/dashboard/print-avalan/2")}}"class="btn btn-primary bi bi-printer-fill"> </i>
                                    Cetak</button></a>                                
                        </div>
                    </div>
                    <div id="avalanSdgProses">
                        @include('admin.dashboard.table.avalan.avalan-sedang-proses')
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="ModalAvalanOk" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="mdlMoreLabel">Avalan Selesai</h1>
                    <button type="button" onclick="closeModalOk(this)" class="btn-close align-middle" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-between mb-2">
                        <div class="col-1">
                            <button type="submit" class="btn btn-primary" name="simpan"><i
                                    class="bi bi-floppy-fill"></i>
                                Simpan</button>
                        </div>
                        <div class="col-1 me-3">
                                <a href="{{url("admin/dashboard/print-avalan/3")}}"class="btn btn-primary bi bi-printer-fill"> </i>
                                    Cetak</button></a>                                
                        </div>
                    </div>
                    <div id="avalanOk">
                        @include("admin.dashboard.table.avalan.avalan-ok")    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="ModalAvalanSelisih" tabindex="-1">
        <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="mdlMoreLabel">Avalan Selisih</h1>
                    <button type="button" onclick="closeModalSelisih(this)" class="btn-close align-middle" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-between mb-2">
                        <div class="col-1">
                            <button type="submit" class="btn btn-primary" name="simpan"><i
                                    class="bi bi-floppy-fill"></i>
                                Simpan</button>
                        </div>
                        <div class="col-1 me-3">
                                <a href="{{url("admin/dashboard/print-avalan/4")}}"class="btn btn-primary bi bi-printer-fill"> </i>
                                    Cetak</button></a>                                
                        </div>
                    </div>
                    <div id="avalanSelisih">
                        @include("admin.dashboard.table.avalan.avalan-selisih")                      
                    </div>                    
                </div>
            </div>
        </div>
    </div>

    <script>
        var intervalAvalanBlmProses = undefined;
        var intervalAvalanSdgProses = undefined;
        var intervalAvalanOk = undefined;
        var intervalAvalanSelisih = undefined;

        setInterval(function(event) {
            $.ajax({
                url: "{{ url('admin/dashboard/main-table-avalan') }}",
                type: 'GET',
                success: function(data) {
                    $('#main-table-avalan').html(data);
                }
            });
            
        }, 1000);


        function openModalBlmProses(button) {
            $('#ModalAvalanBlmProses').modal('show');
            intervalAvalanBlmProses = setInterval(function() {
                $.ajax({
                    url: "{{ url('admin/dashboard/banner-avalan/1') }}",
                    type: 'GET',
                    success: function(data) {
                        $('#itemBlmProses').html(data);
                        console.log(data);

                    }
                });
            }, 1000);
        }

        function closeModalBlmProses(button) {
            if (typeof myTimeout != undefined) clearTimeout(intervalAvalanBlmProses);
            $('#ModalAvalanBlmProses').modal('hide');
        }

        function openModalSdgProses(button) {
            $('#ModalAvalanSdgProses').modal('show');
            intervalAvalanSdgProses = setInterval(function() {
                $.ajax({
                    url: "{{ url('admin/dashboard/banner-avalan/2') }}",
                    type: 'GET',
                    success: function(data) {
                        $('#itemSdgProses').html(data);
                        console.log(data);
                    }
                });
            }, 1000);
        }

        function closeModalSdgProses(button) {
            if (typeof myTimeout != undefined) clearTimeout(intervalAvalanSdgProses);
            $('#ModalAvalanSdgProses').modal('hide');
        }

        function openModalOk(button) {
            $('#ModalAvalanOk').modal('show');
            intervalAvalanOk = setInterval(function() {
                $.ajax({
                    url: "{{ url('admin/dashboard/banner-avalan/3') }}",
                    type: 'GET',
                    success: function(data) {
                        $('#itemOk').html(data);
                        console.log(data);
                    }
                });
            }, 1000);
        }

        function closeModalOk(button) {
            if (typeof myTimeout != undefined) clearTimeout(intervalAvalanOk);
            $('#ModalAvalanOk').modal('hide');
        }

        function openModalSelisih(button) {
            $('#ModalAvalanSelisih').modal('show');
            intervalAvalanSelisih = setInterval(function() {
                $.ajax({
                    url: "{{ url('admin/dashboard/banner-avalan/4') }}",
                    type: 'GET',
                    success: function(data) {
                        $('#itemSelisih').html(data);
                        console.log(data);
                    }
                });
            }, 1000);
        }

        function closeModalSelisih(button) {
            if (typeof myTimeout != undefined) clearTimeout(intervalAvalanSelisih);
            $('#ModalAvalanSelisih').modal('hide');
        }
    </script>
@endsection
