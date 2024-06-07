<?php if($type == 1): ?>

<table class="table table-sm table-bordered table-hover table-responsive small table-striped">
    <thead class="table-dark">
        <tr class="text-center ">
            <th class="align-middle" style="width: 33%">Nama Item</th>
            <th class="align-middle" style="width: 7%">Dimension</th>
            <th class="align-middle" style="width: 7%">Tolerance</th>
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
        <?php $__currentLoopData = $itemBlmProses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($barang->itemname); ?></td>
                <td class="text-center"><?php echo e($barang->dimension); ?></td>
                <td class="text-center"><?php echo e($barang->tolerance); ?></td>
                <td class="text-center"><?php echo e($barang->selisih); ?></td>
                <td class="text-center"><?php echo e($barang->onhand); ?></td>
                <td class="text-center"><?php echo e($barang->totalcso); ?></td>
                <td class="text-center"><?php echo e($barang->koreksi); ?></td>
                <td class="text-center"><?php echo e($barang->deviasi); ?></td>
                <td class="text-center"><?php echo e($barang->statuscso); ?></td>
                <td class="text-center"><?php echo e($barang->groupid); ?></td>
                <td class="text-center"><?php echo e($barang->analisator); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<?php elseif($type == 2): ?>
<table class="table table-sm table-bordered table-hover table-responsive small table-striped">
    <thead class="table-dark">
        <tr class="text-center ">
            <th class="align-middle" style="width: 33%">Nama Item</th>
            <th class="align-middle" style="width: 7%">Dimension</th>
            <th class="align-middle" style="width: 7%">Tolerance</th>
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
        <?php $__currentLoopData = $itemSdgProses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($barang->itemname); ?></td>
                <td class="text-center"><?php echo e($barang->dimension); ?></td>
                <td class="text-center"><?php echo e($barang->tolerance); ?></td>
                <td class="text-center"><?php echo e($barang->selisih); ?></td>
                <td class="text-center"><?php echo e($barang->onhand); ?></td>
                <td class="text-center"><?php echo e($barang->totalcso); ?></td>
                <td class="text-center"><?php echo e($barang->koreksi); ?></td>
                <td class="text-center"><?php echo e($barang->deviasi); ?></td>
                <td class="text-center"><?php echo e($barang->statuscso); ?></td>
                <td class="text-center"><?php echo e($barang->groupid); ?></td>
                <td class="text-center"><?php echo e($barang->analisator); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<?php elseif($type == 3): ?>
<table class="table table-sm table-bordered table-hover table-responsive small table-striped">
    <thead class="table-dark">
        <tr class="text-center ">
            <th class="align-middle" style="width: 33%">Nama Item</th>
            <th class="align-middle" style="width: 7%">Dimension</th>
            <th class="align-middle" style="width: 7%">Tolerance</th>
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
        <?php $__currentLoopData = $itemSelesai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($barang->itemname); ?></td>
                <td class="text-center"><?php echo e($barang->dimension); ?></td>
                <td class="text-center"><?php echo e($barang->tolerance); ?></td>
                <td class="text-center"><?php echo e($barang->selisih); ?></td>
                <td class="text-center"><?php echo e($barang->onhand); ?></td>
                <td class="text-center"><?php echo e($barang->totalcso); ?></td>
                <td class="text-center"><?php echo e($barang->koreksi); ?></td>
                <td class="text-center"><?php echo e($barang->deviasi); ?></td>
                <td class="text-center"><?php echo e($barang->statuscso); ?></td>
                <td class="text-center"><?php echo e($barang->groupid); ?></td>
                <td class="text-center"><?php echo e($barang->analisator); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<?php else: ?>
<div>
    <h4 class="modal-title fs-5"> Item Selisih Plus</h4>
    <table class="table table-sm table-bordered table-hover table-responsive small table-striped">
        <thead class="table-dark">
            <tr class="text-center ">
                <th class="align-middle" style="width: 33%">Nama Item</th>
                <th class="align-middle" style="width: 7%">Dimension</th>
                <th class="align-middle" style="width: 7%">Tolerance</th>
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
            <?php $__currentLoopData = $itemSelisihPlus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($barang->itemname); ?></td>
                    <td class="text-center"><?php echo e($barang->dimension); ?></td>
                    <td class="text-center"><?php echo e($barang->tolerance); ?></td>
                    <td class="text-center"><?php echo e($barang->selisih); ?></td>
                    <td class="text-center"><?php echo e($barang->onhand); ?></td>
                    <td class="text-center"><?php echo e($barang->totalcso); ?></td>
                    <td class="text-center"><?php echo e($barang->koreksi); ?></td>
                    <td class="text-center"><?php echo e($barang->deviasi); ?></td>
                    <td class="text-center"><?php echo e($barang->statuscso); ?></td>
                    <td class="text-center"><?php echo e($barang->groupid); ?></td>
                    <td class="text-center"><?php echo e($barang->analisator); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div class="pt-2">
    <h4 class="modal-title fs-5"> Item Selisih Minus</h4>
    <table class="table table-sm table-bordered table-hover table-responsive small table-striped">
        <thead class="table-dark">
            <tr class="text-center ">
                <th class="align-middle" style="width: 33%">Nama Item</th>
                <th class="align-middle" style="width: 7%">Dimension</th>
                <th class="align-middle" style="width: 7%">Tolerance</th>
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
            <?php $__currentLoopData = $itemSelisihMinus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($barang->itemname); ?></td>
                    <td class="text-center"><?php echo e($barang->dimension); ?></td>
                    <td class="text-center"><?php echo e($barang->tolerance); ?></td>
                    <td class="text-center"><?php echo e($barang->selisih); ?></td>
                    <td class="text-center"><?php echo e($barang->onhand); ?></td>
                    <td class="text-center"><?php echo e($barang->totalcso); ?></td>
                    <td class="text-center"><?php echo e($barang->koreksi); ?></td>
                    <td class="text-center"><?php echo e($barang->deviasi); ?></td>
                    <td class="text-center"><?php echo e($barang->statuscso); ?></td>
                    <td class="text-center"><?php echo e($barang->groupid); ?></td>
                    <td class="text-center"><?php echo e($barang->analisator); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<?php endif; ?><?php /**PATH /var/www/html/sos-dev/resources/views/admin/dashboard/table/item/banner-table-item.blade.php ENDPATH**/ ?>