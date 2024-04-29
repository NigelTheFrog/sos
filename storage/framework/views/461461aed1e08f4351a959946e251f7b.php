<form method="post" action="<?php echo e(route('import-stok.store')); ?>">
    <?php echo csrf_field(); ?>
    <div class="container-lg" style="height: 60vh">
        <?php if($importedBatch > 0): ?>
            <div class="ms-4 mb-2">
                <input class="form-check-input" type="checkbox" value="" id="ceksemuabatch">
                <label for="ceksemuabatch" class="form-check-label">
                    Centang Semua
                </label>
            </div>
            <input type="text" name="type" value="2" hidden>
            <input type="text" name="coy" value="<?php echo e($companyID); ?>" hidden>
            <input type="text" name="filternull" value="<?php echo e($filterViewNull); ?>" hidden>
            <input type="text" name="whs" value="<?php echo e($gudangcode); ?>" hidden>
            <input type="text" name="itemname" value="<?php echo e($itemname); ?>" hidden>
            <div style="overflow: auto; max-height: 56vh;">
                <table class="table table-sm table-hover table-striped table-bordered text-nowrap">
                    <thead class="table-dark">
                        <tr class="text-center ">
                            <th></th>
                            <th scope="col">Batch Item</th>
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
                        <?php $__currentLoopData = $responsebatch['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $batches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" name="checkboxImport[]"
                                                class="form-check-input cekboxsemuabatch"
                                                value=<?php echo e($batch['itembatchid']); ?>>
                                        </div>
                                    </td>
                                    <td><?php echo e($batch['itembatchid']); ?></td>
                                    <td><?php echo e($batch['NamaItem']); ?></td>
                                    <td><?php echo e($batch['Product']); ?></td>
                                    <td><?php echo e($batch['SubProduct']); ?></td>
                                    <td><?php echo e($batch['BatchNo']); ?></td>
                                    <td><?php echo e($batch['HeatNo']); ?></td>
                                    <td><?php echo e($batch['Dimension']); ?></td>
                                    <td><?php echo e((string) $batch['Tolerance']); ?></td>
                                    <td><?php echo e($batch['condition']); ?></td>
                                    <td><?php echo e($batch['Onhand']); ?></td>
                                    <td><?php echo e($batch['UOM']); ?></td>
                                    <?php $__currentLoopData = $gudang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gdg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td><?php echo e((float) $batch[$gdg]); ?></td>
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
    <?php if($importedBatch > 0): ?>
    <div class="float-end d-flex" >
        <button type="submit" class="btn btn-primary float-end">Impor</button>
        <button type="button" class="ms-2 btn btn-primary float-end" data-bs-dismiss="modal"
            aria-label="Close">Keluar</button>
    </div>
    <?php endif; ?>
</form>

<script>
    $(document).ready(function() {
        $("#ceksemuabatch").click(function() {
            if ($(".cekboxsemuabatch").prop("checked")) {
                $(".cekboxsemuabatch").prop("checked", false);
            } else {
                $(".cekboxsemuabatch").prop("checked", true);
            }
        });
    });
</script>
<?php /**PATH /var/www/html/sos-dev/resources/views/admin/penjadwalan/item/table-pull-import-batch.blade.php ENDPATH**/ ?>