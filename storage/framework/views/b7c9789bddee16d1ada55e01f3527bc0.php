<?php $__env->startSection('title', 'Cek Stok'); ?>

<?php $__env->startSection('content'); ?>

    <div class="content-wrapper mt-3">
        <!-- Main content -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="">
                        <div class="card card-secondary">
                            <div class="card-header bg-secondary text-white">
                                <h3 class="card-title"> Laporan CSO Avalan</h3>
                            </div>
                            <div class="card-body" style="background-color: #f8f8f8;">

                                <div class="list-group">
                                    <button class="list-group-item list-group-item-action"
                                        style="border-bottom: 1px solid #d2d2d2;" data-bs-toggle="modal"
                                        data-bs-target="#modalLaporanResume">
                                        <div class="d-flex w-100 justify-content-between">
                                            <div class="fw-bold">Laporan Resume Hasil Pelaksanaan Cek Stok</div>
                                        </div>
                                        <small>Keterangan</small>
                                    </button>
                                    <button class="list-group-item list-group-item-action"
                                        style="border-top: 1px solid #d2d2d2;" data-bs-toggle="modal"
                                        data-bs-target="#modalLaporanCSO">
                                        <div class="d-flex w-100 justify-content-between">
                                            <div class="fw-bold">Laporan CSO SRM All Material Pipa Industri, Siku, Strep
                                            </div>
                                        </div>
                                        <small>Keterangan</small>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
    <div class="modal fade text-left" id="modalLaporanResume" tabindex="-1">
        <div class="modal-dialog modal modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="<?php echo e(route('cek-stok-avalan.update','cek_stok_avalan')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="text" name="type" value="1" hidden>
                    <div class="modal-header bg-secondary text-white">
                        <h1 class="modal-title fs-5" id="mdlMoreLabel">Laporan Hasil Pelaksanaan Cek Stok</h1>
                        <button type="button" class="btn-close btn-close-white align-middle"
                            onclick="closeLaporanResume(this)" aria-label="Close">
                    </div>
                    <div class="modal-body">
                        <div class="form-group row col">
                            <label class="col=sm-e col-form-label">Nomor Dokumen </label>
                                <select style="width: 100%" id="select-resume" name="trsidresume" placeholder="Daftar CSO">
                                    <?php $__currentLoopData = $listNodoc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nodoc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($nodoc->trsid); ?>"><?php echo e($nodoc->doccsoid); ?> -
                                            <?php echo e($nodoc->csomaterial); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary text-white">Preview</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="modalLaporanCSO" tabindex="-1">
        <div class="modal-dialog modal modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h1 class="modal-title fs-6" id="mdlMoreLabel">Laporan CSO SRM All Material Pipa Industri, Siku, Strep
                    </h1>
                    <button type="button" class="btn-close btn-close-white align-middle" onclick="closeLaporanCSO(this)"
                        aria-label="Close">
                    </button>
                </div>
                <form action="<?php echo e(route('cek-stok-avalan.update','cek_stok_avalan')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="text" name="type" value="2" hidden>
                    <div class="modal-body">
                        <div class="form-group row col">
                            <label class="col=sm-e col-form-label">Nomor Dokumen </label>
                                <select style="width: 100%" id="select-resume" name="trsidlaporan" placeholder="Daftar CSO">
                                    <?php $__currentLoopData = $listNodoc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nodoc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($nodoc->trsid); ?>"><?php echo e($nodoc->doccsoid); ?> -
                                            <?php echo e($nodoc->csomaterial); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary text-white">Preview</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>

document.getElementById("select-resume").selectedIndex = -1;
    
    VirtualSelect.init({
    search: true,
    ele: '#select-resume',
    silentInitialValueSet: false,
    maxWidth: '93%',
    noSearchResultsText: "CSO Tidak ditemukan"
    });

document.getElementById("select-laporan").selectedIndex = -1;

    VirtualSelect.init({
    search: true,
    ele: '#select-laporan',
    silentInitialValueSet: false,
    maxWidth: '92%',
    noSearchResultsText: "CSO Tidak ditemukan"
    });
        function closeLaporanCSO(button) {
            $('#modalLaporanCSO').modal('hide');
        }

        function closeLaporanResume(button) {
            $('#modalLaporanResume').modal('hide');
        }

        function printLaporanResume(button) {
            const trsid = document.getElementById('trsidresume');
            window.location.href = `<?php echo e(url('admin/report/cek-stok/${trsid.value}')); ?>`;
        }

        function printLaporanCsoClik(button) {
            const trsid = document.getElementById('trsidlaporan');
            window.location.href = `<?php echo e(url('admin/report/cek-stok/${trsid.value}')); ?>`;
        }
    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/sos-dev/resources/views/admin/report/cek-stok-avalan.blade.php ENDPATH**/ ?>