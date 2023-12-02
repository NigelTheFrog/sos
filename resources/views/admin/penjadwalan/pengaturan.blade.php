@extends('layouts.master')

@section('title','Pengaturan CSO')

@section('content')
<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>   
</head>



<div class="container-fluid px-4">
    <div class="row justify-content-md-center">
        <div class="col-7">
            <div class="card mt-2">
                <div class="card-header bg-secondary text-white">
                    <h4 class="card-title pt-2">Pengaturan CSO</h4>
                </div>                   
                <div class="card-body" style="background-color:rgb(248, 248, 248)">
                    <p>Item yang di CSO :<strong> 
                        CSO                                             
                    </strong></p>                    
                    <p>Item yang di CSO :<strong>                         
                        Plat, As                                             
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
                <h4 class="card-title mx-3 pt-2">Atur Rencana CSO</h4>
            </div>
            <div class="card-body" style="background-color:rgb(248, 248, 248)">
                <form id="forminput" action="add-user.php" method="POST" class="needs-validation mx-3" novalidate >
                    <div class="mb-2">
                        <label for="" class="form-label">Tipe Cek Stok</label>
                        <div class="row">
                            <div style="width:70%" class="form-group">
                                <select id="multipleSelect" class="form-control" name="typestock" placeholder="Tipe Cek Stok" data-search="true" data-silent-initial-value-set="true">
                                    <option value="CSO">CSO</option>
                                    <option value="CSS">CSS</option>
                                </select>
                            </div>
                            <div style="width:30%" class="">
                                <button type="submit" name="submitTypeStock" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="" class="form-label">Item yang di CSO</label>
                        <div class="row">
                            <div style="width:70%" class="form-group">
                                <select class="form-control select2-multiple" multiple id="select2MultipleItem" name="pelaku[]" placeholder="Pilih Nama Checker" data-search="true" data-silent-initial-value-set="true">
                                    @foreach ($category as $cat)
                                    <option value="{{$cat->categorydesc}}">{{$cat->categorydesc}}</option>                                
                                    @endforeach                                        
                                </select>
                            </div>
                            <div style="width:30%" class="">
                                <button type="submit" name="setmaterial" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="" class="form-label">Masukkan Nama Pelaku</label>
                        <div class="row">
                            <div style="width:70%" class="form-group">
                                <select class="form-control select2-multiple" multiple id="select2MultiplePelaku" name="pelaku[]" placeholder="Pilih Nama Checker" data-search="true" data-silent-initial-value-set="true">
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

                    <div class="mb-2">
                        <label for="" class="form-label">Masukkan Nama Analisator</label>
                        <div class="row">
                            <div style="width:70%" class="form-group">
                                <select class="form-control select2-multiple" multiple id="multipleSelectAnalisator" name="analisator[]" placeholder="Pilih Nama Analisator" data-search="true" data-silent-initial-value-set="true">
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
                    <button type="reset" class="btn btn-danger" name="reset"><i class="bx bx-reset"></i> Reset</button>
                    <button type="submit" class="btn btn-primary" name="simpan"><i class="bx bxs-save"></i> Simpan</button>
                </form>
            </div>               
        </div>
    </div>   
</div>


@endsection