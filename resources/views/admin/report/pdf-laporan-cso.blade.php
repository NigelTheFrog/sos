<title>
    @if ($type == 1)
        Item Belum Proses
    @elseif ($type == 2)
        Item Sedang Proses
    @elseif ($type == 3)
        Item Selesai
    @else
        Item Selisih
    @endif
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

    <h2>
      
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
                @foreach ($itemSdgProses as $barang)
                    <tr class="tr-body">
                        <td>{{ $barang->itemname }}</td>
                        <td class="td-non-itemname">{{ $barang->heatno }}</td>
                        <td class="td-non-itemname">{{ $barang->dimension }}</td>
                        <td class="td-non-itemname">{{ $barang->tolerance }}</td>
                        <td class="td-non-itemname">{{ $barang->kondisi }}</td>
                    </tr>
                @endforeach
            @else
                @foreach ($itemSelesai as $barang)
                    <tr class="tr-body">
                        <td>{{ $barang->itemname }}</td>
                        <td class="td-non-itemname">{{ $barang->heatno }}</td>
                        <td class="td-non-itemname">{{ $barang->dimension }}</td>
                        <td class="td-non-itemname">{{ $barang->tolerance }}</td>
                        <td class="td-non-itemname">{{ $barang->kondisi }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>