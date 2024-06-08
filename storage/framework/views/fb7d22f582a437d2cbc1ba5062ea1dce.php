<form method="post" action="<?php echo e(route('import-stok.store')); ?>">
    <?php echo csrf_field(); ?>
    <div class="container-lg" style="height: 60vh">
        <?php if($importedItem > 0): ?>
            <div class="ms-4 mb-2">
                <input class="form-check-input" type="checkbox" value="" id="ceksemuaitem">
                <label for="ceksemuaitem" class="form-check-label">
                    Centang Semua
                </label>
            </div>
            <input type="text" name="type" value="1" hidden>
            <input type="text" name="coy" value="<?php echo e($companyID); ?>" hidden>
            <input type="text" name="filternull" value="<?php echo e($filterViewNull); ?>" hidden>
            <input type="text" name="whs" value="<?php echo e($gudangcode); ?>" hidden>
            <input type="text" name="itemname" value="<?php echo e($itemname); ?>" hidden>
            <div style="overflow: auto; max-height: 56vh;">
                <table class="table table-sm table-hover table-striped table-bordered text-nowrap">
                    <thead class="table-dark">
                        <tr class="text-center ">
                            <th></th>
                            <th scope="col">Nama Item</th>
                            <th scope="col">Product</th>
                            <th scope="col">Sub Product</th>
                            <th scope="col">Onhand All WRH</th>
                            <th scope="col">UOM</th>
                            <?php $__currentLoopData = $gudang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gdg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th scope="col"><?php echo e($gdg); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </thead>
                    <tbody class="small">
                        <?php $__currentLoopData = $responseitem['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" name="checkboxImport[]"
                                                class="form-check-input checkboxsemuaitem" value=<?php echo e($item['ITEMID']); ?>>
                                        </div>
                                    </td>
                                    <td><?php echo e($item['NamaItem']); ?></td>
                                    <td><?php echo e($item['Product']); ?></td>
                                    <td><?php echo e($item['SubProduct']); ?></td>
                                    <td><?php echo e($item['Onhand']); ?></td>
                                    <td><?php echo e($item['UOM']); ?></td>
                                    <?php $__currentLoopData = $gudang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gdg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td><?php echo e((int) $item[$gdg]); ?></td>
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
    <?php if($importedItem > 0): ?>
    <div class="float-end d-flex" >
        <button type="submit" class="btn btn-primary float-end" id="buttonImpor" >Impor</button>
        <button type="button" class="ms-2 btn btn-primary float-end" data-bs-dismiss="modal"
            aria-label="Close" id="buttonKeluar">Keluar</button>
    </div>
    <?php endif; ?>
</form>

<script>
    $(document).ready(function() {
        $("#ceksemuaitem").click(function() {
            if ($(".checkboxsemuaitem").prop("checked")) {
                $(".checkboxsemuaitem").prop("checked", false);
            } else {
                $(".checkboxsemuaitem").prop("checked", true);
            }
        });
    });

    function clickImpor(button) {
        var buttonImpor = document.getElementById("buttonImpor");
        var buttonKeluar = document.getElementById("buttonKeluar");
        buttonImpor.disabled = true;
        buttonKeluar.disabled = true;
    }
</script>
<?php /**PATH /var/www/html/sos-dev/resources/views/admin/penjadwalan/item/table-pull-import.blade.php ENDPATH**/ ?>