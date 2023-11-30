@extends('layouts.master')

@section('title','Area Lokasi')

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4">Area Lokasi</h1>   
    <div class="row justify-content-md-center">
        <div class="col-7">
            <div class="card mt-2">
                <div class="card-header">
                    <div class="col">
                        <h3 class="card-title ps-1">Data Lokasi</h3>
                    </div>                    
                    <div class="card-body">
                        <table class="table table-sm table-bordered table-hover table-responsive small">
                            <thead class="table-dark">
                                <tr class="text-center ">
                                    <th class="align-middle" style="width: 2%">No</th>
                                    <th class="align-middle" style="width: 5%">Kode Lokasi</th>
                                    <th class="align-middle" style="width: 20%">Nama Lokasi</th>
                                    <th class="align-middle" style="width: 8%">Action</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($lokasi as $index => $loct)
                                <tr class="text-center">
                                    <td class="align-middle">{{$index +1}}</td>
                                    <td class="align-middle">{{$loct->locationcode}}</td>
                                    <td class="align-middle">{{$loct->locationname}}</td>
                                    <td class="align-middle"> 
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target=""><i class="bi bi-pencil-square"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" title="Hapus User" id="btnHapus" data-id=""><i class="bi bi-trash-fill"></i></button>
                                    </td>
                                </tr>                                    
                                @endforeach                                
                            </tbody>
                        </table>
                    </div>               
                </div>
            </div>   
        </div> 
        <div class="col-5">
            <div class="card mt-2">
                <div class="card-header">
                    <div class="row justify-content-between pt-2 ps-4 pe-3">
                        <div class="col">
                            <h3 class="card-title">Tambah Lokasi</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="forminput" action="add-user.php" method="POST" class="needs-validation" novalidate>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="text" name="usertype" class="form-control" id="usertype" placeholder="Kode Lokasi" required>
                                    <div class="invalid-feedback">
                                        Kode lokasi harus diisi
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                                    </div>
                                    <input type="text" name="deskripsi" class="form-control" id="deskripsi" placeholder="Nama Lokasi" required>
                                    <div class="invalid-feedback">
                                        Nama lokasi harus diisi
                                    </div>
                                </div>
                            </div>                           
                            <button type="reset" class="btn btn-danger" name="reset"><i class="bx bx-reset"></i> Reset</button>
                            <button type="submit" class="btn btn-primary" name="simpan"><i class="bx bxs-save"></i> Simpan</button>
                        </form>
                    </div>               
                </div>
            </div>   
        </div> 
    </div>
</div>
@endsection