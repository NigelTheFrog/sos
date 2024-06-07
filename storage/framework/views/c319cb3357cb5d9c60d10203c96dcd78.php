<?php $__env->startSection('title','Company'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Company</h1>   
    <div class="row justify-content-md-center">
        <div class="col-7">
            <div class="card mt-2">
                <div class="card-header bg-secondary text-white">
                    <h4 class="card-title pt-2">Daftar Company</h4>
                </div>                   
                <div class="card-body" style="background-color:rgb(248, 248, 248)">
                    <table class="table table-sm table-bordered table-hover table-responsive small" style="background-color:rgb(255, 255, 255)">
                        <thead class="table-dark">
                            <tr class="text-center ">
                                <th class="align-middle" style="width: 2%">No</th>
                                <th class="align-middle" style="width: 5%">Kode Cabang</th>
                                <th class="align-middle" style="width: 20%">Nama Cabang</th>
                                <th class="align-middle" style="width: 8%">Action</th>
                                <th hidden>Company ID</th>
                            </tr>
                        </thead>
                        <tbody>                                
                            <?php $__currentLoopData = $company; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $coy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="text-center">
                                <td class="align-middle"><?php echo e($index +1); ?></td>
                                <td class="align-middle"><?php echo e($coy->coycode); ?></td>
                                <td class="align-middle"><?php echo e($coy->description); ?></td>
                                <td class="align-middle"> 
                                    <button type="button" onclick="openModalEdit(this)" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target=""><i class="bi bi-pencil-square"></i></button>
                                    <button type="button" onclick="openModalDelete(this)" class="btn btn-danger btn-sm" title="Hapus User" id="btnHapus" data-id=""><i class="bi bi-trash-fill"></i></button>
                                </td>
                                <td hidden><?php echo e($coy->coyid); ?></td>
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
                    <h4 class="card-title mx-3 pt-2">Tambah Company</h4>
                </div>
                <div class="card-body" style="background-color:rgb(248, 248, 248)">
                    <form id="forminput" action="<?php echo e(route("company.store")); ?>" method="POST" class="needs-validation mx-3" novalidate >
                        <?php echo csrf_field(); ?> 
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="text" name="coycode" class="form-control" id="coycode" placeholder="Kode Company" required>
                                <div class="invalid-feedback">
                                    Kode company harus diisi
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                                </div>
                                <input type="text" name="deskripsi" class="form-control" id="deskripsi" placeholder="Nama Company" required>
                                <div class="invalid-feedback">
                                    Nama Company
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
<div class="modal fade text-left" id="ModalEditCompany" tabindex="-1">
    <div class="modal-dialog modal modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mdlMoreLabel">Ubah Data Company</h1>
                <button type="button" class="btn-close align-middle" onclick="closeModalEdit(this)" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form id="editform" action="" method="POST" class="needs-validation mx-3" novalidate >
                    <?php echo csrf_field(); ?> 
                    <?php echo method_field('PUT'); ?>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="text" name="coycode" class="form-control" id="editcoycode" placeholder="Company Code" required>
                            <div class="invalid-feedback">
                                Kode Company harus diisi
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                            </div>
                            <input type="text" name="deskripsi" class="form-control" id="editdeskripsi" placeholder="deskripsi" required>
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
<div class="modal fade text-left" id="ModalDeleteCompany" tabindex="-1">
    <div class="modal-dialog modal modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mdlMoreLabel">Hapus Data Company</h1>                
            </div>
            <div class="modal-body">
                <form id="deleteform" action="" method="POST" class="needs-validation mx-3" novalidate >
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
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
        $('#ModalEditCompany').modal('show');
        var row = $(button).closest('tr');
        var coyid = row.find('td:nth-child(5)').text();
        $('#editcoycode').attr('value', row.find('td:nth-child(2)').text());
        $('#editdeskripsi').attr('value', row.find('td:nth-child(3)').text());
        $('#editform').attr('action',`<?php echo e(url('admin/master/company/${coyid}')); ?>`);
    }
    function closeModalEdit(button) {
        $('#ModalEditCompany').modal('hide');
    }
    function openModalDelete(button) {
        $('#ModalDeleteCompany').modal('show');
        var row = $(button).closest('tr');
        var deskripsi = row.find('td:nth-child(3)').text();
        var coyid = row.find('td:nth-child(5)').text();
        document.getElementById("warning").innerText = `Apakah anda akan melanjutkan penghapusan data company ${deskripsi}?`;
        $('#deleteform').attr('action',`<?php echo e(url('admin/master/company/${coyid}')); ?>`);    
    }
    function closeModalDelete(button) {
        $('#ModalDeleteCompany').modal('hide');
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/sos-dev/resources/views/admin/master/company.blade.php ENDPATH**/ ?>