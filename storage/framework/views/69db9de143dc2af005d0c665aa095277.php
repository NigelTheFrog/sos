<table class="table table-sm table-bordered table-hover table-responsive small">
    <thead class="table-dark">
        <tr class="text-center ">
            <th class="align-middle" style="width: 28%">Nama Item</th>
            <th class="align-middle" style="width: 7%">Dimension</th>
            <th class="align-middle" style="width: 7%">Tolerance</th>
            <th class="align-middle" style="width: 10%">Status</th>
            <th class="align-middle" style="width: 5%">Selisih</th>
            <th class="align-middle" style="width: 5%">Onhand</th>
            <th class="align-middle" style="width: 5%">Total CSO</th>
            <th class="align-middle" style="width: 5%">Koreksi</th>
            <th class="align-middle" style="width: 5%">Deviasi</th>
            <th class="align-middle" style="width: 5%">Status CSO</th>
            <th class="align-middle" style="width: 5%">Grouping</th>
            <th class="align-middle" style="width: 18%">Analisator</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $avalan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr
                <?php if($barang->selisih != 0): ?> class="table-danger"
        <?php else: ?>
            class = "table-light" <?php endif; ?>>
                <td hidden>
                    <?php echo e($barang->itembatchid); ?>

                </td>
                <td hidden>
                    <?php echo e($barang->batchno); ?>

                </td>
                <td hidden>
                    <?php echo e($barang->itemname); ?>

                </td>
                <td class="align-middle">
                    <div class="d-flex my-0 align-items-center">
                        <div class="mr-3">
                            <button type="button" class="btn btn-sm" id="detailcsoitem"
                                onclick="openModalDetailCSOAvalan(this)" style="color: rgb(81, 81, 81)"
                                id="viewlistcso"><i class="fas fa-eye"></i></button>
                        </div>
                        <div><?php echo e($barang->itemname); ?> - <?php echo e($barang->batchno); ?></div>
                    </div>
                </td>
                <td class="align-middle text-center"><?php echo e($barang->dimension); ?></td>
                <td class="align-middle text-center"><?php echo e($barang->tolerance); ?></td>
                <td class="align-middle text-center">
                    <?php if($barang->status == 1): ?>
                        <span class='badge  rounded-pill text-bg-danger text-wrap' style='width: 5rem'>selisih -
                        <?php elseif($barang->status == 2): ?>
                            <span class='badge  rounded-pill text-bg-danger text-wrap' style='width: 5rem'>selisih +
                            <?php elseif($barang->status == 3): ?>
                                <span class='badge rounded-pill text-bg-success text-wrap' style='width: 5rem'>selesai
                                <?php else: ?>
                                    <span class='badge rounded-pill text-bg-warning text-wrap' style='width: 5rem'>belum
                                        proses
                    <?php endif; ?>
                    </span>
                </td>
                <td class="align-middle text-center"><?php echo e(number_format($barang->selisih, 2, ',', '.')); ?></td>
                <td class="align-middle text-center"><?php echo e(number_format($barang->onhand, 2, ',', '.')); ?></td>
                <td class="align-middle text-center"><?php echo e(number_format($barang->totalcso, 2, ',', '.')); ?></td>
                <td class="align-middle text-center"><?php echo e($barang->koreksi); ?></td>
                <td class="align-middle text-center"><?php echo e($barang->deviasi); ?></td>
                <td class="align-middle text-center"><?php echo e($barang->statuscso); ?></td>
                <td class="align-middle text-center"><?php echo e($barang->groupid); ?></td>
                <td class="align-middle text-center"><?php echo e($barang->analisator); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH /var/www/html/sos-dev/resources/views/admin/dashboard/table/avalan/main-table-avalan.blade.php ENDPATH**/ ?>