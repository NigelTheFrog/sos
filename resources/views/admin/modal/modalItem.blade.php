<div class="modal fade text-left" id="ModalItemBlmProses" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mdlMoreLabel">Item Belum Proses</h1>
                <button type="button" class="btn-close align-middle" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-hover table-responsive small">
                    <thead class="table-dark">
                        <tr class="text-center ">
                            <th class="align-middle" style="width: 33%">Nama Item</th>
                            <th class="align-middle" style="width: 7%">Dimension</th>
                            <th class="align-middle" style="width: 7%">Tolerance</th>
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
                    <tbody class="table-striped-columns">
                        @foreach ($itemBlmProses as $barang)
                            <tr>
                                <td>{{$barang->itemname}}</td>
                                <td class="text-center">{{$barang->dimension}}</td>
                                <td class="text-center">{{$barang->tolerance}}</td>
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
            </div>
        </div>
    </div>
</div>