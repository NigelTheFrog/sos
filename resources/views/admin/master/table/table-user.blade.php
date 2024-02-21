    
    <form method="post" action="{{ route('user.store') }}">
        @csrf
        <div class="container-lg" style="height: 70vh;">
            @if ($importedUser > 0)
                <input type="text" name="type" value="2" hidden>
                <div class="ms-4 mb-3">
                    <input class="form-check-input" type="checkbox" value="" id="ceksemuauser">
                    <label for="ceksemuauser" class="form-check-label">
                        Centang Semua
                    </label>
                </div>
                <div style="overflow: auto; max-height: 66vh;">
                    <table id="tableUser" class="mb-2 table table-sm table-hover table-striped table-bordered text-nowrap">
                        <thead class="table-dark">
                            <tr class="text-center ">
                                <th></th>
                                <th scope="col">Nama</th>
                                <th scope="col">NIK</th>
                                <th scope="col">Username</th>  
                                <th scope="col">User Id</th>                              
                            </tr>
                        </thead>
                        <tbody class="small">
                            @foreach ($importedUser->data as $index => $users)
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" name="checkboxImport[]"
                                                    class="form-check-input cekboxsemuauser"
                                                    value={{ $user->UserID }}>
                                            </div>
                                        </td>
                                        <td>{{ $user->FullName}}</td>
                                        <td>{{ $user->NIK }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->UserID}}</td>                                        
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <hr>
        @if ($importedUser > 0)
            <div class="float-end d-flex" >
                <button type="submit" class="btn btn-primary float-end">Impor</button>
                <button type="button" class="ms-2 btn btn-primary float-end" data-bs-dismiss="modal"
                    aria-label="Close">Keluar</button>
            </div>
        @endisset
    </form>
    
    <script>
        $(function() {
        $("#tableUser").DataTable({
            "responsive": true,
        });
    });
        $(document).ready(function() {
            $("#ceksemuauser").click(function() {
                if ($(".cekboxsemuauser").prop("checked")) {
                    $(".cekboxsemuauser").prop("checked", false);
                } else {
                    $(".cekboxsemuauser").prop("checked", true);
                }
            });
        });
    </script>
