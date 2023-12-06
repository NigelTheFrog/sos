@extends('layouts.master')

@section('title','Keputusan')

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4">Keputusan</h1>   
    <div class="row justify-content-md-center">
        <div class="col-7">
            <div class="card mt-2">
                <div class="card-header bg-secondary text-white">
                    <h4 class="card-title pt-2">Master Keputusan</h4>
                </div>                   
                <div class="card-body" style="background-color:rgb(248, 248, 248)">
                    <table class="table table-sm table-bordered table-hover table-responsive small" style="background-color:rgb(255, 255, 255)">
                        <thead class="table-dark">
                            <tr class="text-center ">
                                <th class="align-middle" style="width: 2%">No</th>
                                <th class="align-middle" style="width: 20%">Keputusan</th>
                                <th class="align-middle" style="width: 8%">Action</th>
                                <th hidden></th>
                            </tr>
                        </thead>
                        <tbody>                                
                            @foreach ($keputusan as $index => $kep)
                            <tr class="text-center">
                                <td class="align-middle">{{$index +1}}</td>
                                <td class="align-middle">{{$kep->keputusandesc}}</td>
                                <td class="align-middle"> 
                                    <button type="button" onclick="openModalEdit(this)" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target=""><i class="bi bi-pencil-square"></i></button>
                                    <button type="button" onclick="openModalDelete(this)" class="btn btn-danger btn-sm" title="Hapus User" id="btnHapus" data-id=""><i class="bi bi-trash-fill"></i></button>
                                </td>
                                <td hidden>{{$kep->keputusanid}}</td>
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
                    <h4 class="card-title mx-3 pt-2">Tambah Keputusan</h4>
                </div>
                <div class="card-body" style="background-color:rgb(248, 248, 248)">
                    <form id="forminput" action="{{route("keputusan.store")}}" method="POST" class="needs-validation mx-3" novalidate >
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="text" name="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi Keputusan" required>
                                <div class="invalid-feedback">
                                    Deskripsi harus diisi
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
<div class="modal fade text-left" id="ModalEditKeputusan" tabindex="-1">
    <div class="modal-dialog modal modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mdlMoreLabel">Ubah Data Keputusan</h1>
                <button type="button" class="btn-close align-middle" onclick="closeModalEdit(this)" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form id="editform" action="" method="POST" class="needs-validation mx-3" novalidate >
                    @csrf 
                    @method('PUT')
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="text" name="deskripsi" class="form-control" id="editdeskripsi" placeholder="Deskripsi Keputusan" required>
                            <div class="invalid-feedback">
                                Deskripsi harus diisi
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
<div class="modal fade text-left" id="ModalDeleteKeputusan" tabindex="-1">
    <div class="modal-dialog modal modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mdlMoreLabel">Hapus Data Keputusan</h1>                
            </div>
            <div class="modal-body">
                <form id="deleteform" action="" method="POST" class="needs-validation mx-3" novalidate >
                    @csrf
                    @method('DELETE')
                    <p id="warning"></p>
                    <button type="submit" class="btn btn-danger" name="simpan"><i class="bx bxs-save"></i>Iya</button>                    
                    <button type="button" onclick="closeModalDelete(this)" class="btn btn-primary" name="simpan"><i class="bx bxs-save"></i>Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function openModalEdit(button) {
        $('#ModalEditKeputusan').modal('show');
        var row = $(button).closest('tr');
        var keputusanid = row.find('td:nth-child(4)').text();
        $('#editdeskripsi').attr('value', row.find('td:nth-child(2)').text());
        $('#editform').attr('action',`{{url('admin/master/keputusan/${keputusanid}')}}`);
    }
    function closeModalEdit(button) {
        $('#ModalEditKeputusan').modal('hide');
    }
    function openModalDelete(button) {
        $('#ModalDeleteKeputusan').modal('show');
        var row = $(button).closest('tr');
        var deskripsi = row.find('td:nth-child(2)').text();
        var keputusanid = row.find('td:nth-child(4)').text();
        document.getElementById("warning").innerText = `Apakah anda akan melanjutkan penghapusan data keputusan ${deskripsi}?`;
        $('#deleteform').attr('action',`{{url('admin/master/keputusan/${keputusanid}')}}`);    
    }
    function closeModalDelete(button) {
        $('#ModalDeleteKeputusan').modal('hide');
    }
</script>
@endsection