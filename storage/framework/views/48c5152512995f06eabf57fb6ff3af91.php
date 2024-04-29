<table class="table table-sm table-bordered table-hover table-responsive small table-striped">
    <thead class="table-dark">
        <tr class="text-center ">
            <th class="align-middle" style="width: 15%">Nama Item</th>
            <th class="align-middle" style="width: 5%">Dimension</th>
            <th class="align-middle" style="width: 5%">Tolerance</th>
            <th class="align-middle" style="width: 5%">Selisih</th>
            <th class="align-middle" style="width: 5%">Onhand</th>
            <th class="align-middle" style="width: 2%">Total CSO</th>
            <th class="align-middle" style="width: 3%">Koreksi</th>
            <th class="align-middle" style="width: 3%">Deviasi</th>
            <th class="align-middle" style="width: 2%">Status CSO</th>
            <th class="align-middle" style="width: 14%">Grouping</th>
            <th class="align-middle" style="width: 16%">Analisator</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $avalanBlmProses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($barang->itemname); ?></td>
                <td class="align-middle text-center"><?php echo e($barang->dimension); ?></td>
                <td class="align-middle text-center"><?php echo e($barang->tolerance); ?></td>
                <td class="align-middle text-center"><?php echo e($barang->selisih); ?></td>
                <td class="align-middle text-center"><?php echo e($barang->onhand); ?></td>
                <td class="align-middle text-center"><?php echo e($barang->totalcso); ?></td>
                <td class="align-middle text-center"><?php echo e($barang->koreksi); ?></td>
                <td class="align-middle text-center"><?php echo e($barang->deviasi); ?></td>
                <td class="align-middle text-center"><?php echo e($barang->statuscso); ?></td>
                <td class="align-middle text-center">
                    <select class="form-select" name="analistaor" id="">
                        <option value="" selected>--Pilih Group --</option>
                        <?php $__currentLoopData = $dbmgroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($group->groupid); ?>"><?php echo e($group->groupdesc); ?></option>                            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </td>
                <td class="align-middle text-center">
                    <select class="form-select" name="analistaor" id="">
                        <option value="" selected>--Pilih Analisator --</option>
                        <?php $__currentLoopData = $dbxjob; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->userid); ?>"><?php echo e($user->name); ?></option>                            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH /var/www/html/sos-dev/resources/views/admin/dashboard/table/avalan/avalan-belum-proses.blade.php ENDPATH**/ ?>