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
<h2>Item Yang Belum Dicek</h2>
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
        @if ($type == 1)
            
            @foreach ($itemBlmProses as $barang)
                <tr class="tr-body">
                    <td>{{ $barang->itemname }}</td>
                    <td class="td-non-itemname">{{ $barang->heatno }}</td>
                    <td class="td-non-itemname">{{ $barang->dimension }}</td>
                    <td class="td-non-itemname">{{ $barang->tolerance }}</td>
                    <td class="td-non-itemname">{{ $barang->kondisi }}</td>
                </tr>
            @endforeach
        @elseif ($type == 2)
            <h1>Item Yang Sedang Dicek</h1>
            @foreach ($itemSdgProses as $barang)
                <tr class="tr-body">
                    <td>{{ $barang->itemname }}</td>
                    <td class="td-non-itemname">{{ $barang->dimension }}</td>
                    <td class="td-non-itemname">{{ $barang->tolerance }}</td>
                    <td class="td-non-itemname">{{ $barang->selisih }}</td>
                    <td class="td-non-itemname">{{ $barang->onhand }}</td>
                    <td class="td-non-itemname">{{ $barang->totalcso }}</td>
                    <td class="td-non-itemname">{{ $barang->koreksi }}</td>
                    <td class="td-non-itemname">{{ $barang->deviasi }}</td>
                    <td class="td-non-itemname">{{ $barang->statuscso }}</td>
                    <td class="td-non-itemname">{{ $barang->groupid }}</td>
                    <td class="td-non-itemname">{{ $barang->analisator }}</td>
                </tr>
            @endforeach
        @elseif ($type == 3)
            <h1>Item Yang Sudah Dicek</h1>
            @foreach ($itemSelesai as $barang)
                <tr class="tr-body">
                    <td>{{ $barang->itemname }}</td>
                    <td class="td-non-itemname">{{ $barang->dimension }}</td>
                    <td class="td-non-itemname">{{ $barang->tolerance }}</td>
                    <td class="td-non-itemname">{{ $barang->selisih }}</td>
                    <td class="td-non-itemname">{{ $barang->onhand }}</td>
                    <td class="td-non-itemname">{{ $barang->totalcso }}</td>
                    <td class="td-non-itemname">{{ $barang->koreksi }}</td>
                    <td class="td-non-itemname">{{ $barang->deviasi }}</td>
                    <td class="td-non-itemname">{{ $barang->statuscso }}</td>
                    <td class="td-non-itemname">{{ $barang->groupid }}</td>
                    <td class="td-non-itemname">{{ $barang->analisator }}</td>
                </tr>
            @endforeach
        @elseif ($type == 4)
            <h1>Item Yang Mengalami Selisih</h1>
            @foreach ($itemSelisih as $barang)
                <tr class="tr-body">
                    <td>{{ $barang->itemname }}</td>
                    <td class="td-non-itemname">{{ $barang->dimension }}</td>
                    <td class="td-non-itemname">{{ $barang->tolerance }}</td>
                    <td class="td-non-itemname">{{ $barang->selisih }}</td>
                    <td class="td-non-itemname">{{ $barang->onhand }}</td>
                    <td class="td-non-itemname">{{ $barang->totalcso }}</td>
                    <td class="td-non-itemname">{{ $barang->koreksi }}</td>
                    <td class="td-non-itemname">{{ $barang->deviasi }}</td>
                    <td class="td-non-itemname">{{ $barang->statuscso }}</td>
                    <td class="td-non-itemname">{{ $barang->groupid }}</td>
                    <td class="td-non-itemname">{{ $barang->analisator }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
