<?php $__env->startSection('title','Kategori Produk'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Kategori</h1>   
    <div class="row justify-content-md-center">
        <div class="col-7">
            <div class="card mt-2">
                <div class="card-header bg-secondary text-white">
                    <h4 class="card-title pt-2">Master Kategori</h4>
                </div>                   
                <div class="card-body" style="background-color:rgb(248, 248, 248)">
                    <table class="table table-sm table-bordered table-hover table-responsive small" style="background-color:rgb(255, 255, 255)">
                        <thead class="table-dark">
                            <tr class="text-center ">
                                <th class="align-middle" style="width: 2%">No</th>
                                <th class="align-middle" style="width: 5%">Kategori</th>
                                <th class="align-middle" style="width: 8%">Action</th>
                                <th hidden></th>
                            </tr>
                        </thead>
                        <tbody>                                
                            <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="text-center">
                                <td class="align-middle"><?php echo e($index +1); ?></td>
                                <td class="align-middle"><?php echo e($kat->categorydesc); ?></td>
                                <td class="align-middle"> 
                                    <button type="button" onclick="openModalEdit(this)" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target=""><i class="bi bi-pencil-square"></i></button>
                                    <button type="button" onclick="openModalDelete(this)" class="btn btn-danger btn-sm" title="Hapus User" id="btnHapus" data-id=""><i class="bi bi-trash-fill"></i></button>
                                </td>
                                <td hidden><?php echo e($kat->categoryid); ?></td>
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
                    <h4 class="card-title mx-3 pt-2">Tambah Kategori</h4>
                </div>
                <div class="card-body" style="background-color:rgb(248, 248, 248)">
                    <form id="forminput" action="<?php echo e(route("kategori-produk.store")); ?>" method="POST" class="needs-validation mx-3" novalidate >
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="text" name="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi Kategori" required>
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
<div class="modal fade text-left" id="ModalEditKategori" tabindex="-1">
    <div class="modal-dialog modal modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mdlMoreLabel">Ubah Data Kategori</h1>
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
<div class="modal fade text-left" id="ModalDeleteKategori" tabindex="-1">
    <div class="modal-dialog modal modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mdlMoreLabel">Hapus Data Kategori</h1>                
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
        $('#ModalEditKategori').modal('show');
        var row = $(button).closest('tr');
        var kategoriid = row.find('td:nth-child(4)').text();
        $('#editdeskripsi').attr('value', row.find('td:nth-child(2)').text());
        $('#editform').attr('action',`<?php echo e(url('admin/master/kategori-produk/${kategoriid}')); ?>`);
    }
    function closeModalEdit(button) {
        $('#ModalEditKategori').modal('hide');
    }
    function openModalDelete(button) {
        $('#ModalDeleteKategori').modal('show');
        var row = $(button).closest('tr');
        var deskripsi = row.find('td:nth-child(2)').text();
        var kategoriid = row.find('td:nth-child(4)').text();
        document.getElementById("warning").innerText = `Apakah anda akan melanjutkan penghapusan data keputusan ${deskripsi}?`;
        $('#deleteform').attr('action',`<?php echo e(url('admin/master/kategori-produk/${kategoriid}')); ?>`);    
    }
    function closeModalDelete(button) {
        $('#ModalDeleteKategori').modal('hide');
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/sos-dev/resources/views/admin/master/kategori-produk.blade.php ENDPATH**/ ?>