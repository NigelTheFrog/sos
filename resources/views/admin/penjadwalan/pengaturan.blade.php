@extends('layouts.master')

@section('title','Pengaturan CSO')

@section('content')
<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>   
</head>

<style>
    .vscomp-toggle-button {
            padding: 10px 30px 10px 10px;
            border-radius: 7px;
            /* width: 60vh */
        }
</style>

<div class="container-fluid px-4">
    <div class="row justify-content-md-center">
        <div class="col-7">
            <div class="card mt-2">
                <div class="card-header bg-secondary text-white">
                    <h4 class="card-title pt-2">Pengaturan CSO</h4>
                </div>                   
                <div class="card-body" style="background-color:rgb(248, 248, 248)">
                    <p>Tipe Cek Stok :<strong> 
                        {{ $csotype }}                                           
                    </strong></p>                    
                    <p>Item yang di CSO :<strong>                         
                        {{ $csoitem }}                                                 
                    </strong></p>
                    <table class="table table-sm table-bordered table-hover table-responsive small" style="background-color:rgb(255, 255, 255)">
                        <thead class="table-dark">
                            <tr class="text-center ">
                                <th class="align-middle" style="width: 2%">No</th>
                                <th class="align-middle" style="width: 15%">Nama User</th>
                                <th class="align-middle" style="width: 7%">Posisi</th>
                                <th class="align-middle" style="width: 8%">Action</th>
                            </tr>
                        </thead>
                        <tbody>                                
                            @foreach ($jobtype as $index => $jobtype)
                            <tr class="text-center">
                                <td class="align-middle">{{$index +1}}</td>
                                <td class="align-middle">{{$jobtype->name}}</td>
                                <td class="align-middle">{{$jobtype->jobtypename}}</td>
                                <td class="align-middle"> 
                                    <button type="button" onclick="openModalDelete(this)" class="btn btn-danger btn-sm" title="Hapus User" id="btnHapus" data-id=""><i class="bi bi-trash-fill"></i></button>
                                </td>
                                <td class="align-middle" hidden>{{$jobtype->jobid}}</td>
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
                <h4 class="card-title mx-3 pt-2">Atur Rencana CSO</h4>
            </div>
            <div class="card-body" style="background-color:rgb(248, 248, 248)">
                <form id="forminput" action="{{route('pengaturan.store')}}" method="POST" class="needs-validation mx-3" novalidate >
                    @csrf
                    <input type="text" name="type" value="1" hidden>
                    <div class="mb-2">
                        <label for="" class="form-label">Tipe Cek Stok</label>
                        <div class="row">
                            <div style="width:70%" class="form-group">
                                <select id="multipleSelect" name="typestock" placeholder="Tipe Cek Stok" data-search="true" data-silent-initial-value-set="true">
                                    <option value="CSO">CSO</option>
                                    <option value="CSS">CSS</option>
                                </select>
                            </div>
                            <div style="width:30%" class="">
                                <button type="submit" name="submitTypeStock" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="forminput" action="{{route('pengaturan.store')}}" method="POST" class="needs-validation mx-3" novalidate >
                    @csrf
                    <input type="text" name="type" value="2" hidden>
                    <div class="mb-2">
                        <label for="" class="form-label">Item yang di CSO</label>
                        <div class="row">
                            <div style="width:70%">
                                <select multiple id="multipleItem" name="itemcso[]" placeholder="Item yang ada di CSO" data-search="true" data-silent-initial-value-set="true" style="width: 10">
                                    @foreach ($category as $cat)
                                    <option value="{{$cat->categorydesc}}">{{$cat->categorydesc}}</option>                                
                                    @endforeach                                        
                                </select>
                            </div>
                            <div style="width:30%" class="">
                                <button type="submit" name="setMaterial" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="forminput" action="{{route('pengaturan.store')}}" method="POST" class="needs-validation mx-3" novalidate >
                    @csrf
                    <input type="text" name="type" value="3" hidden>
                    <div class="mb-2">
                        <label for="" class="form-label">Masukkan Nama Pelaku</label>
                        <div class="row">
                            <div style="width:70%" class="form-group">
                                <select multiple id="multiplePelaku" name="pelaku[]" placeholder="Pilih Nama Checker" data-search="true" data-silent-initial-value-set="true">
                                    @foreach ($pelaku as $user)
                                    <option value={{$user->userid}}>{{$user->nik}} - {{$user->name}}</option>                                
                                    @endforeach    
                                </select>
                            </div>
                            <div style="width:30%" class="">
                                <button type="submit" name="setpelaku" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="forminput" action="{{route('pengaturan.store')}}" method="POST" class="needs-validation mx-3" novalidate >
                    @csrf
                    <input type="text" name="type" value="4" hidden>
                    <div class="mb-2">
                        <label for="" class="form-label">Masukkan Nama Analisator</label>
                        <div class="row">
                            <div style="width:70%" class="form-group">
                                <select multiple id="multipleAnalisator" name="analisator[]" placeholder="Pilih Nama Analisator" data-search="true" data-silent-initial-value-set="true">
                                    @foreach ($pelaku as $user)
                                    <option value={{$user->userid}}>{{$user->nik}} - {{$user->name}}</option>                                
                                    @endforeach   
                                   
                                </select>
                                <div class="invalid-feedback">
                                    pelaku harus dipilih
                                </div>

                            </div>
                            <div style="width:30%" class="">
                                <button type="submit" name="setanalisator" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>                    
                </form>
            </div>               
        </div>
    </div>   
</div>

<div class="modal fade text-left" id="ModalDeleteCso" tabindex="-1">
    <div class="modal-dialog modal modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mdlMoreLabel">Hapus Data User</h1>
            </div>
            <div class="modal-body">
                <form id="deleteform" action="" method="POST" class="needs-validation mx-3" novalidate>
                    @csrf
                    @method('DELETE')
                    <p id="warning"></p>
                    <button type="submit" class="btn btn-danger" name="simpan"><i
                            class="bx bxs-save"></i>Iya</button>
                    <button type="button" data-bs-dismiss="modal" class="btn btn-primary"
                        name="simpan"><i class="bx bxs-save"></i>Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    VirtualSelect.init({
        ele: '#multipleSelect',
    });
    VirtualSelect.init({
        ele: '#multipleItem',
    });
    VirtualSelect.init({
            ele: '#multiplePelaku'
    });
    VirtualSelect.init({
            ele: '#multipleAnalisator'
    });

    function openModalDelete(button) {
                $('#ModalDeleteCso').modal('show');
                var row = $(button).closest('tr');
                var nama = row.find('td:nth-child(2)').text();
                var id = row.find('td:nth-child(5)').text();
                document.getElementById("warning").innerText = `Apakah anda menghapus ${nama} dari CSO?`;
                $('#deleteform').attr('action', `{{url('admin/penjadwalan/pengaturan/${id}')}}`);
            }
</script>


@endsection