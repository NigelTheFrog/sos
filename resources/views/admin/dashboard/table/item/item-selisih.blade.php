<div>
    <h4 class="modal-title fs-5 text-center pb-3"> Item Selisih Plus</h4>
    <table class="table table-sm table-bordered table-hover table-responsive small table-striped">
        <thead class="table-dark">
            <tr class="text-center ">
                <th class="align-middle" style="width: 15%">Nama Item</th>
                <th class="align-middle" style="width: 5%">Dimension</th>
                <th class="align-middle" style="width: 5%">Tolerance</th>
                <th class="align-middle" style="width: 5%">Selisih</th>
                <th class="align-middle" style="width: 5%">Onhand</th>
                <th class="align-middle" style="width: 2%">Total CSO</th>
                <th class="align-middle" style="width: 3%">Koreksi</th>
                <th class="align-middle" style="width: 3%">Deviasi</th>
                <th class="align-middle" style="width: 2%">Status CSO</th>
                <th class="align-middle" style="width: 14%">Grouping</th>
                <th class="align-middle" style="width: 16%">Analisator</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($itemSelisihPlus as $barang)
                <tr>
                    <td>{{ $barang->itemname }}</td>
                    <td class="align-middle text-center">{{ $barang->dimension }}</td>
                    <td class="align-middle text-center">{{ $barang->tolerance }}</td>
                    <td class="align-middle text-center">{{ $barang->selisih }}</td>
                    <td class="align-middle text-center">{{ $barang->onhand }}</td>
                    <td class="align-middle text-center">{{ $barang->totalcso }}</td>
                    <td class="align-middle text-center">{{ $barang->koreksi }}</td>
                    <td class="align-middle text-center">{{ $barang->deviasi }}</td>
                    <td class="align-middle text-center">{{ $barang->statuscso }}</td>
                    <td class="align-middle text-center">
                        <select class="form-select" name="analistaor" id="">
                            <option value="" selected>--Pilih Group --</option>
                            @foreach ($dbmgroup as $group)
                                <option value="{{ $group->groupid }}">{{ $group->groupdesc }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="align-middle text-center">
                        <select class="form-select" name="analistaor" id="">
                            <option value="" selected>--Pilih Analisator --</option>
                            @foreach ($dbxjob as $user)
                                <option value="{{ $user->userid }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="pt-2">
    <h4 class="modal-title fs-5 text-center pb-3"> Item Selisih Minus</h4>
    <table class="table table-sm table-bordered table-hover table-responsive small table-striped">
        <thead class="table-dark">
            <tr class="text-center ">
                <th class="align-middle" style="width: 15%">Nama Item</th>
                <th class="align-middle" style="width: 5%">Dimension</th>
                <th class="align-middle" style="width: 5%">Tolerance</th>
                <th class="align-middle" style="width: 5%">Selisih</th>
                <th class="align-middle" style="width: 5%">Onhand</th>
                <th class="align-middle" style="width: 2%">Total CSO</th>
                <th class="align-middle" style="width: 3%">Koreksi</th>
                <th class="align-middle" style="width: 3%">Deviasi</th>
                <th class="align-middle" style="width: 2%">Status CSO</th>
                <th class="align-middle" style="width: 14%">Grouping</th>
                <th class="align-middle" style="width: 16%">Analisator</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($itemSelisihMinus as $barang)
                <tr>
                    <td>{{ $barang->itemname }}</td>
                    <td class="align-middle text-center">{{ $barang->dimension }}</td>
                    <td class="align-middle text-center">{{ $barang->tolerance }}</td>
                    <td class="align-middle text-center">{{ $barang->selisih }}</td>
                    <td class="align-middle text-center">{{ $barang->onhand }}</td>
                    <td class="align-middle text-center">{{ $barang->totalcso }}</td>
                    <td class="align-middle text-center">{{ $barang->koreksi }}</td>
                    <td class="align-middle text-center">{{ $barang->deviasi }}</td>
                    <td class="align-middle text-center">{{ $barang->statuscso }}</td>
                    <td class="align-middle text-center">
                        <select class="form-select" name="analistaor" id="">
                            <option value="" selected>--Pilih Group --</option>
                            @foreach ($dbmgroup as $group)
                                <option value="{{ $group->groupid }}">{{ $group->groupdesc }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="align-middle text-center">
                        <select class="form-select" name="analistaor" id="">
                            <option value="" selected>--Pilih Analisator --</option>
                            @foreach ($dbxjob as $user)
                                <option value="{{ $user->userid }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
