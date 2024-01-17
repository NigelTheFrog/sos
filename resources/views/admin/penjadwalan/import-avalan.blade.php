@extends('layouts.master')

@section('title', 'Impor Avalan')

@section('content')
    <style>
        .vscomp-toggle-button {
            padding: 10px 30px 10px 10px;
            border-radius: 7px
        }
    </style>
    <div class="container-fluid px-4">
        <div class="row justify-content-md-center">
            <div id="main" class="col">
                <div class="card mt-2">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="card-title pt-2">Impor Avalan</h4>
                    </div>
                    <div class="card-body" style="background-color:rgb(248, 248, 248)">
                        <div class="d-flex ">
                            <button type="button" class="btn btn-primary float-start mb-3" data-bs-toggle="modal"
                                data-bs-target="#modalImportAvalan">
                                <i class="nav-icon fas fa-file-import"></i> Import Avalan
                            </button>
                        </div>
                        <form action="{{ route('import-avalan.destroy', 'checkboxDelete') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal fade text-left" id="modalDeleteAvalan" tabindex="-1">
                                <div class="modal-dialog modal modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="mdlMoreLabel">Konfirmasi</h1>
                                        </div>
                                        <div class="modal-body">
                                            <p>Apakah Anda yakin hendak menghapus item yang sudah dipilih?</p>
                                            <button type="submit" class="btn btn-danger" name="simpan"><i
                                                    class="bx bxs-save"></i>Iya</button>
                                            <button type="button" data-bs-dismiss="modal" class="btn btn-primary"
                                                name="simpan"><i class="bx bxs-save"></i>Batal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-group form-check ">
                                    <input class="form-check-input cekdelete" type="checkbox" value="" id="cekdelete">
                                    <label class="form-check-label" for="cekdelete">
                                        Centang Semua
                                    </label>
                                </div>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalDeleteAvalan" title="Hapus Centang" id="btnHapus"
                                    data-id=""><i class="fas fa-trash-alt"></i>
                                    Hapus Checklist</button>
                            </div>
                            <table class="table table-sm table-bordered table-hover table-responsive small table-striped"
                                style="background-color:rgb(255, 255, 255)">
                                <thead class="table-dark">
                                    <tr class="text-center ">
                                        <th style="width: 2%"></th>
                                        <th class="align-middle" style="width: 2%">No</th>
                                        <th class="align-middle" style="width: 10%">Kode Item</th>
                                        <th class="align-middle" style="width: 8%">Nama Item</th>
                                        <th class="align-middle" style="width: 8%">Heat No</th>
                                        <th class="align-middle" style="width: 5%">Dimension</th>
                                        <th class="align-middle" style="width: 5%">Tolerance</th>
                                        <th class="align-middle" style="width: 5%">Condition</th>
                                        <th class="align-middle" style="width: 5%">Jumlah</th>
                                        <th class="align-middle" style="width: 5%">Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($avalan as $index => $avalan)
                                        <tr
                                            class="text-center
                                        @if ($avalan->statusitem == 'T') table-info @endif">
                                            <td class="align-middle">
                                                <div class="form-check">
                                                    <input type="checkbox" name="checkboxDelete[]"
                                                        class="form-check-input cekboxdelete"
                                                        value={{ $avalan->itembatchid }}>
                                                </div>
                                            </td>
                                            <td class="align-middle">{{ $index + 1 }}</td>
                                            <td class="align-middle">{{ $avalan->itemcode }}</td>
                                            <td class="align-middle">{{ $avalan->itemname }}</td>
                                            <td class="align-middle">
                                                @if ($avalan->heatno == null)
                                                    -
                                                @else
                                                    {{ $avalan->heatno }}
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                @if ($avalan->dimension == null)
                                                    -
                                                @else
                                                    {{ $avalan->dimension }}
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                @if ($avalan->tolerance == null)
                                                    -
                                                @elseif ($avalan->tolerance == '.')
                                                    -
                                                @else
                                                    {{ $avalan->tolerance }}
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                @if ($avalan->kondisi == null)
                                                    -
                                                @else
                                                    {{ $avalan->kondisi }}
                                                @endif
                                            </td>
                                            <td class="align-middle">{{ number_format((float) $avalan->qty, 2, '.', '') }}
                                            </td>
                                            <td class="align-middle">{{ $avalan->uom }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>

                    </div>
                </div>
            </div>
            <div class="pt-2 px-0" id="push-btn" style="width:4%">
                <button class="btn btn-secondary" type="button" id="openNav" data-bs-toggle="tooltip"
                    data-bs-placement="left" data-bs-title="Buka Form Barang Temuan">
                    <i class="fas fa-angle-left"></i></button>
            </div>
            <div id="mySidenav" class="pt-2 sidenav d-none" style="width:0%">
                <div class="card card-secondary">
                    <div class="card-header d-flex flex-row">
                        <a class="pr-3" href="javascript:void(0)" class="closebtn" id="closeNav"
                            data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Tutup Form Barang Temuan"><i
                                class="fas fa-angle-right"></i></a>
                        <h3 class="card-title">Barang Temuan</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('import-avalan.store') }}" method="POST" class="needs-validation"
                            novalidate>
                            @csrf
                            <input type="text" name="type" value="2" hidden>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                                    </div>
                                    <input type="text" name="temuanname" class="form-control" id="temuanname"
                                        placeholder="Nama Item" required>
                                    <div class="invalid-feedback">
                                        Nama Item harus diisi
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                                    </div>
                                    <input type="text" name="temuanheatno" class="form-control" id="temuanheatno"
                                        placeholder="Heat No">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                                    </div>
                                    <input type="text" name="temuandimension" class="form-control"
                                        id="temuandimension" placeholder="Dimensi">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                                    </div>
                                    <input type="text" name="temuancondition" class="form-control"
                                        id="temuancondition" placeholder="Kondisi">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                                    </div>
                                    <input type="text" pattern="[0-9]+" name="temuanstok" class="form-control"
                                        id="temuanstok" placeholder="QTY" required>
                                    <div class="invalid-feedback">
                                        Quantity harus diisi dan berupa angka
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-ruler-combined"></i></span>
                                    </div>
                                    <input type="text" pattern="[a-zA-Z]+" name="satuan" class="form-control"
                                        id="satuan" placeholder="Satuan" required>
                                    <div class="invalid-feedback">
                                        satuan harus diisi dan berupa huruf
                                    </div>
                                </div>
                            </div>
                            <button type="reset" class="btn btn-danger" name="reset" title="Kosongkan data"><i
                                    class="fas fa-undo-alt"></i><span class="ps-2">Reset</span></button>
                            <button type="submit" class="btn btn-primary" name="simpanavalan"
                                title="Tambah barang temuan, pastikan pengisian sesuai SOP"><i
                                    class="ion ion-plus"></i><span class="ps-2">Tambah</span></button>
                        </form>
                    </div>
                </div>
                <div class="card text-bg-light">
                    <!-- <div class="card-body "> -->
                    <div class="card-body">
                        <span><i class="fas fa-info mr-2 mb-2"></i> Informasi Barang Temuan</span>
                        <p class="small text-muted"><em>Jika di lapangan ditemukan barang diluar list <strong>Impor
                                    stok</strong>, pastikan barang diinput di form <strong>Barang Temuan</strong> diatas.
                                <br />
                                <span class="text-info">Barang temuan ditandai dengan background warna biru di list
                                    <strong>Impor Stok</strong> </span></em>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="modalImportAvalan" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="mdlMoreLabel">Data Stok Batch ERP</h1>
                    <button type="button" class="btn-close align-middle" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-between ps-2 mb-2 pe-2 bg-light align-items-center"
                        style="height: 50px">
                        <div class="col">
                            <div class="d-flex justify-content-between" style="width: 50%">
                                <b class="mt-1">Pilih Gudang:</b>
                                <select id="wrhSelect" multiple name="gudang[]" placeholder="Daftar Gudang"
                                    data-search="true" data-silent-initial-value-set="true">
                                    @foreach ($response_wrh['data'] as $wrh)
                                        <option value="{{ $wrh['WhseCode'] }}">{{ $wrh['WhseCode'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-between">
                                <form class="" role="search">
                                    <input class="form-control" id="searchAvalan" type="search" placeholder="Search"
                                        aria-label="Search">
                                </form>
                                <button type="button" id="tarikitem" class="btn btn-primary float-end"
                                    onclick="tarikAvalan(this)">
                                    Tarik Data
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div id="tableAvalan">
                        @include('admin.penjadwalan.avalan.table-pull-import-avalan')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        VirtualSelect.init({
            ele: '#wrhSelect'
        });

        function tarikAvalan(button) {
            var selectedGudang = $("#wrhSelect").val(); // Get the selected gudang values
            var search = $("#searchAvalan").val();
            // Make an AJAX request to fetch data from the server
            $.ajax({
                url: "{{ url('admin/penjadwalan/import-avalan/pull-import') }}",
                method: "POST",
                data: {
                    gudang: selectedGudang,
                    search: search
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('#tableAvalan').html(data);
                },
                error: function() {
                    // Handle error cases if necessary
                    alert("Error fetching data from the server.");
                }
            });
        }

        $(document).ready(function() {
            $(".cekdelete").click(function() {
                if ($(".cekboxdelete").prop("checked")) {
                    $(".cekboxdelete").prop("checked", false);
                } else {
                    $(".cekboxdelete").prop("checked", true);
                }
            });
            $("#openNav").click(function() {
                $('#push-btn').addClass('d-none');
                $("#mySidenav").removeClass('d-none');
                $("#mySidenav").stop().animate({
                    width: "29%"
                }, 500); // 500 milliseconds (0.5 seconds) animation duration
                $("#main").stop().animate({
                    width: "70%"
                }, 500); // 500 milliseconds (0.5 seconds) animation duration
            });

            /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
            $("#closeNav").click(function() {
                $("#mySidenav").stop().animate({
                    width: "0%"
                }, 500); // 500 milliseconds (0.5 seconds) animation duration
                $("#main").stop().animate({
                    width: "96%"
                }, 500); // 500 milliseconds (0.5 seconds) animation duration
                setTimeout(function() {
                    $("#push-btn").removeClass('d-none');
                    $("#mySidenav").addClass('d-none');
                }, 500); // Delay for 0.5 seconds (500 milliseconds)
            });
        });
    </script>

@endsection
