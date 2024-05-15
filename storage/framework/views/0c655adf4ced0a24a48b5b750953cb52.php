<?php if(Auth::user()->level != 1 && Auth::user()->level != 2): ?>
<div class="mb-3">
    <?php if($checkItemType->statusitem == 'T'): ?>
        <button type="button"  class="btn btn-danger " onclick="hapusItemTemuan(this)"><i class="fas fa-trash-alt"></i>
            Hapus Item</button>
    <?php endif; ?>
</div>
<?php endif; ?>
<table class="table table-sm table-bordered small mb-3 text-center">
    <thead class="table-secondary">
        <tr>
            <th scope="col">Heat Number</th>
            <th scope="col">Dimension</th>
            <th scope="col">Tolerance</th>
            <th scope="col">Condition</th>
        </tr>

    </thead>
    <tbody>
        <tr>
            <td>
                <?php if($heatno != null): ?>
                    <?php echo e($heatno); ?>

                <?php else: ?>
                    -
                <?php endif; ?>

            </td>
            <td>
                <?php if($dimension != null): ?>
                    <?php echo e($dimension); ?>

                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td>
                <?php if($tolerance != null): ?>
                    <?php echo e($tolerance); ?>

                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td>
                <?php if($kondisi != null): ?>
                    <?php echo e($kondisi); ?>

                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>
<div id="warning" class="alert alert-warning d-none"></div>
<input type="text" name="itemid" class="d-none" value="<?php echo e($itemid); ?>">
<input type="text" name="batchno" class="d-none" value="<?php echo e($batchno); ?>">
<input type="text" name="trsdetid" id="trsdetidparam" class="d-none" value="<?php echo e($trsdetid); ?>">

<div class="row g-3 mb-3">
    <div class="form-floating col">
        <input class="form-control text-center text-white bg-primary shadow-sm"
            value="<?php echo e(number_format($onhand, 2, ',', '.')); ?>" id="onHand" type="text" readonly>
        <label class="fw-bold" for="onHand">On Hand</label>
    </div>
    <div class="form-floating col">
        <input class="form-control text-center bg-warning shadow-sm" value="<?php echo e(number_format($totalcso, 2, ',', '.')); ?>"
            type="text" readonly>
        <label class="fw-bold">Qty CSO</label>
    </div>
    <div class="form-floating col">
        <input class="form-control text-center text-white bg-danger shadow-sm"
            value="<?php echo e(number_format($selisih, 2, ',', '.')); ?>" type="text" readonly>
        <label class="fw-bold" for="vselisih">Selisih</label>
    </div>
    <div class="form-floating col">
        <input class="form-control text-center shadow-sm" name="koreksi" value="<?php echo e($koreksi); ?>" type="number">
        <label class="fw-bold" for="vkoreksi">Input Koreksi</label>
    </div>
    <div class="form-floating col">
        <input class="form-control text-center shadow-sm" name="deviasi" value="<?php echo e($deviasi); ?>" type="number">
        <label class="fw-bold" for="vdeviasi">Input Deviasi</label>
    </div>
