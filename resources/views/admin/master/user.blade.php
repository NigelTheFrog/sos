@extends('layouts.master')

@section('title','User')

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4">User</h1>   
    <div class="row justify-content-md-center">
        <div class="col-7">
            <div class="card mt-2">
                <div class="card-header bg-secondary text-white">
                    <h4 class="card-title pt-2">Daftar Pengguna</h4>
                </div>                   
                <div class="card-body" style="background-color:rgb(248, 248, 248)">
                    <table class="table table-sm table-bordered table-hover table-responsive small" style="background-color:rgb(255, 255, 255)">
                        <thead class="table-dark">
                            <tr class="text-center ">
                                <th class="align-middle" style="width: 2%">No</th>
                                <th class="align-middle" style="width: 15%">Nama</th>
                                <th class="align-middle" style="width: 7%">NIK</th>
                                <th class="align-middle" style="width: 10%">Username</th>
                                <th class="align-middle" style="width: 7%">Level</th>
                                <th class="align-middle" style="width: 8%">Action</th>
                            </tr>
                        </thead>
                        <tbody>                                
                            @foreach ($user as $index => $user)
                            <tr class="text-center">
                                <td class="align-middle">{{$index +1}}</td>
                                <td class="align-middle">{{$user->name}}</td>
                                <td class="align-middle">{{$user->nik}}</td>
                                <td class="align-middle">{{$user->username}}</td>
                                <td class="align-middle">{{$user->levelname}}</td>
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
    <div class="col-5">
        <div class="card mt-2">
            <div class="card-header bg-secondary text-white ">
                <h4 class="card-title mx-3 pt-2">Tambah Pengguna</h4>
            </div>
            <div class="card-body" style="background-color:rgb(248, 248, 248)">
                <form id="forminput" action="add-user.php" method="POST" class="needs-validation mx-3" novalidate >
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend" style="width:15%">
                                <span class="input-group-text w-100 d-flex justify-content-center"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" pattern="[a-zA-Z\s]+" name="nama" class="form-control" placeholder="Nama" required>
                            <div class="invalid-feedback">
                                Nama harus diisi, tidak boleh ada angka
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend" style="width:15%">
                                <span class="input-group-text w-100 d-flex justify-content-center"><i class="far fa-id-card"></i></span>
                            </div>
                            <input id="unik" type="text" pattern="[0-9]+" name="nik" class="form-control" placeholder="NIK" required>
                            <div class="invalid-feedback">
                                NIK harus diisi dengan angka
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend" style="width:15%">
                                <span class="input-group-text w-100 d-flex justify-content-center"><i class="fa fa-user"></i></span>
                            </div>
                            <input id="uname" type="text" pattern="[0-9a-zA-Z]+" name="username" class="form-control" placeholder="Username" required>
                            <div class="invalid-feedback">
                                username harus diisi
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend" style="width:15%">
                                <span class="input-group-text w-100 d-flex justify-content-center"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" minlength="4" name="password" class="form-control" placeholder="Password" required>
                            <div class="invalid-feedback">
                                Password harus diisi, minimal 4 digit
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend" style="width:15%">
                                <span class="input-group-text w-100 d-flex justify-content-center"><i class="fas fa-signal"></i></span>
                            </div>
                            <select class="form-select text-secondary" name="level" aria-label="pilih level" required>
                                <option selected value="" disabled>Pilih Level</option>
                                <option value="1">Administrator</option>
                                <option value="2">Super user</option>
                                <option value="3">Analisator</option>
                                <option value="4">Pelaku</option>
                                <option value="5">Warehouse</option>
                            </select>
                            <div class="invalid-feedback">
                                Level harus dipilih
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

@endsection