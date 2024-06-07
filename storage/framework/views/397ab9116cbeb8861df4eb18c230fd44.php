<?php $__env->startSection('title', 'User'); ?>

<?php $__env->startSection('content'); ?>
<style>
        .vscomp-toggle-button {
            padding: 10px 30px 10px 10px;
            border-radius: 7px
        }
    </style>
    <div class="container-fluid px-4">
        <h1 class="mt-4">User</h1>
        <div class="row justify-content-md-center">
            <div class="col-7">
                <div class="card mt-2">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="card-title pt-2">Daftar Pengguna</h4>
                    </div>
                    
                    <div id="table-data" class="card-body" style="background-color:rgb(248, 248, 248)"> 
                        <div class="d-flex ">
                            <button type="button" class="btn btn-primary float-start mb-3" data-bs-toggle="modal"
                                data-bs-target="#modalImportUser">
                                <i class="nav-icon fas fa-file-import"></i> Import User
                            </button>
                        </div>                       
                        <table id="datatable" class="table table-sm table-bordered table-hover table-responsive small" style="background-color:rgb(255, 255, 255);overflow: auto; max-height: 160vh;">
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
                                <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="text-center">
                                    <td class="align-middle"><?php echo e($index +1); ?></td>
                                    <td class="align-middle"><?php echo e($user->name); ?></td>
                                    <td class="align-middle"><?php echo e($user->nik); ?></td>
                                    <td class="align-middle"><?php echo e($user->username); ?></td>
                                    <td class="align-middle"><?php echo e($user->levelname); ?></td>                                
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
                                    <td class="align-middle" hidden><?php echo e($user->level); ?></td>
                                    <td class="align-middle" hidden><?php echo e($user->id); ?></td>
                                </tr>                                    
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                
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
                        <form id="forminput" action="<?php echo e(route('user.store')); ?>" method="POST" class="needs-validation mx-3"
                            novalidate>
                            <?php echo csrf_field(); ?>
                            <input type="text" name="type" value="1" hidden>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="width:15%">
                                        <span class="input-group-text w-100 d-flex justify-content-center"><i
                                                class="fas fa-id-card"></i></span>
                                    </div>
                                    <input type="text" pattern="[a-zA-Z\s]+" name="nama" class="form-control"
                                        placeholder="Nama" required>
                                    <div class="invalid-feedback">
                                        Nama harus diisi, tidak boleh ada angka
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="width:15%">
                                        <span class="input-group-text w-100 d-flex justify-content-center"><i
                                                class="far fa-id-card"></i></span>
                                    </div>
                                    <input id="unik" type="text" pattern="[0-9]+" name="nik"
                                        class="form-control" placeholder="NIK" required>
                                    <div class="invalid-feedback">
                                        NIK harus diisi dengan angka
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="width:15%">
                                        <span class="input-group-text w-100 d-flex justify-content-center"><i
                                                class="fa fa-user"></i></span>
                                    </div>
                                    <input id="uname" type="text" pattern="[0-9a-zA-Z]+" name="username"
                                        class="form-control" placeholder="Username" required>
                                    <div class="invalid-feedback">
                                        username harus diisi
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="width:15%">
                                        <span class="input-group-text w-100 d-flex justify-content-center"><i
                                                class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" minlength="4" name="password" class="form-control"
                                        placeholder="Password" required>
                                    <div class="invalid-feedback">
                                        Password harus diisi, minimal 4 digit
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="width:15%">
                                        <span class="input-group-text w-100 d-flex justify-content-center"><i
                                                class="fas fa-signal"></i></span>
                                    </div>
                                    <select class="form-select text-secondary" name="level" aria-label="pilih level"
                                        required>
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
                            <button type="reset" class="btn btn-danger" name="reset"><i class="bx bx-reset"></i>
                                Reset</button>
                            <button type="submit" class="btn btn-primary" name="simpan"><i class="bx bxs-save"></i>
                                Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="ModalEditUser" tabindex="-1">
            <div class="modal-dialog modal modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="mdlMoreLabel">Ubah Data User</h1>
                        <button type="button" class="btn-close align-middle" onclick="closeModalEdit(this)"
                            aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editform" action="" method="POST" class="needs-validation mx-3" novalidate>
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="width:15%">
                                        <span class="input-group-text w-100 d-flex justify-content-center"><i
                                                class="fas fa-id-card"></i></span>
                                    </div>
                                    <input type="text" pattern="[a-zA-Z\s]+" id="formnama" name="nama"
                                        class="form-control" placeholder="Nama" required>
                                    <div class="invalid-feedback">
                                        Nama harus diisi, tidak boleh ada angka
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="width:15%">
                                        <span class="input-group-text w-100 d-flex justify-content-center"><i
                                                class="far fa-id-card"></i></span>
                                    </div>
                                    <input type="text" pattern="[0-9]+" id="formnik" name="nik"
                                        class="form-control" placeholder="NIK" required>
                                    <div class="invalid-feedback">
                                        NIK harus diisi dengan angka
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="width:15%">
                                        <span class="input-group-text w-100 d-flex justify-content-center"><i
                                                class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" pattern="[0-9a-zA-Z]+" id="formusername" name="username"
                                        class="form-control" placeholder="Username" required>
                                    <div class="invalid-feedback">
                                        username harus diisi
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="width:15%">
                                        <span class="input-group-text w-100 d-flex justify-content-center"><i
                                                class="fas fa-signal"></i></span>
                                    </div>

                                    <select id="level-select" class="form-select text-secondary" name="level"
                                        aria-label="pilih level" required>
                                        <option selected value="" disabled id="value-select">Display Level</option>
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
                            <button type="submit" class="btn btn-primary" name="simpan"><i class="bx bxs-save"></i>
                                Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="ModalDeleteUser" tabindex="-1">
            <div class="modal-dialog modal modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="mdlMoreLabel">Hapus Data User</h1>
                    </div>
                    <div class="modal-body">
                        <form id="deleteform" action="" method="POST" class="needs-validation mx-3" novalidate>
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <p id="warning"></p>
                            <button type="submit" class="btn btn-danger" name="simpan"><i
                                    class="bx bxs-save"></i>Iya</button>
                            <button type="button" onclick="closeModalDelete(this)" class="btn btn-primary"
                                name="simpan"><i class="bx bxs-save"></i>Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="modalImportUser" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="mdlMoreLabel">Data User</h1>
                        <button type="button" class="btn-close align-middle" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body"  id="tabelUser">
                        
                        <?php echo $__env->make('admin.master.table.table-user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function openModalEdit(button) {
                $('#ModalEditUser').modal('show');
                var row = $(button).closest('tr');
                var id = row.find('td:nth-child(8)').text();
                document.getElementById("value-select").innerText = row.find('td:nth-child(5)').text();
                $('#formnama').attr('value', row.find('td:nth-child(2)').text());
                $('#formnik').attr('value', row.find('td:nth-child(3)').text());
                $('#formusername').attr('value', row.find('td:nth-child(4)').text());
                $('#value-select').attr('value', row.find('td:nth-child(7)').text());
                $('#editform').attr('action', `<?php echo e(url('admin/master/user/${id}')); ?>`);
            }

            function closeModalEdit(button) {
                $('#ModalEditUser').modal('hide');
            }

            function openModalDelete(button) {
                $('#ModalDeleteUser').modal('show');
                var row = $(button).closest('tr');
                var nama = row.find('td:nth-child(2)').text();
                var username = row.find('td:nth-child(4)').text();
                var id = row.find('td:nth-child(8)').text();
                document.getElementById("warning").innerText = `Apakah anda akan melanjutkan penghapusan data ${nama}?`;
                $('#deleteform').attr('action', `<?php echo e(url('admin/master/user/${id}')); ?>`);
            }

            function closeModalDelete(button) {
                $('#ModalDeleteUser').modal('hide');
            }
           
        </script>


    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/sos-dev/resources/views/admin/master/user.blade.php ENDPATH**/ ?>