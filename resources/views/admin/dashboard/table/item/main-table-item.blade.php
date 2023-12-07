<table class="table table-sm table-bordered table-hover table-responsive small">
    <thead class="table-dark">
        <tr class="text-center ">
            <th class="align-middle" style="width: 28%">Nama Item</th>
            <th class="align-middle" style="width: 7%">Dimension</th>
            <th class="align-middle" style="width: 7%">Tolerance</th>
            <th class="align-middle" style="width: 10%">Status</th>
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
    <tbody>
        @foreach ($item as $barang)
            <tr 
            @if ($barang->selisih != 0)
                class="table-danger"
            @else
                class = "table-light"
            @endif>
                <td>{{$barang->itemname}}</td>
                <td class="text-center">{{$barang->dimension}}</td>
                <td class="text-center">{{$barang->tolerance}}</td>
                <td class="text-center">                                     
                    @if ($barang->status == 1)
                        <span class='badge rounded-pill text-bg-info text-wrap' style='width: 5rem'>proses
                    @elseif ($barang->status == 2)
                        <span class='badge  rounded-pill text-bg-danger text-wrap' style='width: 5rem'>selisih +
                    @elseif ($barang->status == 3)
                        <span class='badge rounded-pill text-bg-success text-wrap' style='width: 5rem'>selesai
                    @else 
                        <span class='badge rounded-pill text-bg-warning text-wrap' style='width: 5rem'>belum proses
                    @endif
                    </span>                                    
                </td>
                <td class="text-center">{{$barang->selisih}}</td>
                <td class="text-center">{{$barang->onhand}}</td>
                <td class="text-center">{{$barang->totalcso}}</td>
                <td class="text-center">{{$barang->koreksi}}</td>
                <td class="text-center">{{$barang->deviasi}}</td>
                <td class="text-center">{{$barang->statuscso}}</td>
                <td class="text-center">{{$barang->groupid}}</td>
                <td class="text-center">{{$barang->analisator}}</td>
            </tr>
        @endforeach
    </tbody>
</table>