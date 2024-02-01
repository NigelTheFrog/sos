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
                @if ($barang->selisih != 0) class="table-danger"
            @else
                class = "table-light" @endif>
                <td hidden>
                    {{ $barang->itemid }}
                </td>
                <td hidden>
                    {{ $barang->batchno }}
                </td>
                <td hidden>
                    {{ $barang->itemname }}
                </td>
                <td class="align-middle">
                    <div class="d-flex my-0 align-items-center">
                        <div class="mr-3">
                            <button type="button" class="btn btn-sm" id="detailcsoitem"
                                onclick="openModalDetailCSO(this)" style="color: rgb(81, 81, 81)" id="viewlistcso"><i
                                    class="fas fa-eye"></i></button>
                        </div>
                        <div>{{ $barang->itemname }}</div>
                    </div>
                </td>
                <td class="align-middle text-center">{{ $barang->dimension }}</td>
                <td class="align-middle text-center">{{ $barang->tolerance }}</td>
                <td class="align-middle text-center">
                    @if ($barang->status == 1)
                        <span class='badge rounded-pill text-bg-info text-wrap' style='width: 5rem'>proses
                        @elseif ($barang->status == 2)
                            <span class='badge  rounded-pill text-bg-danger text-wrap' style='width: 5rem'>selisih +
                            @elseif ($barang->status == 3)
                                <span class='badge rounded-pill text-bg-success text-wrap' style='width: 5rem'>selesai
                                @else
                                    <span class='badge rounded-pill text-bg-warning text-wrap' style='width: 5rem'>belum
                                        proses
                    @endif
                    </span>
                </td>
                <td class="align-middle text-center">{{ $barang->selisih }}</td>
                <td class="align-middle text-center">{{ $barang->onhand }}</td>
                <td class="align-middle text-center">{{ $barang->totalcso }}</td>
                <td class="align-middle text-center">{{ $barang->koreksi }}</td>
                <td class="align-middle text-center">{{ $barang->deviasi }}</td>
                <td class="align-middle text-center">{{ $barang->statuscso }}</td>
                <td class="align-middle text-center">{{ $barang->groupid }}</td>
                <td class="align-middle text-center">{{ $barang->analisator }}</td> 
            </tr>
        @endforeach
    </tbody>
</table>
