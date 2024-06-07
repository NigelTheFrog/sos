<title>
    <?php if($type == 1): ?>
        Item Belum Proses
    <?php elseif($type == 2): ?>
        Item Sedang Proses
    <?php elseif($type == 3): ?>
        Item Selesai
    <?php else: ?>
        Item Selisih
    <?php endif; ?>
</title>
<style>
    th {
        text-align: center;
        color: white;
        height: 45px;
        font-size: 9.5pt;
        border: 1px solid;
        border-color: rgb(65, 65, 65);
        padding-left: 2px;
        padding-right: 2px;
    }

    .tr-head {
        background-color: #1c1c1c;
    }

    td {
        font-size: 9pt;
        border: 1px solid;
        border-color: rgb(192, 192, 192);
        padding-left: 3px;
        padding-right: 3px;
        vertical-align: middle;
    }

    .td-non-itemname {
        text-align: center;
    }

    .tr-body:nth-child(odd) {
        background-color: rgb(233, 233, 233)
    }

    .tr-body:nth-child(even) {
        background-color: rgb(247, 247, 247)
    }


    table {
        width: 100%;
        border-collapse: collapse;
        line-height: 3;
        font-family: Arial, sans-serif;
    }

    h2 {
        font-family: Arial, sans-serif;
        text-align: center;
    }
</style>

<?php if($type != 4): ?>
    <h2>
        <?php if($type == 1): ?>
            Item Yang Belum Dicek
        <?php elseif($type == 2): ?>
            Item Yang Sedang Dicek
        <?php else: ?>
            Item Yang Sudah Dicek
        <?php endif; ?>
    </h2>
    <table>
        <thead>
            <tr class="tr-head">
                <th style="width: 25%">Nama Item</th>
                <th style="width: 10%">Heat No</th>
                <th style="width: 10%">Dimension</th>
                <th style="width: 10%">Tolerance</th>
                <th style="width: 15%">Condition</th>
            </tr>
        </thead>
        <tbody>
            <?php if($type == 1): ?>
                <?php $__currentLoopData = $itemBlmProses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="tr-body">
                        <td><?php echo e($barang->itemname); ?></td>
                        <td class="td-non-itemname"><?php echo e($barang->heatno); ?></td>
                        <td class="td-non-itemname"><?php echo e($barang->dimension); ?></td>
                        <td class="td-non-itemname"><?php echo e($barang->tolerance); ?></td>
                        <td class="td-non-itemname"><?php echo e($barang->kondisi); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php elseif($type == 2): ?>
                <?php $__currentLoopData = $itemSdgProses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="tr-body">
                        <td><?php echo e($barang->itemname); ?></td>
                        <td class="td-non-itemname"><?php echo e($barang->heatno); ?></td>
                        <td class="td-non-itemname"><?php echo e($barang->dimension); ?></td>
                        <td class="td-non-itemname"><?php echo e($barang->tolerance); ?></td>
                        <td class="td-non-itemname"><?php echo e($barang->kondisi); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <?php $__currentLoopData = $itemSelesai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="tr-body">
                        <td><?php echo e($barang->itemname); ?></td>
                        <td class="td-non-itemname"><?php echo e($barang->heatno); ?></td>
                        <td class="td-non-itemname"><?php echo e($barang->dimension); ?></td>
                        <td class="td-non-itemname"><?php echo e($barang->tolerance); ?></td>
                        <td class="td-non-itemname"><?php echo e($barang->kondisi); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php else: ?>
    <h2>
        Item Selisih Plus

    </h2>
    <table>
        <thead>
            <tr class="tr-head">
                <th style="width: 25%">Nama Item</th>
                <th style="width: 10%">Heat No</th>
                <th style="width: 10%">Dimension</th>
                <th style="width: 10%">Tolerance</th>
                <th style="width: 15%">Condition</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $itemSelisihPlus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="tr-body">
                    <td><?php echo e($barang->itemname); ?></td>
                    <td class="td-non-itemname"><?php echo e($barang->heatno); ?></td>
                    <td class="td-non-itemname"><?php echo e($barang->dimension); ?></td>
                    <td class="td-non-itemname"><?php echo e($barang->tolerance); ?></td>
                    <td class="td-non-itemname"><?php echo e($barang->kondisi); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
    </table>
    <h2>
        Item Selisih Minus

    </h2>
    <table>
        <thead>
            <tr class="tr-head">
                <th style="width: 25%">Nama Item</th>
                <th style="width: 10%">Heat No</th>
                <th style="width: 10%">Dimension</th>
                <th style="width: 10%">Tolerance</th>
                <th style="width: 15%">Condition</th>
            </tr>
        </thead>
        <tbody>

            <?php $__currentLoopData = $itemSelisihMinus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="tr-body">
                    <td><?php echo e($barang->itemname); ?></td>
                    <td class="td-non-itemname"><?php echo e($barang->heatno); ?></td>
                    <td class="td-non-itemname"><?php echo e($barang->dimension); ?></td>
                    <td class="td-non-itemname"><?php echo e($barang->tolerance); ?></td>
                    <td class="td-non-itemname"><?php echo e($barang->kondisi); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
    </table>
<?php endif; ?>
<?php /**PATH /var/www/html/sos-dev/resources/views/admin/dashboard/pdf-item.blade.php ENDPATH**/ ?>