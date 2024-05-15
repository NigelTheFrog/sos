<?php $__env->startSection('title', 'Daftar Barang Selisih'); ?>

<?php $__env->startSection('content'); ?>

    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="mb-3 mt-3">
                    <h5>List Item Barang Selisih</h5>
                </div>
                <div class="card card-secondary mb-3">
                    <div class="card-header bg-secondary text-white">
                        <h3 class="card-title">Item tertukar</h3>
                    </div>
                    <form action="<?php echo e(route('barang-selisih.update', 'barang_selisih')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="text" name="type" value="1" hidden>
                        <div class="card-body small">
                            <div style="overflow-x: scroll; overflow-y: hidden; max-width: 82vw; ">
                            <table class="table table-striped table-hover text-center" style="min-width:150%;">
                                <thead>
                                    <tr>
                                        <th class="d-none"></th>
                                        <th style="width: 2%">No</th>
                                        <th style="width: 10%">Nama Item</th>
                                        <th style="width: 5%">Keputusan</th>
                                        <th style="width: 2%">SLS LBR</th>
                                        <th style="width: 3%">Realita LBR</th>
                                        <th style="width: 5%">Selisih<br>Plus (qty)</th>
                                        <th style="width: 6%">Selisih<br>Minus (qty)</th>
                                        <th style="width: 9%">HPP</th>
                                        <th style="width: 9%">HPP Manual</th>
                                        <th style="width: 9%">Selisih Plus<br>(nominal)</th>
                                        <th style="width: 9%">Selisih Minus<br>(nominal)</th>
                                        <th style="width: 9%">Pembebanan<br>(nominal)</th>
                                        <th style="width: 5%">Group</th>
                                        <th style="width: 6%">No Adjust<br>(GI/SJ & GR)</th>
                                        <th>Keterangan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $tertukar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tertukar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td hidden><input type="text" name="trsdetid[]"
                                                    value="<?php echo e($tertukar->trsdetid); ?>"></td>
                                            <th><?php echo e($index + 1); ?></th>
                                            <td><?php echo e($tertukar->itemname); ?></td>
                                            <td><select class="form-select form-select-sm" name="keputusan[]">
                                                   <?php if($tertukar->keputusan != null): ?>
                                                        <option value="<?php echo e($tertukar->keputusan); ?>" selected>
                                                            <?php $__currentLoopData = $keputusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($kep->keputusanid == $tertukar->keputusan): ?>
                                                            <?php echo e($kep->keputusandesc); ?>

                                                            <?php endif; ?>                                                                
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </option>
                                                        <?php $__currentLoopData = $keputusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($kep->keputusanid); ?>">
                                                                <?php echo e($kep->keputusandesc); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <option selected>Pilih Keputusan</option>
                                                        <?php $__currentLoopData = $keputusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($kep->keputusanid); ?>">
                                                                <?php echo e($kep->keputusandesc); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>      
                                                </select> </td>
                                            <td><?php echo e($tertukar->onhand); ?></td>
                                            <td><?php echo e($tertukar->onhand); ?></td>
                                            <td><?php echo e(number_format($tertukar->selisihplus , 2, ',', '.')); ?></td>
                                            <td><?php echo e(number_format($tertukar->selisihmin , 2, ',', '.')); ?></td>
                                            <td>Rp. <?php echo e(number_format($tertukar->cogs , 2, ',', '.')); ?></td>
                                            <td>
                                                <?php if($tertukar->cogs_manual != null): ?>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="hpp[]" value="<?php echo e($tertukar->cogs_manual); ?>">
                                                <?php else: ?>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="hpp[]">
                                                <?php endif; ?>
                                            </td>
                                            <td>Rp. <?php echo e(number_format($tertukar->nominalplus , 2, ',', '.')); ?></td>
                                            <td>Rp. <?php echo e(number_format($tertukar->nominalmin , 2, ',', '.         ')); ?></td>
                                            <td>
                                                <?php if($tertukar->pembebanan != null): ?>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="pembebanan[]" value="<?php echo e($tertukar->pembebanan); ?>">
                                                <?php else: ?>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="pembebanan[]">
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($tertukar->groupid); ?></td>
                                            <td>
                                                <?php if($tertukar->nodoc != null): ?>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="nodok[]" value="<?php echo e($tertukar->nodoc); ?>">
                                                <?php else: ?>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="nodok[]">
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($tertukar->keterangan != null): ?>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="keterangan[]" value="<?php echo e($tertukar->keterangan); ?>">
                                                <?php else: ?>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="keterangan[]">
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            </div>
                            <button type="submit" name="simpan-itm-tertukar" class="btn btn-primary mt-3"><i
                                    class="fas fa-save pe-2"></i>save</button>
                        </div>
                    </form>
                </div>

                <div class="card card-secondary">
                    <div class="card-header bg-secondary text-white">
                        <h3 class="card-title">Item Selisih Plus & Selisih Minus</h3>
                    </div>
                    <form action="<?php echo e(route('barang-selisih.update', 'barang_selisih')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="text" name="type" value="2" hidden>
                        <div class="card-body small" >
                            <div style="overflow-x: scroll; overflow-y: hidden; max-width: 82vw; ">
                            <table class="table table-striped table-hover text-center" style="min-width:150%;">
                                <thead>
                                    <tr>
                                        <th class="d-none"></th>
                                        <th style="width: 2%">No</th>
                                        <th style="width: 10%">Nama Item</th>
                                        <th style="width: 5%">Keputusan</th>
                                        <th style="width: 2%">SLS LBR</th>
                                        <th style="width: 3%">Realita LBR</th>
                                        <th style="width: 5%">Selisih<br>Plus (qty)</th>
                                        <th style="width: 6%">Selisih<br>Minus (qty)</th>
                                        <th style="width: 9%">HPP</th>
                                        <th style="width: 9%">HPP Manual</th>
                                        <th style="width: 9%">Selisih Plus<br>(nominal)</th>
                                        <th style="width: 9%">Selisih Minus<br>(nominal)</th>
                                        <th style="width: 9%">Pembebanan<br>(nominal)</th>
                                        <th style="width: 5%">Group</th>
                                        <th style="width: 6%">No Adjust<br>(GI/SJ & GR)</th>
                                        <th>Keterangan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $selisih; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $selisih): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td hidden><input type="text" name="trsdetid[]"
                                                    value="<?php echo e($selisih->trsdetid); ?>"></td>
                                            <td><?php echo e($index + 1); ?></th>
                                            <td><?php echo e($selisih->itemname); ?></td>
                                            <td><select class="form-select form-select-sm" name="keputusan[]">
                                                    <?php if($selisih->keputusan != null): ?>
                                                        <option value="<?php echo e($selisih->keputusan); ?>" selected>
                                                            <?php $__currentLoopData = $keputusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($kep->keputusanid == $selisih->keputusan): ?>
                                                            <?php echo e($kep->keputusandesc); ?>

                                                            <?php endif; ?>                                                                
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </option>
                                                        <?php $__currentLoopData = $keputusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($kep->keputusanid); ?>">
                                                                <?php echo e($kep->keputusandesc); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <option selected>Pilih Keputusan</option>
                                                        <?php $__currentLoopData = $keputusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($kep->keputusanid); ?>">
                                                                <?php echo e($kep->keputusandesc); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </select> </td>
                                            <td><?php echo e($selisih->onhand); ?></td>
                                            <td><?php echo e($selisih->onhand); ?></td>
                                            <td><?php echo e(number_format($selisih->selisihplus, 2, '.', ',')); ?></td>
                                            <td><?php echo e(number_format($selisih->selisihmin, 2, '.', ',')); ?></td>
                                            <td>
                                                <?php if($selisih->cogs != 0): ?>
                                                    Rp.<?php echo e(number_format($selisih->cogs, 2, '.', ',')); ?>

                                                
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($selisih->cogs_manual != null): ?>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="hpp[]" value="<?php echo e($selisih->cogs_manual); ?>">
                                                <?php else: ?>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="hpp[]">
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($selisih->nominalplus != 0): ?>
                                                    Rp.<?php echo e(number_format($selisih->nominalplus, 2, '.', ',')); ?>

                                               
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($selisih->nominalmin != 0): ?>
                                                    Rp.<?php echo e(number_format($selisih->nominalmin, 2, '.', ',')); ?>

                                               
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($selisih->pembebanan != null): ?>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="pembebanan[]" value="<?php echo e($selisih->pembebanan); ?>">
                                                <?php else: ?>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="pembebanan[]">
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($selisih->groupid); ?></td>
                                            <td>
                                                <?php if($selisih->nodoc != null): ?>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="nodok[]" value="<?php echo e($selisih->nodoc); ?>">
                                                <?php else: ?>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="nodok[]">
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($selisih->keterangan != null): ?>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="keterangan[]" value="<?php echo e($selisih->keterangan); ?>">
                                                <?php else: ?>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="keterangan[]">
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            </div>
                            <button type="submit" name="simpan-itm-selisih" class="btn btn-primary mt-3"><i
                                    class="fas fa-save pe-2"></i>save</button>
                        </div>
                    </form>
                </div>
                <div class="card card-secondary mt-3">
                    <div class="card-header bg-secondary text-white">
                        <h3 class="card-title">Kesalahan Admin</h3>
                    </div>
                    <form action="<?php echo e(route('barang-selisih.update', 'barang_selisih')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="text" name="type" value="3" hidden>
                        <div class="card-body small" >
                            <div style="overflow-x: scroll; overflow-y: hidden; max-width: 82vw; ">
                            <table class="table table-striped table-hover text-center" style="min-width:150%;">
                                <thead>
                                    <tr>
                                        <th class="d-none"></th>
                                        <th style="width: 2%">No</th>
                                        <th style="width: 10%">Nama Item</th>
                                        <th style="width: 5%">Keputusan</th>
                                        <th style="width: 2%">SLS LBR</th>
                                        <th style="width: 3%">Realita LBR</th>
                                        <th style="width: 5%">Selisih<br>Plus (qty)</th>
                                        <th style="width: 6%">Selisih<br>Minus (qty)</th>
                                        <th style="width: 9%">HPP</th>
                                        <th style="width: 9%">HPP Manual</th>
                                        <th style="width: 9%">Selisih Plus<br>(nominal)</th>
                                        <th style="width: 9%">Selisih Minus<br>(nominal)</th>
                                        <th style="width: 9%">Pembebanan<br>(nominal)</th>
                                        <th style="width: 5%">Group</th>
                                        <th style="width: 6%">No Adjust<br>(GI/SJ & GR)</th>
                                        <th>Keterangan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $kesalahan_admin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td hidden><input type="text" name="trsdetid[]"
                                                    value="<?php echo e($admin->trsdetid); ?>"></td>
                                            <td><?php echo e($index + 1); ?></th>
                                            <td><?php echo e($admin->itemname); ?></td>
                                            <td><select class="form-select form-select-sm" name="keputusan[]">
                                                    <?php if($admin->keputusan != null): ?>
                                                        <option value="<?php echo e($admin->keputusan); ?>" selected>
                                                            <?php $__currentLoopData = $keputusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($kep->keputusanid == $admin->keputusan): ?>
                                                            <?php echo e($kep->keputusandesc); ?>

                                                            <?php endif; ?>                                                                
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </option>
                                                        <?php $__currentLoopData = $keputusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($kep->keputusanid); ?>">
                                                                <?php echo e($kep->keputusandesc); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <option selected>Pilih Keputusan</option>
                                                        <?php $__currentLoopData = $keputusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($kep->keputusanid); ?>">
                                                                <?php echo e($kep->keputusandesc); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </select> </td>
                                            <td><?php echo e($admin->onhand); ?></td>
                                            <td><?php echo e($admin->onhand); ?></td>
                                            <td><?php echo e(number_format($admin->selisihplus, 2, '.', ',')); ?></td>
                                            <td><?php echo e(number_format($admin->selisihmin, 2, '.', ',')); ?></td>
                                            <td>
                                                <?php if($admin->cogs != 0): ?>
                                                    Rp.<?php echo e(number_format($admin->cogs, 2, '.', ',')); ?>

                                                
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($admin->cogs_manual != null): ?>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="hpp[]" value="<?php echo e($admin->cogs_manual); ?>">
                                                <?php else: ?>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="hpp[]">
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($admin->nominalplus != 0): ?>
                                                    Rp.<?php echo e(number_format($admin->nominalplus, 2, '.', ',')); ?>

                                               
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($admin->nominalmin != 0): ?>
                                                    Rp.<?php echo e(number_format($admin->nominalmin, 2, '.', ',')); ?>

                                               
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($admin->pembebanan != null): ?>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="pembebanan[]" value="<?php echo e($admin->pembebanan); ?>">
                                                <?php else: ?>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="pembebanan[]">
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($admin->groupid); ?></td>
                                            <td>
                                                <?php if($admin->nodoc != null): ?>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="nodok[]" value="<?php echo e($admin->nodoc); ?>">
                                                <?php else: ?>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="nodok[]">
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($admin->keterangan != null): ?>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="keterangan[]" value="<?php echo e($admin->keterangan); ?>">
                                                <?php else: ?>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="keterangan[]">
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            </div>
                            <button type="submit" name="simpan-itm-selisih" class="btn btn-primary mt-3"><i
                                    class="fas fa-save pe-2"></i>save</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/sos-dev/resources/views/admin/resume/barang-selisih.blade.php ENDPATH**/ ?>