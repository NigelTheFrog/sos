@extends('layouts.master')

@section('title', 'Dashboard Item')

@section('content')

    <div class="container-fluid px-4">
        <div class="row justify-content-between align-items-center mt-4">
            <div class="col-4">
                <h1>Dashboard Item</h1>
            </div>
            <div class="col-4">
                @if ($countCsoActive > 0)
                    <button type="button" onclick="openModalCSO(this,1)" class="btn btn-warning float-end" value="1">
                        <i class="bi bi-stopwatch-fill"></i> Tutup CSO Item
                    </button>
                @elseif ($countCsoEnd > 0)
                    <button type="button" onclick="openModalCSO(this,2)" class="btn btn-danger float-end" value="2">
                        <i class="bi bi-stopwatch-fill"></i> Akhiri CSO Item
                    </button>
                @else
                    <button type="button" onclick="openModalCSO(this,3)" class="btn btn-primary float-end" value="3">
                        <i class="bi bi-stopwatch-fill"></i> Mulai CSO Item
                    </button>
                @endif
            </div>
        </div>
        <div class="row justify-content-between align-items-center mb-2">
            <div class="col-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard Item</li>
                </ol>
            </div>
            <div class="col-4">
                <input class=" form-control col-9 text-center bg-dark-subtle float-end" type="text" placeholder="{{ $csodate }}"
                    aria-label="Disabled input example" style="width: 200px" disabled>
            </div>
        </div>

        <div class="row" id="banner-item">
            @include('admin.dashboard.banner.banner-item')
        </div>
        <div class="modal fade text-left" id="ModalItemBlmProses" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="mdlMoreLabel">Item Belum Proses</h1>
                        <button type="button" onclick="closeModalBlmProses(this)" class="btn-close align-middle"
                            data-bs-dismiss="modal" aria-label="Close">
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
                                <a
                                    href="{{ url('admin/dashboard/print-item/1') }}"class="btn btn-primary bi bi-printer-fill">
                                    </i>
                                    Cetak</button></a>
                            </div>
                        </div>
                        <div id="itemBlmProses">
                            @include('admin.dashboard.table.item.item-belum-proses')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="ModalItemSdgProses" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="mdlMoreLabel">Item Sedang Proses</h1>
                        <button type="button" class="btn-close align-middle" data-bs-dismiss="modal"
                            onclick="closeModalSdgProses(this)" aria-label="Close">
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
                                <a
                                    href="{{ url('admin/dashboard/print-item/2') }}"class="btn btn-primary bi bi-printer-fill">
                                    </i>
                                    Cetak</button></a>
                            </div>
                        </div>

                        <div id="itemSdgProses">
                            @include('admin.dashboard.table.item.item-sedang-proses')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="ModalItemOk" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="mdlMoreLabel">Item Ok</h1>
                        <button type="button" class="btn-close align-middle" data-bs-dismiss="modal"
                            onclick="closeModalOk(this)" aria-label="Close">
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
                                <a
                                    href="{{ url('admin/dashboard/print-item/3') }}"class="btn btn-primary bi bi-printer-fill">
                                    </i>
                                    Cetak</button></a>
                            </div>
                        </div>

                        <div id="itemOk">
                            @include('admin.dashboard.table.item.item-ok')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="ModalItemSelisih" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="mdlMoreLabel">Item Selisih</h1>
                        <button type="button" class="btn-close align-middle" data-bs-dismiss="modal"
                            onclick="closeModalSelisih(this)" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            @csrf
                            @method('PUT')
                            <div class="row justify-content-between mb-2">
                                <div class="col-1">
                                    <button type="submit" class="btn btn-primary" name="simpan"><i
                                            class="bi bi-floppy-fill"></i>
                                        Simpan</button>
                                </div>
                                <div class="col-1 me-3">
                                    <a
                                        href="{{ url('admin/dashboard/print-item/4') }}"class="btn btn-primary bi bi-printer-fill">
                                        </i>
                                        Cetak</button></a>
                                </div>
                            </div>
                            <div id="itemSelisih">
                                @include('admin.dashboard.table.item.item-selisih')
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <div class="row justify-content-between mt-2 ms-4 me-3">
                    <div class="col">
                        <h3 class="card-title">Hasil Stock Opname</h3>
                    </div>
                    <div class="col-4 float-end">
                        <form class="" role="search">
                            <input class="form-control" id="searchModItem" type="search" placeholder="Search"
                                aria-label="Search">
                        </form>
                    </div>

                </div>
            </div>
            <div class="card-body ms-4 me-3" id="main-table-item">
                @include('admin.dashboard.table.item.main-table-item')
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="ModalCSO" tabindex="-1">
        <div class="modal-dialog modal modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalHeader"></h1>
                </div>
                <div class="modal-body">
                    <form id="modalActionCSO" action="" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @if ($countCsoActive > 0)
                            @method('PUT')
                        @elseif ($countCsoEnd > 0)
                            @method('DELETE')
                        @endif
                        <p id="warning"></p>
                        <button type="submit" class="btn btn-danger" name="simpan"><i
                                class="bx bxs-save"></i>Iya</button>
                        <button type="button" onclick="closeModalCSO(this)" class="btn btn-primary" name="simpan"><i
                                class="bx bxs-save"></i>Batal</button>
                    </form>
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

        function openModalCSO(button, type) {
            $('#ModalCSO').modal('show');
            if (type == 1) {
                document.getElementById("modalHeader").innerText = `Menghentikan CSO`;
                document.getElementById("warning").innerText =
                    `Apakah anda yakin akan menghentikan proses penghitungan cek stok item?`;
                $('#modalActionCSO').attr('action', `{{ route('item.update','item') }}`);
            } else if (type == 2) {
                document.getElementById("modalHeader").innerText = `Mengakhiri CSO`;
                document.getElementById("warning").innerText = `Apakah anda yakin akan mengakhiri cek stok Item?`;
                $('#modalActionCSO').attr('action', `{{ route('item.destroy','item') }}`);
            } else {
                document.getElementById("modalHeader").innerText = `Memulai CSO`;
                document.getElementById("warning").innerText = `Apakah anda yakin akan memulai cek stok item?`;
                $('#modalActionCSO').attr('action', `{{ route('item.store') }}`);
            }
        }

        function closeModalCSO(button) {
            $('#ModalCSO').modal('hide');
        }
    </script>
@endsection