</div>
<div id="tbldetail">
    <table class="table table-sm table-hover table-bordered table-responsive-md small shadow-sm">
        <thead class="table-secondary">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Pelaku</th>
                <th scope="col">Lokasi</th>
                <th scope="col">Color</th>
                <th scope="col">Qty/lokasi</th>
                <th scope="col">CSO ke-</th>
                <th scope="col">Remark</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $tableDetailDashboard; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($detail->name); ?></td>
                    <td><?php echo e($detail->locationname); ?></td>
                    <td><?php echo e($detail->color); ?></td>
                    <td><?php echo e(number_format($detail->qty, 2, ',', '.')); ?></td>
                    <td><?php echo e($detail->csocount); ?></td>
                    <td><?php echo e($detail->remark); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div class="row mb-2">
    <div class="col-7">
        <table class="table table-sm table-responsive-md table-hover table-bordered shadow-sm small">
            <thead class="table-secondary">
                <tr>
                    <th scope="col">Pelaku</th>
                    <th scope="col">CSO 1</th>
                    <th scope="col">CSO 2</th>
                    <th scope="col">CSO 3</th>
                    <th scope="col">CSO 4</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $dataCso; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($cso->name); ?></td>                        
                        <?php if($cso->cso1 > 0 ): ?>
                            <td class="bg-info"><?php echo e(number_format($cso->cso1, 2, ',', '.')); ?></td>
                        <?php else: ?>
                            <td><?php echo e($cso->cso1); ?></td>
                        <?php endif; ?>
                        <?php if($cso->cso2 > 0): ?>
                            <td class="bg-info"><?php echo e(number_format($cso->cso2, 2, ',', '.')); ?></td>
                        <?php else: ?>
                            <td><?php echo e($cso->cso2); ?></td>
                        <?php endif; ?>
                        <?php if($cso->cso3 > 0): ?>
                            <td class="bg-info"><?php echo e(number_format($cso->cso3, 2, ',', '.')); ?></td>
                        <?php else: ?>
                            <td><?php echo e($cso->cso3); ?></td>
                        <?php endif; ?>
                        <?php if($cso->cso4 > 0): ?>
                            <td class="bg-info"><?php echo e(number_format($cso->cso4, 2, ',', '.')); ?></td>
                        <?php else: ?>
                            <td><?php echo e($cso->cso4); ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php $__currentLoopData = $totalCso; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tCso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="table-secondary">
                        <td>Total</td>
                        <td><?php echo e(number_format($tCso->totalcso1, 2, ',', '.')); ?></td>
                        <td><?php echo e(number_format($tCso->totalcso2, 2, ',', '.')); ?></td>
                        <td><?php echo e(number_format($tCso->totalcso3, 2, ',', '.')); ?></td>
                        <td><?php echo e(number_format($tCso->totalcso4, 2, ',', '.')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="col-2">
        <input type="text" id="itemid" class="d-none" value="<?php echo e($itemid); ?>">
        <input type="text" id="batchno" class="d-none" value="<?php echo e($batchno); ?>">
        <?php if(Auth::user()->level == 1 || Auth::user()->level == 2): ?>
            <button type="button" id="csoulang" onclick="csoUlang(this)" name="csoorder" class="btn btn-info mb-3"
                <?php if($checkCso == 0 ): ?> disabled <?php endif; ?>>CSO Ulang</button>
        <?php endif; ?>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkkesalahanadmin" name="check_kesalahan_admin"
                <?php if($dataAdminBatch->kesalahan_admin == 1): ?> checked <?php endif; ?> 
                <?php if(Auth::user()->level != 1 && Auth::user()->level != 2): ?> disabled <?php endif; ?>>
            <label class="form-check-label small" for="checkkesalahanadmin">
                Kesalahan Admin
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkbatchTertukar" name="check_batch_tertukar"
                <?php if($dataAdminBatch->batch_tertukar == 1): ?> checked <?php endif; ?> 
                <?php if(Auth::user()->level != 1 && Auth::user()->level != 2): ?> disabled <?php endif; ?>>
            <label class="form-check-label small" for="checkbatchTertukar">
                Beda Batch
            </label>
        </div>
    </div>
    <div class="col-3 small">
        <div class="w-100 mb-2">
            <label class="input-group-text small">Analisator</label>
            <select class="form-select form-select-sm" id="" name="analisator"
                <?php if(Auth::user()->level != 1 && Auth::user()->level != 2): ?> disabled <?php endif; ?>>
                <?php if(count($analisator) == 0): ?>
                    <option value="" selected>--Pilih Analisator--</option>
                    <?php $__currentLoopData = $dbxJob; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($job->userid); ?>"><?php echo e($job->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <option value="">-</option>
                    <?php $__currentLoopData = $dbxJob; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($job->userid); ?>"
                            <?php $__currentLoopData = $analisator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $analis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($job->userid == $analis->analisatorid): ?>
                                selected                            
                                <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>>
                            <?php echo e($job->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="w-100 mb-2">
            <label class="input-group-text small">Grouping</label>
            <select class="form-select form-select-sm" id="" name="grouping">
                <?php if(count($analisator) == 0): ?>
                    <option value="" selected>--Pilih Group--</option>
                    <?php $__currentLoopData = $group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($grup->groupid); ?>"><?php echo e($grup->groupdesc); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <option value="0">-</option>
                    <?php $__currentLoopData = $group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($grup->groupid); ?>"
                            <?php $__currentLoopData = $analisator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $analis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($grup->groupid == $analis->groupid): ?>
                                selected                            
                                <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>>
                            <?php echo e($grup->groupdesc); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
        </div>
    </div>
</div>

<div class="">
    <label for="vketerangan" class="input-group-text">Keterangan Koreksi</label>
    <textarea class="form-control form-control-sm" name="keterangan" id="vketerangan"><?php echo e($keterangan); ?></textarea>
</div>

<script>
    function hapusItemTemuan(button) {
        var itemidparam = $("#itemid").val(); // Get the selected gudang values
        var batchnoparam = $("#batchno").val();
        var trsdetidparam = $("#trsdetidparam").val();

        $.ajax({
            url: "<?php echo e(url('admin/dashboard/item/hapus-temuan-item')); ?>",
            method: "POST",
            data: {
                itemid: itemidparam,
                batchno: batchnoparam,
                trsdetid: trsdetidparam

            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data['result'] == 1) {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: `Temuan item dengan id ${itemidparam}\nberhasil dihapus`,
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Terjadi kesalahan pada sistem, segera laporkan pada tim IT",
                    });
                }

            },
            error: function() {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Terjadi kesalahan pada sistem, segera laporkan pada tim IT",
                });
            }
        });
    }

    function csoUlang(button) {
        var itemidparam = $("#itemid").val(); // Get the selected gudang values
        var batchnoparam = $("#batchno").val();
        var buttonCsoUlang = document.getElementById("csoulang");
        $.ajax({
            url: "<?php echo e(url('admin/dashboard/item/cso-ulang')); ?>",
            method: "POST",
            data: {
                itemid: itemidparam,
                batchno: batchnoparam,
                
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data['result'] == 1) {
                    if (batchnoparam == null || batchnoparam == "") {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: `Item dengan id ${itemidparam}\nberhasil di CSO Ulang`,
                        });

                    } else {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: `Item dengan id ${itemidparam} dan batch number ${batchnoparam}\nberhasil di CSO Ulang`,
                        });
                    }
                    buttonCsoUlang.disabled = true;
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Gagal melakukan CSO ulang",
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Terjadi kesalahan pada sistem, segera laporkan pada tim IT",
                });
            }
        });
    }
</script>
<?php /**PATH /var/www/html/sos-dev/resources/views/admin/dashboard/table/item/detail-cso-item.blade.php ENDPATH**/ ?>