<form method="post" action="<?php echo e(route('import-avalan.store')); ?>">
    <?php echo csrf_field(); ?>
    <div class="container-lg" style="height: 58vh;">
        <?php if($importedAvalan > 0): ?>
            <input type="text" name="type" value="1" hidden>
            <input type="text" name="coy" value="<?php echo e($companyID); ?>" hidden>
            <input type="text" name="filternull" value="<?php echo e($filterViewNull); ?>" hidden>
            <input type="text" name="whs" value="<?php echo e($gudangcode); ?>" hidden>
            <input type="text" name="itemname" value="<?php echo e($itemname); ?>" hidden>
            <div class="ms-4 mb-2">
                <input class="form-check-input" type="checkbox" value="" id="ceksemuaavalan">
                <label for="ceksemuaavalan" class="form-check-label">
                    Centang Semua
                </label>
            </div>
            <div style="overflow: auto; max-height: 56vh;">
                <table class="table table-sm table-hover table-striped table-bordered text-nowrap">
                    <thead class="table-dark">
                        <tr class="text-center ">
                            <th></th>
                            <th scope="col">Nama Item</th>
                            <th scope="col">Product</th>
                            <th scope="col">Sub Product</th>
                            <th scope="col">Batch No</th>
                            <th scope="col">Heat No</th>
                            <th scope="col">Dimension</th>
                            <th scope="col">Tolerance</th>
                            <th scope="col">Condition</th>
                            <th scope="col">Onhand All WRH</th>
                            <th scope="col">UOM</th>
                            <?php $__currentLoopData = $gudang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gdg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th scope="col"><?php echo e($gdg); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </thead>
                    <tbody class="small">
                        <?php $__currentLoopData = $responseavalan['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avalans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $avalans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avalan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" name="checkboxImport[]"
                                                class="form-check-input cekboxsemuaavalan"
                                                value=<?php echo e($avalan['itembatchid']); ?>>
                                        </div>
                                    </td>
                                    <td><?php echo e($avalan['NamaItem']); ?></td>
                                    <td><?php echo e($avalan['Product']); ?></td>
                                    <td><?php echo e($avalan['SubProduct']); ?></td>
                                    <td><?php echo e($avalan['batchno']); ?></td>
                                    <td><?php echo e($avalan['heatNo']); ?></td>
                                    <td><?php echo e($avalan['Dimension']); ?></td>
                                    <td><?php echo e(number_format($avalan['Tolerance'], 2, ',', '.')); ?></td>
                                    <td><?php echo e($avalan['condition']); ?></td>
                                    <td><?php echo e((float) $avalan['Onhand']); ?></td>
                                    <td><?php echo e($avalan['UOM']); ?></td>
                                    <?php $__currentLoopData = $gudang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gdg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td><?php echo e((float) $avalan[$gdg]); ?></td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <hr>
    <?php if($importedAvalan > 0): ?>
        <div class="float-end d-flex" >
            <button type="submit" class="btn btn-primary float-end">Impor</button>
            <button type="button" class="ms-2 btn btn-primary float-end" data-bs-dismiss="modal"
                aria-label="Close">Keluar</button>
        </div>
    <?php endif; ?>
</form>

<script>
    $(document).ready(function() {
        $("#ceksemuaavalan").click(function() {
            if ($(".cekboxsemuaavalan").prop("checked")) {
                $(".cekboxsemuaavalan").prop("checked", false);
            } else {
                $(".cekboxsemuaavalan").prop("checked", true);
            }
        });
    });
</script>
<?php /**PATH /var/www/html/sos-dev/resources/views/admin/penjadwalan/avalan/table-pull-import-avalan.blade.php ENDPATH**/ ?>