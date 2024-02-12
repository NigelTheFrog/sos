    <table id="datatable" class="table table-sm table-bordered table-hover table-responsive small" style="background-color:rgb(255, 255, 255)">
        <thead class="table-dark">
            <tr class="text-center ">
                <th class="align-middle" style="width: 2%">No</th>
                <th class="align-middle" style="width: 15%">Nama</th>
                <th class="align-middle" style="width: 7%">NIK</th>
                <th class="align-middle" style="width: 10%">Username</th>
                <th class="align-middle" style="width: 7%">Level</th>
                <th class="align-middle" style="width: 8%">Action</th>
                <th class="align-middle" style="width: 0%" hidden></th>
                <th class="align-middle" style="width: 0%" hidden></th>
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
                    <div class="row">
                        <div class="col-2 ms-2">
                            <button onclick="openModalEdit(this)" class="btn btn-sm btn-primary edit" id="btnEditUser" ><i class="bi bi-pencil-square", style="color: white"></i></button>
                        </div>
                        <div class="col-2 ms-2">
                            <button onclick="openModalDelete(this)" class="btn btn-danger btn-sm" title="Hapus User" id="btnHapus" data-id=""><i class="bi bi-trash-fill"></i></button>
                        </div>
                    </div>

                </td>
                <td class="align-middle" hidden>{{$user->level}}</td>
                <td class="align-middle" hidden>{{$user->id}}</td>
            </tr>                                    
            @endforeach                                
        </tbody>
    </table>                
