<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resume Avalan</title>
    <style>
        .title-info {
            padding-top: 25px;
        }

        th {
            text-align: center;
            border: 1px solid;
            padding-left: 1px;
            padding-right: 1px;
            line-height: 1.75;
            vertical-align: middle;
        }





        .th-persetujuan {
            font-size: 9pt;
        }

        .th-pic-cso {
            font-size: 9pt;
            border-color: rgb(65, 65, 65);
        }

        .th-rekapitulasi-global {
            font-size: 6pt;
            border-color: rgb(65, 65, 65);
        }

        .th-history {
            font-size: 9pt;
            border-color: rgb(65, 65, 65);
        }

        .th-item-selisih {
            font-size: 6pt;
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
            height: 0.5cm;
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
            font-size:10pt;
            background-color: rgb(233, 233, 233)
        }

        .tr-body:nth-child(even) {
            font-size: 10pt;
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
            font-size: 8pt;
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
</head>

<body>
    <h2 style="text-align: center">
        LAPORAN HASIL PELAKSANAAN CEK STOK
    </h2>

    <div>
        <h4>
            I. PELAKSANAAN CEK STOK
        </h4>
        <p>Nama perusahaan : PT. Sutindo Raya Mulia Surabaya</p>
        <p>Tanggal pelaksanaan cek stok : {{ \Carbon\Carbon::parse($dataCso->startcsodate)->translatedFormat('j F Y') }}
        </p>
        <p>Lokasi/kelompok produk yang di cek stok : {{ $dataCso->csomaterial }} </p>
    </div>
    <div>
        <h4>
            II. SUSUNAN TIM CEK STOK OPNAME
        </h4>
        <p>PIC CSO: </p>
        <h5>Analistor</h5>
        <table>
            <thead>
                <tr class="tr-head">
                    <th class="th-pic-cso" style="width: 5%">No</th>
                    <th class="th-pic-cso" style="width: 20%">Nama Analisator</th>
                    <th class="th-pic-cso" style="width: 15%">Departemen</th>
                    <th class="th-pic-cso" style="width: 60%">Catatan tentang Analisator</th>
                </tr>
            </thead>
            <tbody>
                @if (count($dataAnalisator) > 0)
                    @foreach ($dataAnalisator as $index => $analisator)
                        <tr class="tr-body">
                            <td class="td-content" style="padding: 8px">{{ $index + 1 }}</td>
                            <td class="td-content" style="padding: 8px">{{ $analisator->name }}</td>
                            <td class="td-content" style="padding: 8px">{{ $analisator->dept }}</td>
                            <td class="td-content" style="padding: 8px">{{ $analisator->note }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr class="tr-body">
                        <th class="td-content"></th>
                        <td class="td-content" style="padding: 8px"></td>
                        <td class="td-content" style="padding: 8px"></td>
                        <td class="td-content" style="padding: 8px"></td>
                    </tr>
                @endif

            </tbody>
        </table>
        <h5>Pelaku</h5>
        <table>
            <thead>
                <tr class="tr-head">
                    <th class="th-pic-cso" style="width: 5%">No</th>
                    <th class="th-pic-cso" style="width: 20%">Nama Pelaku</th>
                    <th class="th-pic-cso" style="width: 15%">Departemen</th>
                    <th class="th-pic-cso" style="width: 60%">Catatan tentang Pelaku</th>
                </tr>
            </thead>
            <tbody>
                @if (count($dataPelaku) > 0)
                    @foreach ($dataPelaku as $index => $pelaku)
                        <tr class="tr-body">
                            <td class="td-content" style="padding: 8px">{{ $index + 1 }}</td>
                            <td class="td-content" style="padding: 8px;">{{ $pelaku->name }}</td>
                            <td class="td-content" style="padding: 8px">{{ $pelaku->dept }}</td>
                            <td class="td-content" style="padding: 8px">{{ $pelaku->note }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr class="tr-body">
                        <th class="td-content" ></th>
                        <td class="td-content" style="padding: 8px"></td>
                        <td class="td-content" style="padding: 8px"></td>
                        <td class="td-content" style="padding: 8px"></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div style="margin-top: 20px">
        <h4>
            III. REKAPITULASI HASIL CSO GLOBAL
        </h4>
        <table style=" border-collapse: collapse;width: 100%;" class="table">
            <thead>
                <tr class="tr-head" style="page-break-after: avoid;">
                    <th class="th-rekapitulasi-global" rowspan="2" style="width: 1cm">Total Item </th>
                    <th class="th-rekapitulasi-global" rowspan="2" style="width: 1cm">Item yang tidak ada fisik</th>
                    <th class="th-rekapitulasi-global" rowspan="2" style="width: 1cm">Area / Kelompok produk </th>
                    <th class="th-rekapitulasi-global" rowspan="2" style="width: 1cm">Item yang sudah dicek stok ada
                    </th>
                    <th class="th-rekapitulasi-global" colspan="2" style="width: 1cm">Hasil CSO</th>
                    <th class="th-rekapitulasi-global" rowspan="2" style="width: 1cm">% Keakuratan Stok</th>
                    <th class="th-rekapitulasi-global" colspan="4" style="width: 1cm">% Item Selisih</th>
                    <th class="th-rekapitulasi-global" rowspan="2" style="width: 1cm">% Selisih</th>
                </tr>
                <tr class="tr-head">
                    <th class="th-rekapitulasi-global" style="width: 0.5cm">Item OK </th>
                    <th class="th-rekapitulasi-global" style="width: 0.5cm">Item Selisih </th>
                    <th class="th-rekapitulasi-global" style="width: 0.5cm">(+)</th>
                    <th class="th-rekapitulasi-global" style="width: 0.5cm">(-)</th>
                    <th class="th-rekapitulasi-global" style="width: 0.5cm">Beda Batch</th>
                    <th class="th-rekapitulasi-global" style="width: 0.5cm">Tertukar</th>
                </tr>
            </thead>
            <tbody>
                <tr class="tr-rekapitulasi-global">
                    <td class="td-content">{{ $dataRekapitulasi->total_item }}</td>
                    <td class="td-content">{{ $dataRekapitulasi->item_tidak_ada }}</td>
                    <td class="td-content">{{ $dataCso->csomaterial }}</td>
                    <td class="td-content" rowspan="3">{{ $dataRekapitulasi->item_ada }}</td>
                    <td class="td-content">{{ $dataRekapitulasi->item_ok }}</td>
                    <td class="td-content">{{ $dataRekapitulasi->item_selisih }}</td>
                    <td class="td-content">{{ ($dataRekapitulasi->item_ok / $dataRekapitulasi->item_ada) * 100 }}%
                    </td>
                    <td class="td-content">{{ $dataRekapitulasi->item_selisih_plus }}</td>
                    <td class="td-content">{{ $dataRekapitulasi->item_selisih_minus }}</td>
                    <td class="td-content">{{ $dataRekapitulasi->beda_batch }}</td>
                    <td class="td-content">{{ $dataRekapitulasi->tertukar }}</td>
                    <td class="td-content">
                        {{ ($dataRekapitulasi->item_selisih / $dataRekapitulasi->item_ada) * 100 }}%
                    </td>
                </tr>
                <tr class="tr-rekapitulasi-global">
                    <td class="td-content" colspan="3" style="font-weight: bold">Selisih Karena Admin</td>
                    <td class="td-content">{{ $dataRekapitulasi->kesalahan_admin_ok }}</td>
                    <td class="td-content">{{ $dataRekapitulasi->kesalahan_admin_selisih }}</td>
                    <td class="td-content">
                        {{ ($dataRekapitulasi->kesalahan_admin_ok / $dataRekapitulasi->item_ada) * 100 }}%</td>
                    <td class="td-content" colspan="4" style="background-color: rgb(192, 192, 192)"></td>
                    <td class="td-content">
                        {{ ($dataRekapitulasi->kesalahan_admin_selisih / $dataRekapitulasi->item_ada) * 100 }}%</td>
                </tr>
                <tr class="tr-rekapitulasi-global">
                    <td class="td-content" colspan="3" style="font-weight: bold">Selisih Karena Gudang</td>
                    <td class="td-content">{{ $dataRekapitulasi->faktor_gudang_ok }}</td>
                    <td class="td-content">{{ $dataRekapitulasi->faktor_gudang_selisih }}</td>
                    <td class="td-content">
                        {{ ($dataRekapitulasi->faktor_gudang_ok / $dataRekapitulasi->item_ada) * 100 }}%</td>
                    <td class="td-content" colspan="4" style="background-color: rgb(192, 192, 192)"></td>
                    <td class="td-content">
                        {{ ($dataRekapitulasi->faktor_gudang_selisih / $dataRekapitulasi->item_ada) * 100 }}%</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="margin-top: 20px">
        <h4>
            IV. LIST ITEM BARANG YANG SELISIH
        </h4>

        <table style=" border-collapse: collapse;width: 100%;">
            <tbody>
                <tr class="tr-head" style="page-break-after: avoid;">
                    <th class="th-item-selisih" rowspan="2" style="width: 0.5cm">No</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 1.5cm">Nama Item</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 0.75cm">Keputusan</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 0.75cm">SLS <br> LBR</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 0.75cm">Realita <br> LBR</th>
                    <th class="th-item-selisih" colspan="2" style="width: 1.75cm">Barang Selisih</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 2cm">HPP</th>
                    <th class="th-item-selisih" colspan="2" style="page-break-inside: avoid;">Nominal</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 2cm">Nominal <br>
                        Pembebanan</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 1cm">No. Adjust <br>
                        (GI/SJ & GR)</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 1.75cm">Keterangan</th>
                </tr>
                <tr class="tr-head" style="page-break-after: avoid;">
                    <th class="th-item-selisih" style="width:0.5cm">Plus</th>
                    <th class="th-item-selisih" style="width:0.5cm">Minus</th>
                    <th class="th-item-selisih" style="width: 1.25cm">Selisih Plus</th>
                    <th class="th-item-selisih" style="width: 1.25cm">Selisih Minus</th>
                </tr>
                <tr>
                    <td colspan="13" class="tr-body-divider">
                        Kesalahan Admin
                    </td>
                </tr>
                @foreach ($dataItemKesalahanAdmin as $index => $itemKesalahanAdmin)
                    <tr class="tr-selisih">
                        <td class="td-content" style="text-align: center">{{ $index + 1 }}</td>
                        <td class="td-content" style="padding-left: 5px">
                            {{ $itemKesalahanAdmin->itemname }}</td>
                        <td class="td-content" style="text-align: center">
                            @if ($itemKesalahanAdmin->keputusan != 0)
                                {{ $itemKesalahanAdmin->keputusandesc }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="td-content" style="text-align: center">
                            {{ number_format($itemKesalahanAdmin->onhand, 2, ',', '.') }}</td>
                        <td class="td-content" style="text-align: center">
                            {{ number_format($itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi, 2, ',', '.') }}
                        </td>
                        <td class="td-content" style="text-align: center">
                            @if (
                                $itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi >
                                    $itemKesalahanAdmin->onhand)
                                {{ number_format($itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi - $itemKesalahanAdmin->onhand, 2, ',', '.') }}
                            @endif
                        </td>
                        <td style="text-align: center" class="td-selisih-minus">
                            @if (
                                $itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi <
                                    $itemKesalahanAdmin->onhand)
                                {{ number_format($itemKesalahanAdmin->onhand - ($itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi), 2, ',', '.') }}
                            @endif
                        </td>
                        <td class="td-content" style="text-align: center">Rp.
                            @if ($itemKesalahanAdmin->hpp_manual == null)
                                {{ number_format($itemKesalahanAdmin->hpp, 2, ',', '.') }}
                            @else
                                {{ number_format($itemKesalahanAdmin->hpp_manual, 2, ',', '.') }}
                            @endif
                        </td>
                        <td class="td-content" style="text-align: center">
                            @if (
                                $itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi >
                                    $itemKesalahanAdmin->onhand)
                                @if ($itemKesalahanAdmin->hpp_manual == null)
                                    {{ number_format(($itemKesalahanAdmin->onhand - ($itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi)) * $itemKesalahanAdmin->hpp, 2, ',', '.') }}
                                @else
                                    {{ number_format(($itemKesalahanAdmin->onhand - ($itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi)) * $itemKesalahanAdmin->hpp_manual, 2, ',', '.') }}
                                @endif
                            @endif
                        </td>
                        <td style="text-align: center" class="td-selisih-minus">
                            @if (
                                $itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi <
                                    $itemKesalahanAdmin->onhand)
                                Rp.
                                @if ($itemKesalahanAdmin->hpp_manual == null)
                                    {{ number_format(($itemKesalahanAdmin->onhand - ($itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi)) * $itemKesalahanAdmin->hpp, 2, ',', '.') }}
                                @else
                                    {{ number_format(($itemKesalahanAdmin->onhand - ($itemKesalahanAdmin->hasilcso + $itemKesalahanAdmin->koreksi + $itemKesalahanAdmin->deviasi)) * $itemKesalahanAdmin->hpp_manual, 2, ',', '.') }}
                                @endif
                            @endif
                        </td>
                        <td class="td-content" style="text-align: center">Rp.
                            {{ number_format($itemKesalahanAdmin->pembebanan, 2, ',', '.') }}</td>
                        <td class="td-content" style="text-align: center">
                            {{ $itemKesalahanAdmin->nodoc }}</td>
                        <td class="td-content" style="text-align: center">
                            {{ $itemKesalahanAdmin->keterangan }}</td>
                    </tr>
                @endforeach
                <tr class="tr-head" style="page-break-after: avoid;">
                    <th class="th-item-selisih" rowspan="2" style="width: 0.5cm">No</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 1.5cm">Nama Item</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 0.75cm">Keputusan</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 0.75cm">SLS <br> LBR</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 0.75cm">Realita <br> LBR</th>
                    <th class="th-item-selisih" colspan="2" style="width: 1.75cm">Barang Selisih</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 2cm">HPP</th>
                    <th class="th-item-selisih" colspan="2">Nominal</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 2cm">Nominal <br>
                        Pembebanan</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 1cm">No. Adjust <br>
                        (GI/SJ & GR)</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 1.75cm">Keterangan</th>
                </tr>
                <tr class="tr-head" style="page-break-after: avoid;">
                    <th class="th-item-selisih" style="width:0.5cm">Plus</th>
                    <th class="th-item-selisih" style="width:0.5cm">Minus</th>
                    <th class="th-item-selisih" style="width: 1.25cm">Selisih Plus</th>
                    <th class="th-item-selisih" style="width: 1.25cm">Selisih Minus</th>
                </tr>
                <tr>
                    <td colspan="13" class="tr-body-divider">
                        Item Tertukar
                    </td>
                </tr>
                @foreach ($dataItemTertukar as $index => $itemTertukar)
                    <tr class="tr-selisih">
                        <td class="td-content" style="text-align: center">{{ $index + 1 }}</td>
                        <td class="td-content" style="padding-left: 5px">{{ $itemTertukar->itemname }}
                        </td>
                        <td class="td-content" style="text-align: center">
                            @if ($itemTertukar->keputusan != 0)
                                {{ $itemTertukar->keputusandesc }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="td-content" style="text-align: center">
                            {{ number_format($itemTertukar->onhand, 2, ',', '.') }}
                        </td>
                        <td class="td-content" style="text-align: center">
                            {{ number_format($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi, 2, ',', '.') }}
                        </td>
                        <td class="td-content" style="text-align: center">
                            @if ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi > $itemTertukar->onhand)
                                {{ number_format($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi - $itemTertukar->onhand, 2, ',', '.') }}
                            @endif
                        </td>
                        <td style="text-align: center" class="td-selisih-minus">
                            @if ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi < $itemTertukar->onhand)
                                {{ number_format($itemTertukar->onhand - ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi), 2, ',', '.') }}
                            @endif
                        </td>
                        <td class="td-content" style="text-align: center">Rp.
                            @if ($itemTertukar->hpp_manual == null)
                                {{ number_format($itemTertukar->hpp, 2, ',', '.') }}
                            @else
                                {{ number_format($itemTertukar->hpp_manual, 2, ',', '.') }}
                            @endif
                        </td>
                        <td class="td-content" style="text-align: center">
                            @if ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi > $itemTertukar->onhand)
                                Rp.
                                @if ($itemTertukar->hpp_manual == null)
                                    {{ number_format(($itemTertukar->onhand - ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi)) * $itemTertukar->hpp, 2, ',', '.') }}
                                @else
                                    {{ number_format(($itemTertukar->onhand - ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi)) * $itemTertukar->hpp_manual, 2, ',', '.') }}
                                @endif
                            @endif
                        </td>
                        <td style="text-align: center" class="td-selisih-minus">
                            @if ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi < $itemTertukar->onhand)
                                Rp.
                                @if ($itemTertukar->hpp_manual == null)
                                    {{ number_format(($itemTertukar->onhand - ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi)) * $itemTertukar->hpp, 2, ',', '.') }}
                                @else
                                    {{ number_format(($itemTertukar->onhand - ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi)) * $itemTertukar->hpp_manual, 2, ',', '.') }}
                                @endif
                            @endif
                        </td>
                        <td class="td-content" style="text-align: center"> Rp.
                            {{ number_format($itemTertukar->pembebanan, 2, ',', '.') }}</td>
                        <td class="td-content" style="text-align: center">{{ $itemTertukar->nodoc }}</td>
                        <td class="td-content" style="text-align: center">{{ $itemTertukar->keterangan }}
                        </td>
                    </tr>
                @endforeach

                <tr class="tr-head" style="page-break-after: avoid;">
                    <th class="th-item-selisih" rowspan="2" style="width: 0.5cm">No</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 1.5cm">Nama Item</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 0.75cm">Keputusan</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 0.75cm">SLS <br> LBR</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 0.75cm">Realita <br> LBR</th>
                    <th class="th-item-selisih" colspan="2" style="width: 1.75cm">Barang Selisih</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 2cm">HPP</th>
                    <th class="th-item-selisih" colspan="2">Nominal</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 2cm">Nominal <br>
                        Pembebanan</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 1cm">No. Adjust <br>
                        (GI/SJ & GR)</th>
                    <th class="th-item-selisih" rowspan="2" style="width: 1.75cm">Keterangan</th>
                </tr>
                <tr class="tr-head" style="page-break-after: avoid;">
                    <th class="th-item-selisih" style="width:0.5cm">Plus</th>
                    <th class="th-item-selisih" style="width:0.5cm">Minus</th>
                    <th class="th-item-selisih" style="width: 1.25cm">Selisih Plus</th>
                    <th class="th-item-selisih" style="width: 1.25cm">Selisih Minus</th>
                </tr>
                <tr>
                    <td colspan="13" class="tr-body-divider">
                        Item Selisih Plus Minus
                    </td>
                </tr>
                @foreach ($dataItemSelisih as $index => $itemSelisih)
                    <tr class="tr-selisih">
                        <td class="td-content" style="text-align: center">{{ $index + 1 }}</td>
                        <td class="td-content" style="padding-left: 5px">{{ $itemSelisih->itemname }}
                        </td>
                        <td class="td-content" style="text-align: center">
                            @if ($itemSelisih->keputusan != 0)
                                {{ $itemSelisih->keputusandesc }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="td-content" style="text-align: center">
                            {{ number_format($itemSelisih->onhand, 2, ',', '.') }}
                        </td>
                        <td class="td-content" style="text-align: center">
                            {{ number_format($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi, 2, ',', '.') }}
                        </td>
                        <td class="td-content" style="text-align: center">
                            @if ($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi > $itemSelisih->onhand)
                                {{ number_format($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi - $itemSelisih->onhand, 2, ',', '.') }}
                            @endif
                        </td>
                        <td style="text-align: center" class="td-selisih-minus">
                            @if ($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi < $itemSelisih->onhand)
                                {{ number_format($itemSelisih->onhand - ($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi), 2, ',', '.') }}
                            @endif
                        </td>
                        <td class="td-content" style="text-align: center">Rp.
                            @if ($itemSelisih->hpp_manual == null)
                                {{ number_format($itemSelisih->hpp, 2, ',', '.') }}
                            @else
                                {{ number_format($itemSelisih->hpp_manual, 2, ',', '.') }}
                            @endif
                        </td>
                        <td class="td-content" style="text-align: center">
                            @if ($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi > $itemSelisih->onhand)
                                Rp.
                                @if ($itemTertukar->hpp_manual == null)
                                    {{ number_format(($itemTertukar->onhand - ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi)) * $itemTertukar->hpp, 2, ',', '.') }}
                                @else
                                    {{ number_format(($itemTertukar->onhand - ($itemTertukar->hasilcso + $itemTertukar->koreksi + $itemTertukar->deviasi)) * $itemTertukar->hpp_manual, 2, ',', '.') }}
                                @endif
                            @endif
                        </td>
                        <td style="text-align: center" class="td-selisih-minus">
                            @if ($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi < $itemSelisih->onhand)
                                Rp.
                                @if ($itemSelisih->hpp_manual == null)
                                    {{ number_format(($itemSelisih->onhand - ($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi)) * $itemSelisih->hpp, 2, ',', '.') }}
                                @else
                                    {{ number_format(($itemSelisih->onhand - ($itemSelisih->hasilcso + $itemSelisih->koreksi + $itemSelisih->deviasi)) * $itemSelisih->hpp_manual, 2, ',', '.') }}
                                @endif
                            @endif
                        </td>
                        <td class="td-content" style="text-align: center">Rp.
                            {{ number_format($itemSelisih->pembebanan, 2, ',', '.') }}</td>
                        <td class="td-content" style="text-align: center">{{ $itemSelisih->nodoc }}
                        </td>
                        <td class="td-content" style="text-align: center">
                            {{ $itemSelisih->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 20px">
        <h4>
            V. History CSO 3 bulan terakhir
        </h4>
        <table>
            <thead>
                <tr class="tr-head">
                    <th class="th-history" style="width: 2.5cm">Bulan</th>
                    <th class="th-history" style="width: 3.5cm">Item</th>
                    <th class="th-history" style="width: 1.5cm">Jumlah Item <br> yang di CSO</th>
                    <th class="th-history" style="width: 1.5cm">Jumlah Item <br> sesuai</th>
                    <th class="th-history" style="width: 1cm">Persentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data3BulanTerakhir as $data)
                    <tr style="font-size: 9pt;text-align: center;">
                        <td class="td-content">
                            @switch($data->monthstart)
                                @case(1)
                                    Januari
                                @break

                                @case(2)
                                    Februari
                                @break

                                @case(3)
                                    Maret
                                @break

                                @case(4)
                                    April
                                @break

                                @case(5)
                                    Mei
                                @break

                                @case(6)
                                    Juni
                                @break

                                @case(7)
                                    Juli
                                @break

                                @case(8)
                                    Agustur
                                @break

                                @case(9)
                                    September
                                @break

                                @case(10)
                                    Oktober
                                @break

                                @case(11)
                                    November
                                @break

                                @case(12)
                                    Desember
                                @break
                            @endswitch
                        </td>
                        <td class="td-content">
                            {{ $data->csomaterial }}
                        </td>
                        <td class="td-content">{{ $data->item_ok }}</td>
                        <td class="td-content">{{ $data->item_ada }}</td>
                        <td class="td-content">{{ round(($data->item_ada / $data->item_ok) * 100, 2) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 4cm">
        <table style="page-break-inside: avoid;">
            <thead>
                <tr>
                    @if ($type == 1)
                        <th class="th-persetujuan">Dibuat Oleh</th>
                        <th colspan="2" class="th-persetujuan">Diperiksa Oleh</th>
                        <th colspan="2" class="th-persetujuan">Disetujui Oleh</th>
                        <th class="th-persetujuan">Diketahui Oleh</th>
                    @else
                        <th class="th-persetujuan">Dibuat Oleh</th>
                        <th class="th-persetujuan"></th>
                        <th class="th-persetujuan">Diperiksa Oleh</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if ($type == 1)
                    <tr>
                        <td style="height: 2cm"></td>
                        <td style="height: 2cm"></td>
                        <td style="height: 2cm"></td>
                        <td style="height: 2cm"></td>
                        <td style="height: 2cm"></td>
                        <td style="height: 2cm"></td>
                    </tr>
                    <tr>
                        <td class="td-persetujuan">Staff Stock Control</td>
                        <td class="td-persetujuan">Ka Fac</td>
                        <td class="td-persetujuan">Ka Purch</td>
                        <td class="td-persetujuan">Ka Ops</td>
                        <td class="td-persetujuan">Reg. Man.</td>
                        <td class="td-persetujuan">BOD</td>
                    </tr>
                @else
                    <tr>
                        <td style="height: 2cm"></td>
                        <td style="height: 2cm"></td>
                        <td style="height: 2cm"></td>
                    </tr>
                    <tr>
                        <td class="td-persetujuan">Staff Stock Control</td>
                        <td class="td-persetujuan">PIC Warehouse</td>
                        <td class="td-persetujuan">Ka Warehouse</td>
                    </tr>
                @endif


            </tbody>
        </table>
    </div>
</body>

</html>
