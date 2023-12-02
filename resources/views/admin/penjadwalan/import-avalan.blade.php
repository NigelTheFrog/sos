@extends('layouts.master')

@section('title','Impor Avalan')

@section('content')

<div class="container-fluid px-4">
    <div class="row justify-content-md-center">
        <div id="main" class="col">
            <div class="card mt-2">
                <div class="card-header bg-secondary text-white">
                    <h4 class="card-title pt-2">Impor Avalan</h4>
                </div>                   
                <div class="card-body" style="background-color:rgb(248, 248, 248)">
                    <table class="table table-sm table-bordered table-hover table-responsive small table-striped" style="background-color:rgb(255, 255, 255)">
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
                            <tr class="text-center">
                                <td class="align-middle"></td>
                                <td class="align-middle">{{$index +1}}</td>
                                <td class="align-middle">{{$avalan->itemcode}}</td>
                                <td class="align-middle">{{$avalan->itemname}}</td>
                                <td class="align-middle">
                                    @if ($avalan->heatno == null)
                                    -
                                    @else
                                    {{$avalan->heatno}}
                                    @endif</td>
                                <td class="align-middle">
                                    @if ($avalan->dimension == null)
                                    -
                                    @else
                                    {{$avalan->dimension}}
                                    @endif</td>
                                <td class="align-middle">
                                    @if ($avalan->tolerance == null)
                                    -
                                    @elseif ($avalan->tolerance == ".")
                                    -
                                    @else
                                    {{$avalan->tolerance}}
                                    @endif</td>
                                <td class="align-middle">
                                    @if ($avalan->kondisi == null)
                                    -
                                    @else
                                    {{$avalan->kondisi}}
                                    @endif</td>
                                <td class="align-middle">{{number_format((float)$avalan->qty, 2, '.', '')}}</td>
                                <td class="align-middle">{{$avalan->uom}}</td>

                            </tr>                                    
                            @endforeach                                
                        </tbody>
                    </table>
                                
                </div>
            </div> 
        </div> 
        <div class="pt-2 px-0" id="push-btn" style="width:4%">
            <button class="btn btn-secondary" type="button" id="openNav" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Buka Form Barang Temuan">
                <i class="fas fa-angle-left"></i></button>
        </div>

        <div id="mySidenav" class="pt-2 sidenav d-none" style="width:0%">
            <div class="card card-secondary">
                <div class="card-header d-flex flex-row">
                    <a class="pr-3" href="javascript:void(0)" class="closebtn" id="closeNav" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Tutup Form Barang Temuan"><i class="fas fa-angle-right"></i></a>
                    <h3 class="card-title">Barang Temuan</h3>
                </div>
                <div class="card-body">
                    <form action="add-import.php" method="POST" class="needs-validation" novalidate>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                                </div>
                                <input type="text" name="temuanname" class="form-control" id="temuanname" placeholder="Nama Item" required>
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
                                <input type="text" name="temuanheatno" class="form-control" id="temuanheatno" placeholder="Heat No">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                                </div>
                                <input type="text" name="temuandimension" class="form-control" id="temuandimension" placeholder="Dimensi">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                                </div>
                                <input type="text" name="temuancondition" class="form-control" id="temuancondition" placeholder="Kondisi">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                                </div>
                                <input type="text" pattern="[0-9]+" name="temuanstok" class="form-control" id="temuanstok" placeholder="QTY" required>
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
                                <input type="text" pattern="[a-zA-Z]+" name="satuan" class="form-control" id="satuan" placeholder="Satuan" required>
                                <div class="invalid-feedback">
                                    satuan harus diisi dan berupa huruf
                                </div>
                            </div>
                        </div>
                        <button type="reset" class="btn btn-danger" name="reset" title="Kosongkan data"><i class="fas fa-undo-alt"></i><span class="ps-2">Reset</span></button>
                        <button type="submit" class="btn btn-primary" name="simpanavalan" title="Tambah barang temuan, pastikan pengisian sesuai SOP"><i class="ion ion-plus"></i><span class="ps-2">Tambah</span></button>
                    </form>
                </div>
            </div>
            <div class="card text-bg-light">
                <!-- <div class="card-body "> -->
                <div class="card-body">
                    <span><i class="fas fa-info mr-2 mb-2"></i> Informasi Barang Temuan</span>
                    <p class="small text-muted"><em>Jika di lapangan ditemukan barang diluar list <strong>Impor stok</strong>, pastikan barang diinput di form <strong>Barang Temuan</strong> diatas. <br />
                            <span class="text-info">Barang temuan ditandai dengan background warna biru di list <strong>Impor Stok</strong> </span></em>
                    </p>
                </div>
                <!-- </div> -->
            </div>
        </div>
    
</div>
<script>
    $(document).ready(function() {
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