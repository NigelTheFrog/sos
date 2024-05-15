<?php $__env->startSection('title', 'Susunan Tim CSO Avalan'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <!-- Main content -->
            <div class="container-fluid mt-3">
                <div class="d-flex justify-content-between mb-3">
                    <div class="px-3">
                        <h5>Report Resume CSO</h5>
                    </div>
                </div>
                <form action="<?php echo e(route('susunan-tim-cso-avalan.store')); ?>" class="mb-3" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="text" name="type" value="1" hidden>
                    <div class="card card-secondary">
                        <div class="card-header bg-secondary text-white">
                            <h3 class="card-title">Analisator CSO</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover mb-3">
                                <thead>
                                    <tr>
                                        <th hidden></th>
                                        <th scope="col">No</th>
                                        <th>Nama Analisator</th>
                                        <th>Departemen</th>
                                        <th>Catatan tentang Analisator</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $analisator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $analisator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td hidden><input type="text" name="jobidAnalisator[]"
                                                value="<?php echo e($analisator->jobid); ?>"></td>
                                        <td><?php echo e($index + 1); ?></td>
                                        <td><?php echo e($analisator->name); ?></td>


                                        <td><select name="deptAnalisator[]" id="">
                                                <option value="<?php echo e($analisator->dept); ?>" selected>
                                                    <?php if($analisator->dept != null || $analisator->dept != ''): ?>
                                                        <?php echo e($analisator->dept); ?>

                                                    <?php else: ?>
                                                        Pilih Departemen
                                                    <?php endif; ?>
                                                </option>
                                                <option value="PUR">PUR</option>
                                                <option value="SAL">SAL</option>
                                                <option value="FAC">FAC</option>
                                                <option value="ITE">ITE</option>
                                                <option value="GAF">GAF</option>
                                            </select></td>
                                        <td><input type="text" value="<?php echo e($analisator->note); ?>" name="ketAnalisator[]"
                                                class="form-control"></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <button type="submit" name="simpan-analisator" class="btn btn-primary"><i
                                    class="fas fa-save pe-2"></i>save</button>
                        </div>
                    </div>
                </form>

                <form action="<?php echo e(route('susunan-tim-cso-avalan.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="text" name="type" value="2" hidden>
                    <div class="card card-secondary">
                        <div class="card-header bg-secondary text-white ">
                            <h3 class="card-title ">Pelaku CSO</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover mb-3">
                                <thead>
                                    <tr>
                                        <th hidden></th>
                                        <th scope="col">No</th>
                                        <th>Nama Pelaku</th>
                                        <th>Departemen</th>
                                        <th>Catatan tentang Pelaku</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $pelaku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pelaku): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td hidden><input type="text" name="jobidPelaku[]"
                                                    value="<?php echo e($pelaku->jobid); ?>"></td>
                                            <td><?php echo e($index + 1); ?></th>
                                            <td><?php echo e($pelaku->name); ?></td>
                                            <td><select name="deptPelaku[]" id="">
                                                    <option value="<?php echo e($pelaku->dept); ?>" selected>
                                                        <?php if($pelaku->dept != null || $pelaku->dept != ''): ?>
                                                            <?php echo e($pelaku->dept); ?>

                                                        <?php else: ?>
                                                            Pilih Departemen
                                                        <?php endif; ?>
                                                    </option>
                                                    <option value="PUR">PUR</option>
                                                    <option value="SAL">SAL</option>
                                                    <option value="FAC">FAC</option>
                                                    <option value="ITE">ITE</option>
                                                    <option value="GAF">GAF</option>
                                                </select></td>
                                            <td><input type="text" value="<?php echo e($pelaku->note); ?>" name="ketPelaku[]"
                                                    class="form-control"></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                            <button type="submit" name="simpan-pelaku" class="btn btn-primary"><i
                                    class="fas fa-save pe-2"></i>save</button>
                        </div>
                    </div>
                </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/sos-dev/resources/views/admin/resume/susunan-tim-cso-avalan.blade.php ENDPATH**/ ?>