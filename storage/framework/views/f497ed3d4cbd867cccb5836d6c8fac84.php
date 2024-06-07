<div class="modal fade text-left" id="ModalItemBlmProses" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mdlMoreLabel">Item Belum Proses</h1>
                <button type="button" class="btn-close align-middle" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-hover table-responsive small">
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
                    <tbody class="table-striped-columns">
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
            </div>
        </div>
    </div>
</div><?php /**PATH /var/www/html/sos-dev/resources/views/admin/modal/modalItem.blade.php ENDPATH**/ ?>