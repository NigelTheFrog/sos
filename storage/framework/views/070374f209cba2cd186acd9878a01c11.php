<form method="post" action="<?php echo e(route('konfirmasi-wrh.update',"konfirmasi_wrh")); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <table class="table table-sm table-bordered table-hover table-responsive small table-striped">
        <thead class="table-dark">
            <tr class="text-center ">
                <th class="align-middle" style="width: 5%">No</th>
                <th class="align-middle" style="width: 6%">Username</th>
                <th class="align-middle" style="width: 12%">Nama</th>
                <th class="align-middle" style="width: 15%">Nama Item</th>
                <th class="align-middle" style="width: 7%">Qty Cek Stok</th>
                <th class="align-middle" style="width: 6%">Location</th>
                <th class="align-middle" style="width: 18%">Warna</th>
                <th class="align-middle" style="width: 5%">CSO ke-</th>
                <th class="align-middle" style="width: 7%">Approve</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $datauser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$datauser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="align-middle text-center"><?php echo e($index + 1); ?></td>
                    <td class="align-middle text-center"><?php echo e($datauser->pelakuuname); ?></td>
                    <td class="align-middle text-center"><?php echo e($datauser->name); ?></td>
                    <td class="align-middle text-center"><?php echo e($datauser->itemname); ?></td>
                    <td class="align-middle text-center"><?php echo e($datauser->qty); ?></td>
                    <td class="align-middle text-center"><?php echo e($datauser->locationname); ?></td>
                    <td class="align-middle text-center"><?php echo e($datauser->colordesc); ?></td>
                    <td class="align-middle text-center"><?php echo e($datauser->csocount); ?></td>
                    <td class="align-middle">
                        <?php if($datauser->approval == "Y"): ?>
                        <input type="text" value="1" hidden>
                        <button type="submit" data-id="<?php echo e($datauser->csodetid); ?>" id="approve" class="btn btn-success btn-sm" title="Konfirm">
                            <i class="bi bi-shield-fill-check pr-2"></i>Approved
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" disabled><i class="bi bi-shield-fill pr-2"></i>Reject</button>
                        <?php else: ?>
                        <input type="text" value="2" hidden>
                        <button type="submit" data-id="<?php echo e($datauser->csodetid); ?>" id="approve" class="btn btn-primary btn-sm" title="Konfirm"><i class="bi bi-shield-fill pr-2"></i>Approve</button>
                        <button type="button" class="btn btn-danger btn-sm"><i class="bi bi-shield-fill-check pr-2"></i>Reject</button>
                        <?php endif; ?>
                        
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</form>
<?php /**PATH /var/www/html/sos-dev/resources/views/admin/konfirmasi/tabel-konfirmasi-wrh.blade.php ENDPATH**/ ?>