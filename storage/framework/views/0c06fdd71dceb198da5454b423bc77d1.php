<?php $__env->startSection('title', 'Cek Stok'); ?>
<?php $__env->startSection('styles'); ?>
    <style>
        .title-info {
            padding-top: 25px;
        }

        .page-break {
            page-break-after: always;
        }

        th {
            text-align: center;

            border: 1px solid;
            padding-left: 2px;
            padding-right: 2px;
            vertical-align: middle;
        }

        .th-content-cso {
            border-color: rgb(65, 65, 65);
            font-size: 9pt;
        }

        .th-content-noncso {
            border-color: rgb(65, 65, 65);
            font-size: 9pt;
            height: 1cm;
        }

        .tr-head {
            background-color: #1c1c1c;
            color: white;
            border-color: rgb(65, 65, 65);
        }

        td {
            border: 1px solid;
            vertical-align: middle;
            height: 1cm;
        }

        .td-persetujuan {
            vertical-align: middle;
            text-align: center;
            font-size: 9.5pt;
            font-weight: bold;
            width: 12.5%
        }

        .td-content {
            border-color: rgb(192, 192, 192);
        }

        .td-selisih-minus {
            color: red;
            border-color: rgb(192, 192, 192);
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

        .tr-body-divider {
            background-color: #fcba03;
            font-weight: bold;
            padding-left: 2cm;
            font-size: 9pt;
            border-color: rgb(192, 192, 192);
        }

        .tr-selisih {
            font-size: 8pt;
            line-height: 0.5cm
        }

        .tr-rekapitulasi-global {
            text-align: center;
            align-items: center;
            font-size: 9pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        h2 {
            font-family: Arial, sans-serif;
            text-align: justify;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper mt-3">
        <!-- Main content -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="">
                        <div class="card card-secondary">
                            <div class="card-header bg-secondary text-white">
                                <div class="row justify-content-between">
                                    <div class="col-md-8">
                                        <h3 class="card-title"><?php echo e($title); ?></h3>
                                    </div>
                                    <?php if($dataCso->statusdoc == 'P'): ?>
                                        <div class="col-md-4 text-end">
                                            <form method="POST" action="<?php echo e(route('cek-stok.store')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <input type="text" name="trsidlaporan" value="<?php echo e($trsidlaporan); ?>"
                                                    hidden>
                                                <input type="text" name="type" value="3" hidden>
                                                <button type="submit" class="btn btn-primary text-white"><i
                                                        class="fas fa-print pe-2"></i>Print Keseluruhan</button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-body" style="background-color: #f8f8f8;">
                                <h2>
                                    <?php echo e(substr($dataCso->doccsoid,0,3)); ?> SRM TANGGAL:
                                    <?php echo e(Str::upper(\Carbon\Carbon::parse($dataCso->startcsodate)->translatedFormat('j F Y'))); ?>

                                </h2>
                                <h2>
                                    MATERIAL: <?php echo e(Str::upper($dataCso->csomaterial)); ?>

                                </h2>
                                <h2>
                                    LOKASI: PT. SUTINDO RAYA MULIA
                                </h2>

                                <div class="page-break"
                                    style="margin-top: 20px; max-width: 80vw; overflow-x: auto; overflow-y: auto">
                                    <table style="border-collapse: collapse;min-width: 200%;">
                                        <thead>
                                            <tr class="tr-head">
                                                <th class="th-content-noncso" rowspan="2" style="width: 0.5cm">No</th>
                                                <th class="th-content-noncso" rowspan="2" style="width: 1.25cm">Nama Item
                                                </th>
                                                <th class="th-content-noncso" rowspan="2" style="width: 0.5cm">UOM</th>
                                                <th class="th-content-noncso" rowspan="2" style="width: 0.75cm">
                                                    Analisator</th>
                                                <?php $__currentLoopData = $dataWrh; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wrh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <th class="th-content-noncso" rowspan="2" style="width: 0.5cm">
                                                        <?php echo e($wrh->wrh); ?></th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <th class="th-content-noncso" rowspan="2" style="width: 0.75cm">Total
                                                </th>
                                                <th class="th-content-cso" colspan="4" style="width: 2cm">CSO 1</th>
                                                <th class="th-content-cso" colspan="4" style="width: 2cm">CSO 2</th>
                                                <th class="th-content-cso" colspan="4" style="width: 2cm">CSO 3</th>
                                                <th class="th-content-cso" colspan="3" style="width: 2cm">Trace</th>
                                                <th class="th-content-noncso" rowspan="2" style="width: 0.5cm">Warna</th>
                                                <th class="th-content-noncso" rowspan="2" style="width: 0.5cm">Keterangan
                                                </th>
                                                <th class="th-content-noncso" rowspan="2" style="width: 1cm">Pelaku</th>
                                            </tr>
                                            <tr class="tr-head">
                                                <th class="th-content-cso" style="width: 0.5cm">Realita Fisik</th>
                                                <th class="th-content-cso" style="width: 0.5cm">Selisih Fisik</th>
                                                <th class="th-content-cso" style="width: 0.75cm">Lokasi</th>
                                                <th class="th-content-cso" style="width: 0.25cm">Kesimpulan</th>

                                                <th class="th-content-cso" style="width: 0.5cm">Realita Fisik</th>
                                                <th class="th-content-cso" style="width: 0.5cm">Selisih Fisik</th>
                                                <th class="th-content-cso" style="width: 0.75cm">Lokasi</th>
                                                <th class="th-content-cso" style="width: 0.25cm">Kesimpulan</th>

                                                <th class="th-content-cso" style="width: 0.5cm">Realita Fisik</th>
                                                <th class="th-content-cso" style="width: 0.5cm">Selisih Fisik</th>
                                                <th class="th-content-cso" style="width: 0.75cm">Lokasi</th>
                                                <th class="th-content-cso" style="width: 0.25cm">Kesimpulan</th>

                                                <th class="th-content-cso" style="width: 0.5cm">Realita Fisik</th>
                                                <th class="th-content-cso" style="width: 0.5cm">Selisih Fisik</th>
                                                <th class="th-content-cso" style="width: 0.5cm">Kesimpulan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $dataLaporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="tr-rekapitulasi-global">
                                                    <td class="td-content"><?php echo e($index + 1); ?></td>
                                                    <td class="td-content"><?php echo e($laporan->itemname); ?></td>
                                                    <td class="td-content"><?php echo e($laporan->uom); ?></td>
                                                    <td class="td-content"><?php echo e($laporan->name); ?></td>
                                                    <?php $__currentLoopData = $dataWrh; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wrh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <td class="td-content">
                                                            <?php $__currentLoopData = $dataWrhQty; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qtyWrh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if($qtyWrh->wrh == $wrh->wrh && $qtyWrh->trsdetid == $laporan->trsdetid): ?>
                                                                    <?php echo e($qtyWrh->qty); ?>

                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </td>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <td class="td-content"><?php echo e($laporan->onhand); ?></td>

                                                    <td class="td-content"><?php echo e($laporan->qtycso1); ?></td>
                                                    <td class="td-content"><?php echo e($laporan->onhand - $laporan->qtycso1); ?></td>
                                                    <td class="td-content"><?php echo e($laporan->loctcso1); ?></td>
                                                    <?php if($laporan->qtycso1 != $laporan->onhand): ?>
                                                        <td class="td-content" style="background-color: #FFC8AA">False
                                                        </td>
                                                    <?php else: ?>
                                                        <td class="td-content" style="background-color: #D4EBBC">True</td>
                                                    <?php endif; ?>


                                                    <td class="td-content"><?php echo e($laporan->qtycso2); ?></td>
                                                    <td class="td-content">
                                                        <?php if($laporan->qtycso1 != $laporan->onhand): ?>
                                                            <?php echo e($laporan->onhand - $laporan->qtycso2); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="td-content"><?php echo e($laporan->loctcso2); ?></td>
                                                    <?php if($laporan->qtycso1 != $laporan->onhand && $laporan->qtycso2 != $laporan->onhand): ?>
                                                        <td class="td-content" style="background-color: #FFC8AA">False
                                                        </td>
                                                    <?php else: ?>
                                                        <td class="td-content" style="background-color: #D4EBBC">True</td>
                                                    <?php endif; ?>

                                                    <td class="td-content"><?php echo e($laporan->qtycso3); ?></td>
                                                    <td class="td-content">
                                                        <?php if($laporan->qtycso1 != $laporan->onhand && $laporan->qtycso2 != $laporan->onhand): ?>
                                                            <?php echo e($laporan->onhand - $laporan->qtycso3); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="td-content"><?php echo e($laporan->loctcso3); ?></td>
                                                    <?php if(
                                                        $laporan->qtycso1 != $laporan->onhand &&
                                                            $laporan->qtycso2 != $laporan->onhand &&
                                                            $laporan->qtycso3 != $laporan->onhand): ?>
                                                        <td class="td-content" style="background-color: #FFC8AA">False
                                                        </td>
                                                    <?php else: ?>
                                                        <td class="td-content" style="background-color: #D4EBBC">True</td>
                                                    <?php endif; ?>
                                                    <td class="td-content">
                                                        <?php echo e($laporan->trace); ?>

                                                    </td>
                                                    <td class="td-content">
                                                        <?php if(
                                                            $laporan->qtycso1 != $laporan->onhand &&
                                                                $laporan->qtycso2 != $laporan->onhand &&
                                                                $laporan->qtycso3 != $laporan->onhand): ?>
                                                            <?php echo e($laporan->onhand - $laporan->trace); ?>

                                                        <?php endif; ?>
                                                    </td>

                                                    <?php if(
                                                        $laporan->qtycso1 != $laporan->onhand &&
                                                            $laporan->qtycso2 != $laporan->onhand &&
                                                            $laporan->qtycso3 != $laporan->onhand &&
                                                            $laporan->trace != $laporan->onhand): ?>
                                                        <td class="td-content" style="background-color: #FFC8AA">False
                                                        </td>
                                                    <?php else: ?>
                                                        <td class="td-content" style="background-color: #D4EBBC">True</td>
                                                    <?php endif; ?>
                                                    <td class="td-content"><?php echo e($laporan->color); ?></td>
                                                    <td class="td-content"><?php echo e($laporan->keterangan); ?></td>
                                                    <td class="td-content"><?php echo e($laporan->pelaku); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/sos-dev/resources/views/admin/report/preview-item/preview-laporan-cso.blade.php ENDPATH**/ ?>