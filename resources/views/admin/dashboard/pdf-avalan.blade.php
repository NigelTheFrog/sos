<title>
    @if ($type == 1)
        Avalan Belum Proses
    @elseif ($type == 2)
        Avalan Sedang Proses
    @elseif ($type == 3)
        Avalan Selesai
    @else
        Avalan Selisih
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

@if ($type != 4)
    <h2>
        @if ($type == 1)
            Avalan Yang Belum Dicek
        @elseif ($type == 2)
            Avalan Yang Sedang Dicek
        @else
            Avalan Yang Sudah Dicek
        @endif
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
                @foreach ($avalanBlmProses as $barang)
                    <tr class="tr-body">
                        <td>{{ $barang->itemname }}</td>
                        <td class="td-non-itemname">{{ $barang->heatno }}</td>
                        <td class="td-non-itemname">{{ $barang->dimension }}</td>
                        <td class="td-non-itemname">{{ $barang->tolerance }}</td>
                        <td class="td-non-itemname">{{ $barang->kondisi }}</td>
                    </tr>
                @endforeach
            @elseif ($type == 2)
                @foreach ($avalanSdgProses as $barang)
                    <tr class="tr-body">
                        <td>{{ $barang->itemname }}</td>
                        <td class="td-non-itemname">{{ $barang->heatno }}</td>
                        <td class="td-non-itemname">{{ $barang->dimension }}</td>
                        <td class="td-non-itemname">{{ $barang->tolerance }}</td>
                        <td class="td-non-itemname">{{ $barang->kondisi }}</td>
                    </tr>
                @endforeach
            @else
                @foreach ($avalanSelesai as $barang)
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
@else
    <h2>

            Avalan Selisih Plus
        
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
                @foreach ($avalanSelisihPlus as $barang)
                    <tr class="tr-body">
                        <td>{{ $barang->itemname }}</td>
                        <td class="td-non-itemname">{{ $barang->heatno }}</td>
                        <td class="td-non-itemname">{{ $barang->dimension }}</td>
                        <td class="td-non-itemname">{{ $barang->tolerance }}</td>
                        <td class="td-non-itemname">{{ $barang->kondisi }}</td>
                    </tr>
                @endforeach
        </tbody>
    </table>
    <h2>

            Avalan Selisih Minus
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

                @foreach ($avalanSelisihMinus as $barang)
                    <tr class="tr-body">
                        <td>{{ $barang->itemname }}</td>
                        <td class="td-non-itemname">{{ $barang->heatno }}</td>
                        <td class="td-non-itemname">{{ $barang->dimension }}</td>
                        <td class="td-non-itemname">{{ $barang->tolerance }}</td>
                        <td class="td-non-itemname">{{ $barang->kondisi }}</td>
                    </tr>
                @endforeach
        </tbody>
    </table>
@endif
