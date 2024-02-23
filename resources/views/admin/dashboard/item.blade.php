@extends('layouts.master')

@section('title', 'Dashboard Item')

@section('content')

    <div class="container-fluid px-4">
        <div class="row justify-content-between align-items-center my-4">
            <div class="col">
                <h1>Dashboard Item</h1>
            </div>
            <input type="text" id="countCsoActive" value="{{ $countCsoActive }}" hidden>
            @if (Auth::user()->level == 1 || Auth::user()->level == 2)
                <div class="col-4">
                    <div class="d-flex justify-content-end">
                        <div class="col align-items-end">
                            <input class=" form-control col-9 text-center bg-dark-subtle float-end" type="text"
                                placeholder="{{ $csodate }}" aria-label="Disabled input example" style="width: 200px"
                                disabled>
                        </div>
                        <div class="col align-items-end">
                            @if ($countCsoActive > 0)
                                <button type="button" onclick="openModalCSO(this,1)" class="btn btn-warning float-end"
                                    value="1" id="buttonTutupCso" @if ($countCsoActive > 0) disabled @endif>
                                    <i class="bi bi-stopwatch-fill"></i> Tutup Akses Mobile
                                </button>
                            @elseif ($countCsoEnd > 0)
                                <button type="button" onclick="openModalCSO(this,2)" class="btn btn-danger float-end"
                                    value="2">
                                    <i class="bi bi-stopwatch-fill"></i> Finish CSO
                                </button>
                            @else
                                <button type="button" onclick="openModalCSO(this,3)" class="btn btn-primary float-end"
                                    value="3">
                                    <i class="bi bi-stopwatch-fill"></i> Mulai CSO Item
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            @endif

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
                        {{-- <div style="overflow: auto; max-height: 70vh;"> --}}
                        <div id="itemBlmProses" style="overflow: auto; max-height: 75vh;">
                            @include('admin.dashboard.table.item.item-belum-proses')
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

                        <div id="itemOk" style="overflow: auto; max-height: 75vh;">
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
                            <div id="itemSelisih" style="overflow: auto; max-height: 75vh;">
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
            <div class="card-body" id="main-table-item" style="overflow: auto">
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

    <div class="modal fade text-left" id="ModalDetailCso" tabindex="-1">
        <form id="formSubmitCso" action="" method="POST">
            @csrf
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-secondary text-white">
                        <h1 class="modal-title fs-5" id="detailCsoHeader"></h1>
                        <button type="button" class="btn-close btn-close-white align-middle" data-bs-dismiss="modal"
                            aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body" id="detailCso">
                        <table class="table table-sm table-bordered small mb-3 text-center">
                            <thead class="table-secondary">
                                <tr>
                                    <th scope="col">Heat Number</th>
                                    <th scope="col">Dimension</th>
                                    <th scope="col">Tolerance</th>
                                    <th scope="col">Condition</th>
                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                        <div id="warning" class="alert alert-warning d-none"></div>
                        <input type="text" name="itemid" class="d-none" value="">

                        <div class="row g-3 mb-3">
                            <div class="form-floating col">
                                <input class="form-control text-center bg-primary shadow-sm" value=""
                                    id="onHand" type="text" readonly>
                                <label class="fw-bold" for="onHand">On Hand</label>
                            </div>
                            <div class="form-floating col">
                                <input class="form-control text-center bg-warning shadow-sm" value=""
                                    type="text" readonly>
                                <label class="fw-bold">Qty CSO</label>
                            </div>
                            <div class="form-floating col">
                                <input class="form-control text-center bg-danger shadow-sm" value="" type="text"
                                    readonly>
                                <label class="fw-bold" for="vselisih">Selisih</label>
                            </div>
                            <div class="form-floating col">
                                <input class="form-control text-center shadow-sm" name="koreksi" value=""
                                    type="number">
                                <label class="fw-bold" for="vkoreksi">Input Koreksi</label>
                            </div>
                            <div class="form-floating col">
                                <input class="form-control text-center shadow-sm" name="deviasi" value=""
                                    type="number">
                                <label class="fw-bold" for="vdeviasi">Input Deviasi</label>
                            </div>
                        </div>
                        <div id="tbldetail">
                            <table class="table table-sm table-hover table-bordered table-responsive-md small shadow-sm">
                                <thead class="table-secondary">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Pelaku</th>
                                        <th scope="col">Lokasi</th>
                                        <th scope="col">Color</th>
                                        <th scope="col">Qty/lokasi</th>
                                        <th scope="col">CSO ke-</th>
                                        <th scope="col">Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <div class="row mb-2">
                            <div class="col-7">
                                <table
                                    class="table table-sm table-responsive-md table-hover table-bordered shadow-sm small">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th scope="col">Pelaku</th>
                                            <th scope="col">CSO 1</th>
                                            <th scope="col">CSO 2</th>
                                            <th scope="col">CSO 3</th>
                                            <th scope="col">CSO 4</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>
                            </div>
                            <div class="col-2">
                                <button type="button" name="csoorder" class="btn btn-info mb-3">CSO Ulang</button>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkkesalahanadmin"
                                        name="check_kesalahan_admin">
                                    <label class="form-check-label small" for="checkkesalahanadmin">
                                        Kesalahan Admin
                                    </label>
                                </div>
                            </div>
                            <div class="col-3 small">
                                <div class="w-100 mb-2">
                                    <label class="input-group-text small">Analisator</label>
                                    <select class="form-select form-select-sm" id="" name="analisator"
                                        @if (Auth::user()->level != 1 && Auth::user()->level != 2) disabled @endif>

                                    </select>
                                </div>
                                <div class="w-100 mb-2">
                                    <label class="input-group-text small">Grouping</label>
                                    <select class="form-select form-select-sm" id="" name="grouping">

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <label for="vketerangan" class="input-group-text">Keterangan Koreksi</label>
                            <textarea class="form-control form-control-sm" name="keterangan" id="vketerangan"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button id="buttonSubmit" type="button" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        var intervalItemBlmProses = undefined;
        var intervalItemOk = undefined;
        var intervalItemSelisih = undefined;
        var intervalCheckItemBlmProses = undefined;
        var buttonTutupCso = document.getElementById('buttonTutupCso');

        if ($('#countCsoActive').val() == 1) {
            setInterval(function(event) {
                $.ajax({
                    url: "{{ url('admin/dashboard/check-item') }}",
                    type: 'GET',

                    success: function(data) {
                        if (data['data']) {
                            buttonTutupCso.disabled = true;
                        } else {
                            buttonTutupCso.disabled = false;
                        }
                    }
                });
            }, 1000);
        } else {
            if (typeof myTimeout != undefined) clearTimeout(intervalCheckItemBlmProses);
        }

        function openModalDetailCSO(button) {
            const row = $(button).closest('tr');
            const itemId = row.find('td:nth-child(1)').text();
            const batchId = row.find('td:nth-child(2)').text();
            const itemName = row.find('td:nth-child(3)').text();
            document.getElementById("detailCsoHeader").innerText = `DETAIL ${itemName.replace(/(\r\n|\n|\r)/gm, '')}`;
            $.ajax({
                url: "{{ route('item.detail-cso') }}",
                type: 'POST',
                data: {
                    id: itemId.replace(/\s/g, ''),
                    batchno: batchId.replace(/\s/g, '')
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('#detailCso').html(data);
                    $('#formSubmitCso').attr('action', `{{ route('item.update-cso') }}`);
                    $("#buttonSubmit").attr('type', 'submit');
                },
                error: function() {
                    alert("Error");
                    // Handle error cases if necessary
                    // Swal.fire({
                    //     icon: "error",
                    //     title: "Oops...",
                    //     text: "Tidak terdapat item pada gudang tersebut",
                    // });
                }

            });
            $('#ModalDetailCso').modal('show');
        }

        setInterval(function(event) {
            var searchValue = $("#searchModItem").val();
            $.ajax({
                url: "{{ url('admin/dashboard/main-table-item') }}",
                type: 'POST',
                data: {
                    search: searchValue
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    // console.log(data);
                    $('#main-table-item').html(data);
                }
            });
        }, 1000);

        setInterval(function(event) {
            $.ajax({
                url: "{{ url('admin/dashboard/banner-item') }}",
                type: 'GET',

                success: function(data) {
                    $('#banner-item').html(data);
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
                $('#modalActionCSO').attr('action', `{{ route('item.update', 'item') }}`);
            } else if (type == 2) {
                document.getElementById("modalHeader").innerText = `Mengakhiri CSO`;
                document.getElementById("warning").innerText = `Apakah anda yakin akan mengakhiri cek stok Item?`;
                $('#modalActionCSO').attr('action', `{{ route('item.destroy', 'item') }}`);
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
