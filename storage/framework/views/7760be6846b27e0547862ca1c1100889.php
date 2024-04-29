<?php $__env->startSection('title', 'Preview Cek Stok'); ?>
<?php $__env->startSection('styles'); ?>

    <style>
        .title-info {
            padding-top: 25px;
        }

        th {
            text-align: center;
            font-size: 9.5pt;
            border: 1px solid;
            padding-left: 2px;
            padding-right: 2px;
            line-height: 1.75;
            vertical-align: middle;
        }

        .th-content {
            border-color: rgb(65, 65, 65);
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
            line-height: 2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        h2 {
            font-family: Arial, sans-serif;
            text-align: center;
        }
    </style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="content-wrapper mt-3">
        <!-- Main content -->
        <section class="content-header">
            <div class="container-fluid">

                <div class="card card-secondary">
                    <div class="card-header bg-secondary text-white">
                        <div class="row justify-content-between">
                            <div class="col-md-8">
                                <h3 class="card-title"><?php echo e($title); ?></h3>
                            </div>
                            <?php if($dataCso->statusdoc == 'P'): ?>
                                <div class="col-md-4 text-end">
                                    <div class="d-flex flex-row-reverse">
                                        <div>
                                            <div class="dropdown">
                                                <button class="btn btn-primary text-white dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-print pe-2"></i>Print Keseluruhan
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <form method="POST" action="<?php echo e(route('cek-stok.store')); ?>">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="text" name="trsidresume"
                                                                value="<?php echo e($trsidresume); ?>" hidden>
                                                            <input type="text" name="type" value="1" hidden>
                                                            <input type="text" name="orientation" value="1" hidden>
                                                            <button class="dropdown-item" type="submit">Potrait</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form method="POST" action="<?php echo e(route('cek-stok.store')); ?>">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="text" name="trsidresume"
                                                                value="<?php echo e($trsidresume); ?>" hidden>
                                                            <input type="text" name="type" value="1" hidden>
                                                            <input type="text" name="orientation" value="2" hidden>
                                                            <button class="dropdown-item" type="submit">Landscape</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="me-2">
                                            <div class="dropdown">
                                                <button class="btn btn-primary text-white dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-print pe-2"></i>Print Warehouse
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <form method="POST" action="<?php echo e(route('cek-stok-avalan.store')); ?>">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="text" name="trsidresume"
                                                                value="<?php echo e($trsidresume); ?>" hidden>
                                                            <input type="text" name="type" value="2" hidden>
                                                            <input type="text" name="orientation" value="1" hidden>
                                                            <button class="dropdown-item" type="submit">Potrait</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form method="POST" action="<?php echo e(route('cek-stok-avalan.store')); ?>">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="text" name="trsidresume"
                                                                value="<?php echo e($trsidresume); ?>" hidden>
                                                            <input type="text" name="type" value="2" hidden>
                                                            <input type="text" name="orientation" value="2" hidden>
                                                            <button class="dropdown-item" type="submit">Landscape</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body" style="background-color: #f8f8f8; max-height: 1330px; overflow: auto;">
                        <h2 style="text-align: center">
                            LAPORAN HASIL PELAKSANAAN CEK STOK
                        </h2>
                        <div>
                            <h4>
                                I. PELAKSANAAN CEK STOK
                            </h4>
                            <p>Nama perusahaan : PT. Sutindo Raya Mulia Surabaya</p>
                            <p>Tanggal pelaksanaan cek stok :
                                <?php echo e(\Carbon\Carbon::parse($dataCso->startcsodate)->translatedFormat('j F Y')); ?>

                            </p>
                            <p>Lokasi/kelompok produk yang di cek stok : <?php echo e($dataCso->csomaterial); ?> </p>
                        </div>
                        <div style="margin-top: 1cm">
                            <h4>
                                II. SUSUNAN TIM CEK STOK OPNAME
                            </h4>
                            <p>PIC CSO: </p>
                            <h5>Analistor</h5>
                            <table>
                                <thead>
                                    <tr class="tr-head">
                                        <th class="th-content" style="width: 5%">No</th>
                                        <th class="th-content" style="width: 20%">Nama Analisator</th>
                                        <th class="th-content" style="width: 15%">Departemen</th>
                                        <th class="th-content" style="width: 60%">Catatan tentang Analisator</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($dataAnalisator) > 0): ?>
                                        <?php $__currentLoopData = $dataAnalisator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $analisator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="tr-body">
                                                <th class="td-content"><?php echo e($index + 1); ?></th>
                                                <td class="td-content" style="padding: 8px"><?php echo e($analisator->name); ?></td>
                                                <td class="td-content" style="padding: 8px"><?php echo e($analisator->dept); ?></td>
                                                <td class="td-content" style="padding: 8px"><?php echo e($analisator->note); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr class="tr-body">
                                            <td class="td-content">&nbsp</th>
                                            <td class="td-content" style="padding: 8px">&nbsp</td>
                                            <td class="td-content" style="padding: 8px">&nbsp</td>
                                            <td class="td-content" style="padding: 8px">&nbsp</td>
                                        </tr>
                                    <?php endif; ?>

                                </tbody>
                            </table>
                            <h5>Pelaku</h5>
                            <table>
                                <thead>
                                    <tr class="tr-head">
                                        <th class="th-content" style="width: 5%">No</th>
                                        <th class="th-content" style="width: 20%">Nama Pelaku</th>
                                        <th class="th-content" style="width: 15%">Departemen</th>
                                        <th class="th-content" style="width: 60%">Catatan tentang Pelaku</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($dataPelaku) > 0): ?>
                                        <?php $__currentLoopData = $dataPelaku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pelaku): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="tr-body">
                                                <th class="td-content"><?php echo e($index + 1); ?></th>
                                                <td class="td-content" style="padding: 8px"><?php echo e($pelaku->name); ?></td>
                                                <td class="td-content" style="padding: 8px"><?php echo e($pelaku->dept); ?></td>
                                                <td class="td-content" style="padding: 8px"><?php echo e($pelaku->note); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr class="tr-body">
                                            <td class="td-content">&nbsp</th>
                                            <td class="td-content" style="padding: 8px">&nbsp</td>
                                            <td class="td-content" style="padding: 8px">&nbsp</td>
                                            <td class="td-content" style="padding: 8px">&nbsp</td>
                                        </tr>
                                    <?php endif; ?>

                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top: 1cm">
                            <h4>
                                III. REKAPITULASI HASIL CSO GLOBAL
                            </h4>

                            <table style=" border-collapse: collapse;width: 100%;">
                                <thead>
                                    <tr class="tr-head">
                                        <th class="th-content" rowspan="2" style="width: 1cm">Total Item </th>
                                        <th class="th-content" rowspan="2" style="width: 2.5cm">Item yang tidak ada
                                            fisik
                                        </th>
                                        <th class="th-content" rowspan="2" style="width: 2.75cm">Area / Kelompok
                                            produk
                                        </th>
                                        <th class="th-content" rowspan="2" style="width: 2.75cm">Item yang sudah dicek
                                            stok ada </th>
                                        <th class="th-content" colspan="2" style="width: 1.5cm">Hasil CSO</th>
                                        <th class="th-content" rowspan="2" style="width: 2.5cm ">% Keakuratan Stok
                                        </th>
                                        <th class="th-content" colspan="4" style="">% Item Selisih</th>
                                        <th class="th-content" rowspan="2"style="width: 2cm">% Selisih</th>
                                    </tr>
                                    <tr class="tr-head">
                                        <th class="th-content">Item OK </th>
                                        <th class="th-content">Item Selisih </th>
                                        <th class="th-content" style="width: 2cm">(+)</th>
                                        <th class="th-content" style="width: 2cm">(-)</th>
                                        <th class="th-content" style="width: 2cm">Beda Batch</th>
                                        <th class="th-content" style="width: 2cm">Tertukar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="tr-rekapitulasi-global">
                                        <td class="td-content"><?php echo e($dataRekapitulasi->total_item); ?></td>
                                        <td class="td-content"><?php echo e($dataRekapitulasi->item_tidak_ada); ?></td>
                                        <td class="td-content"><?php echo e($dataCso->csomaterial); ?></td>
                                        <td class="td-content" rowspan="3"><?php echo e($dataRekapitulasi->item_ada); ?></td>
                                        <td class="td-content"><?php echo e($dataRekapitulasi->item_ok); ?></td>
                                        <td class="td-content"><?php echo e($dataRekapitulasi->item_selisih); ?></td>
                                        <td class="td-content">
                                            <?php echo e(($dataRekapitulasi->item_ok / $dataRekapitulasi->item_ada) * 100); ?>%</td>
                                        <td class="td-content"><?php echo e($dataRekapitulasi->item_selisih_plus); ?></td>
                                        <td class="td-content"><?php echo e($dataRekapitulasi->item_selisih_minus); ?></td>
                                        <td class="td-content"><?php echo e($dataRekapitulasi->beda_batch); ?></td>
                                        <td class="td-content"><?php echo e($dataRekapitulasi->tertukar); ?></td>
                                        <td class="td-content">
                                            <?php echo e(($dataRekapitulasi->item_selisih / $dataRekapitulasi->item_ada) * 100); ?>%
                                        </td>
                                    </tr>
                                    <tr class="tr-rekapitulasi-global">
                                        <td class="td-content" colspan="3" style="font-weight: bold">Selisih Karena
                                            Admin</td>
                                        <td class="td-content"><?php echo e($dataRekapitulasi->kesalahan_admin_ok); ?></td>
                                        <td class="td-content"><?php echo e($dataRekapitulasi->kesalahan_admin_selisih); ?></td>
                                        <td class="td-content">
                                            <?php echo e(($dataRekapitulasi->kesalahan_admin_ok / $dataRekapitulasi->item_ada) * 100); ?>%
                                        </td>
                                        <td class="td-content" colspan="4"
                                            style="background-color: rgb(192, 192, 192)"></td>
                                        <td class="td-content">
                                            <?php echo e(($dataRekapitulasi->kesalahan_admin_selisih / $dataRekapitulasi->item_ada) * 100); ?>%
                                        </td>
                                    </tr>
                                    <tr class="tr-rekapitulasi-global">
                                        <td class="td-content" colspan="3" style="font-weight: bold">Selisih Karena
                                            Gudang</td>
                                        <td class="td-content"><?php echo e($dataRekapitulasi->faktor_gudang_ok); ?></td>
                                        <td class="td-content"><?php echo e($dataRekapitulasi->faktor_gudang_selisih); ?></td>
                                        <td class="td-content">
                                            <?php echo e(($dataRekapitulasi->faktor_gudang_ok / $dataRekapitulasi->item_ada) * 100); ?>%
                                        </td>
                                        <td class="td-content" colspan="4"
                                            style="background-color: rgb(192, 192, 192)"></td>
                                        <td class="td-content">
                                            <?php echo e(($dataRekapitulasi->faktor_gudang_selisih / $dataRekapitulasi->item_ada) * 100); ?>%
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top: 1cm">
                            <h4>
                                IV. LIST ITEM BARANG YANG SELISIH
                            </h4>

                            <table style=" border-collapse: collapse;width: 100%;">
                                <tbody>
                                    <tr class="tr-head">
                                        <th class="th-content" rowspan="2" style="width: 0.5cm">No</th>
                                        <th class="th-content" rowspan="2" style="width: 3cm">Nama Item</th>
                                        <th class="th-content" rowspan="2" style="width: 1cm">Keputusan</th>
                                        <th class="th-content" rowspan="2" style="width: 1cm">SLS <br> LBR</th>
                                        <th class="th-content" rowspan="2" style="width: 1cm">Realita <br> LBR</th>
                                        <th class="th-content" colspan="2" style="width: 1.75cm">Barang Selisih</th>
                                        <th class="th-content" rowspan="2" style="width: 3cm">HPP</th>
                                        <th class="th-content" colspan="2">Nominal</th>
                                        <th class="th-content" rowspan="2" style="width: 2.25cm">Nominal <br>
                                            Pembebanan</th>
                                        <th class="th-content" rowspan="2" style="width: 2.25cm">No. Adjust <br>
                                            (GI/SJ & GR)</th>
                                        <th class="th-content" rowspan="2" style="width: 2.5cm">Keterangan</th>
                                    </tr>
                                    <tr class="tr-head">
                                        <th class="th-content" style="width:0.5cm">Plus</th>
                                        <th class="th-content" style="width:0.5cm">Minus</th>
                                        <th class="th-content" style="width: 2cm">Selisih Plus</th>
                                        <th class="th-content" style="width: 2.25cm">Selisih Minus</th>
                                    </tr>
                                    <tr>
                                        <td colspan="13" class="tr-body-divider">
                                            Kesalahan Admin
                                        </td>
                                        <?php $__currentLoopData = $dataItemKesalahanAdmin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $itemKesalahanAdmin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="tr-selisih">
                                        <td class="td-content" style="text-align: center"><?php echo e($index + 1); ?></td>
                                        <td class="td-content" style="padding-left: 5px">
                                            <?php echo e($itemKesalahanAdmin->itemname); ?></td>
                                        <td class="td-content" style="text-align: center">
                                            <?php if($itemKesalahanAdmin->keputusan != 0): ?>
                                                <?php echo e($itemKesalahanAdmin->keputusandesc); ?>

                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td class="td-content" style="text-align: center">
                                            <?php echo e(number_format($itemKesalahanAdmin->onhand, 2, ',', '.')); ?></td>
                                        <td class="td-content" style="text-align: center">
                                            <?php echo e(number_format($itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi, 2, ',', '.')); ?>

                                        </td>
                                        <td class="td-content" style="text-align: center">
                                            <?php if(
                                                $itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi >
                                                    $itemKesalahanAdmin->onhand): ?>
                                                <?php echo e(number_format($itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi - $itemKesalahanAdmin->onhand, 2, ',', '.')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: center" class="td-selisih-minus">
                                            <?php if(
                                                $itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi <
                                                    $itemKesalahanAdmin->onhand): ?>
                                                <?php echo e(number_format($itemKesalahanAdmin->onhand - ($itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi), 2, ',', '.')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td class="td-content" style="text-align: center">Rp.
                                            <?php if($itemKesalahanAdmin->hpp_manual == null): ?>
                                                <?php echo e(number_format($itemKesalahanAdmin->hpp, 2, ',', '.')); ?>

                                            <?php else: ?>
                                                <?php echo e(number_format($itemKesalahanAdmin->hpp_manual, 2, ',', '.')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td class="td-content" style="text-align: center">
                                            <?php if(
                                                $itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi >
                                                    $itemKesalahanAdmin->onhand): ?>
                                                <?php if($itemKesalahanAdmin->hpp_manual == null): ?>
                                                    <?php echo e(number_format(($itemKesalahanAdmin->onhand - ($itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi)) * $itemKesalahanAdmin->hpp, 2, ',', '.')); ?>

                                                <?php else: ?>
                                                    <?php echo e(number_format(($itemKesalahanAdmin->onhand - ($itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi)) * $itemKesalahanAdmin->hpp_manual, 2, ',', '.')); ?>

                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: center" class="td-selisih-minus">
                                            <?php if(
                                                $itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi <
                                                    $itemKesalahanAdmin->onhand): ?>
                                                Rp.
                                                <?php if($itemKesalahanAdmin->hpp_manual == null): ?>
                                                    <?php echo e(number_format(($itemKesalahanAdmin->onhand - ($itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi)) * $itemKesalahanAdmin->hpp, 2, ',', '.')); ?>

                                                <?php else: ?>
                                                    <?php echo e(number_format(($itemKesalahanAdmin->onhand - ($itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi)) * $itemKesalahanAdmin->hpp_manual, 2, ',', '.')); ?>

                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="td-content" style="text-align: center">Rp.
                                            <?php echo e(number_format($itemKesalahanAdmin->pembebanan, 2, ',', '.')); ?></td>
                                        <td class="td-content" style="text-align: center">
                                            <?php echo e($itemKesalahanAdmin->nodoc); ?></td>
                                        <td class="td-content" style="text-align: center">
                                            <?php echo e($itemKesalahanAdmin->keterangan); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                    <tr class="tr-head">
                                        <th class="th-content" rowspan="2" style="width: 0.5cm">No</th>
                                        <th class="th-content" rowspan="2" style="width: 3cm">Nama Item</th>
                                        <th class="th-content" rowspan="2" style="width: 1cm">Keputusan</th>
                                        <th class="th-content" rowspan="2" style="width: 1cm">SLS <br> LBR</th>
                                        <th class="th-content" rowspan="2" style="width: 1cm">Realita <br> LBR</th>
                                        <th class="th-content" colspan="2" style="width: 1.75cm">Barang Selisih</th>
                                        <th class="th-content" rowspan="2" style="width: 3cm">HPP</th>
                                        <th class="th-content" colspan="2">Nominal</th>
                                        <th class="th-content" rowspan="2" style="width: 2.25cm">Nominal <br>
                                            Pembebanan</th>
                                        <th class="th-content" rowspan="2" style="width: 2.25cm">No. Adjust <br>
                                            (GI/SJ & GR)</th>
                                        <th class="th-content" rowspan="2" style="width: 2.5cm">Keterangan</th>
                                    </tr>
                                    <tr class="tr-head">
                                        <th class="th-content" style="width:0.5cm">Plus</th>
                                        <th class="th-content" style="width:0.5cm">Minus</th>
                                        <th class="th-content" style="width: 2cm">Selisih Plus</th>
                                        <th class="th-content" style="width: 2.25cm">Selisih Minus</th>
                                    </tr>
                                    <tr>
                                        <td colspan="13" class="tr-body-divider">
                                            Item Tertukar
                                        </td>
                                        <?php $__currentLoopData = $dataItemTertukar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $itemTertukar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="tr-selisih">
                                        <td class="td-content" style="text-align: center"><?php echo e($index + 1); ?></td>
                                        <td class="td-content" style="padding-left: 5px"><?php echo e($itemTertukar->itemname); ?>

                                        </td>
                                        <td class="td-content" style="text-align: center">
                                            <?php if($itemTertukar->keputusan != 0): ?>
                                                <?php echo e($itemTertukar->keputusandesc); ?>

                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td class="td-content" style="text-align: center">
                                            <?php echo e(number_format($itemTertukar->onhand, 2, ',', '.')); ?>

                                        </td>
                                        <td class="td-content" style="text-align: center">
                                            <?php echo e(number_format($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi, 2, ',', '.')); ?>

                                        </td>
                                        <td class="td-content" style="text-align: center">
                                            <?php if($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi > $itemTertukar->onhand): ?>
                                                <?php echo e(number_format($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi - $itemTertukar->onhand, 2, ',', '.')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: center" class="td-selisih-minus">
                                            <?php if($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi < $itemTertukar->onhand): ?>
                                                <?php echo e(number_format($itemTertukar->onhand - ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi), 2, ',', '.')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td class="td-content" style="text-align: center">Rp.
                                            <?php if($itemTertukar->hpp_manual == null): ?>
                                                <?php echo e(number_format($itemTertukar->hpp, 2, ',', '.')); ?>

                                            <?php else: ?>
                                                <?php echo e(number_format($itemTertukar->hpp_manual, 2, ',', '.')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td class="td-content" style="text-align: center">
                                            <?php if($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi > $itemTertukar->onhand): ?>
                                                Rp.
                                                <?php if($itemTertukar->hpp_manual == null): ?>
                                                    <?php echo e(number_format(($itemTertukar->onhand - ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi)) * $itemTertukar->hpp, 2, ',', '.')); ?>

                                                <?php else: ?>
                                                    <?php echo e(number_format(($itemTertukar->onhand - ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi)) * $itemTertukar->hpp_manual, 2, ',', '.')); ?>

                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: center" class="td-selisih-minus">
                                            <?php if($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi < $itemTertukar->onhand): ?>
                                                Rp.
                                                <?php if($itemTertukar->hpp_manual == null): ?>
                                                    <?php echo e(number_format(($itemTertukar->onhand - ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi)) * $itemTertukar->hpp, 2, ',', '.')); ?>

                                                <?php else: ?>
                                                    <?php echo e(number_format(($itemTertukar->onhand - ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi)) * $itemTertukar->hpp_manual, 2, ',', '.')); ?>

                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="td-content" style="text-align: center"> Rp.
                                            <?php echo e(number_format($itemTertukar->pembebanan, 2, ',', '.')); ?></td>
                                        <td class="td-content" style="text-align: center"><?php echo e($itemTertukar->nodoc); ?></td>
                                        <td class="td-content" style="text-align: center"><?php echo e($itemTertukar->keterangan); ?>

                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                    <tr class="tr-head">
                                        <th class="th-content" rowspan="2" style="width: 0.5cm">No</th>
                                        <th class="th-content" rowspan="2" style="width: 3cm">Nama Item</th>
                                        <th class="th-content" rowspan="2" style="width: 1cm">Keputusan</th>
                                        <th class="th-content" rowspan="2" style="width: 1cm">SLS <br> LBR</th>
                                        <th class="th-content" rowspan="2" style="width: 1cm">Realita <br> LBR</th>
                                        <th class="th-content" colspan="2" style="width: 1.75cm">Barang Selisih</th>
                                        <th class="th-content" rowspan="2" style="width: 3cm">HPP</th>
                                        <th class="th-content" colspan="2">Nominal</th>
                                        <th class="th-content" rowspan="2" style="width: 2.25cm">Nominal <br>
                                            Pembebanan</th>
                                        <th class="th-content" rowspan="2" style="width: 2.25cm">No. Adjust <br>
                                            (GI/SJ & GR)</th>
                                        <th class="th-content" rowspan="2" style="width: 2.5cm">Keterangan</th>
                                    </tr>
                                    <tr class="tr-head">
                                        <th class="th-content" style="width:0.5cm">Plus</th>
                                        <th class="th-content" style="width:0.5cm">Minus</th>
                                        <th class="th-content" style="width: 2cm">Selisih Plus</th>
                                        <th class="th-content" style="width: 2.25cm">Selisih Minus</th>
                                    </tr>
                                    <tr>
                                        <td colspan="13" class="tr-body-divider">
                                            Item Selisih Plus Minus
                                        </td>
                                    </tr>
                                    <?php $__currentLoopData = $dataItemSelisih; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $itemSelisih): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="tr-selisih">
                                            <td class="td-content" style="text-align: center"><?php echo e($index + 1); ?></td>
                                            <td class="td-content" style="padding-left: 5px"><?php echo e($itemSelisih->itemname); ?>

                                            </td>
                                            <td class="td-content" style="text-align: center">
                                                <?php if($itemSelisih->keputusan != 0): ?>
                                                    <?php echo e($itemSelisih->keputusandesc); ?>

                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td class="td-content" style="text-align: center">
                                                <?php echo e(number_format($itemSelisih->onhand, 2, ',', '.')); ?>

                                            </td>
                                            <td class="td-content" style="text-align: center">
                                                <?php echo e(number_format($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi, 2, ',', '.')); ?>

                                            </td>
                                            <td class="td-content" style="text-align: center">
                                                <?php if($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi > $itemSelisih->onhand): ?>
                                                    <?php echo e(number_format($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi - $itemSelisih->onhand, 2, ',', '.')); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td style="text-align: center" class="td-selisih-minus">
                                                <?php if($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi < $itemSelisih->onhand): ?>
                                                    <?php echo e(number_format($itemSelisih->onhand - ($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi), 2, ',', '.')); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td class="td-content" style="text-align: center">Rp.
                                                <?php if($itemSelisih->hpp_manual == null): ?>
                                                    <?php echo e(number_format($itemSelisih->hpp, 2, ',', '.')); ?>

                                                <?php else: ?>
                                                    <?php echo e(number_format($itemSelisih->hpp_manual, 2, ',', '.')); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td class="td-content" style="text-align: center">
                                                <?php if($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi > $itemSelisih->onhand): ?>
                                                    Rp.
                                                    <?php if($itemTertukar->hpp_manual == null): ?>
                                                        <?php echo e(number_format(($itemTertukar->onhand - ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi)) * $itemTertukar->hpp, 2, ',', '.')); ?>

                                                    <?php else: ?>
                                                        <?php echo e(number_format(($itemTertukar->onhand - ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi)) * $itemTertukar->hpp_manual, 2, ',', '.')); ?>

                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td style="text-align: center" class="td-selisih-minus">
                                                <?php if($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi < $itemSelisih->onhand): ?>
                                                    Rp.
                                                    <?php if($itemSelisih->hpp_manual == null): ?>
                                                        <?php echo e(number_format(($itemSelisih->onhand - ($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi)) * $itemSelisih->hpp, 2, ',', '.')); ?>

                                                    <?php else: ?>
                                                        <?php echo e(number_format(($itemSelisih->onhand - ($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi)) * $itemSelisih->hpp_manual, 2, ',', '.')); ?>

                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td class="td-content" style="text-align: center">Rp.
                                                <?php echo e(number_format($itemSelisih->pembebanan, 2, ',', '.')); ?></td>
                                            <td class="td-content" style="text-align: center"><?php echo e($itemSelisih->nodoc); ?>

                                            </td>
                                            <td class="td-content" style="text-align: center">
                                                <?php echo e($itemSelisih->keterangan); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if(substr($dataCso->doccsoid, 0, 3) == 'CSO'): ?>
                            <div style="margin-top: 1cm">
                                <h4>
                                    V. History CSO 3 bulan terakhir
                                </h4>
                                <table>
                                    <thead>
                                        <tr class="tr-head">
                                            <th class="th-content" style="width: 2.5cm">Bulan</th>
                                            <th class="th-content" style="width: 3.5cm">Item</th>
                                            <th class="th-content" style="width: 1.5cm">Jumlah Item <br> yang di CSO</th>
                                            <th class="th-content" style="width: 1.5cm">Jumlah Item <br> sesuai</th>
                                            <th class="th-content" style="width: 1cm">Persentase</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $data3BulanTerakhir; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr style="font-size: 9pt;text-align: center;">
                                                <td class="td-content">
                                                    <?php switch($data->monthstart):
                                                        case (1): ?>
                                                            Januari
                                                        <?php break; ?>

                                                        <?php case (2): ?>
                                                            Februari
                                                        <?php break; ?>

                                                        <?php case (3): ?>
                                                            Maret
                                                        <?php break; ?>

                                                        <?php case (4): ?>
                                                            April
                                                        <?php break; ?>

                                                        <?php case (5): ?>
                                                            Mei
                                                        <?php break; ?>

                                                        <?php case (6): ?>
                                                            Juni
                                                        <?php break; ?>

                                                        <?php case (7): ?>
                                                            Juli
                                                        <?php break; ?>

                                                        <?php case (8): ?>
                                                            Agustur
                                                        <?php break; ?>

                                                        <?php case (9): ?>
                                                            September
                                                        <?php break; ?>

                                                        <?php case (10): ?>
                                                            Oktober
                                                        <?php break; ?>

                                                        <?php case (11): ?>
                                                            November
                                                        <?php break; ?>

                                                        <?php case (12): ?>
                                                            Desember
                                                        <?php break; ?>
                                                    <?php endswitch; ?>
                                                </td>
                                                <td class="td-content">
                                                    <?php echo e($data->csomaterial); ?>

                                                </td>
                                                <td class="td-content"><?php echo e($data->item_ok); ?></td>
                                                <td class="td-content"><?php echo e($data->item_ada); ?></td>
                                                <td class="td-content">
                                                    <?php echo e(round(($data->item_ada / $data->item_ok) * 100, 2)); ?>%</td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/sos-dev/resources/views/admin/report/preview-avalan/preview-resume.blade.php ENDPATH**/ ?>