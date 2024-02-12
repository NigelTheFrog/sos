<form method="post" action="{{ route('import-stok.store') }}">
    @csrf
    <div class="container-lg" style="height: 60vh">
        @if ($importedBatch > 0)
            <div class="ms-4 mb-2">
                <input class="form-check-input" type="checkbox" value="" id="ceksemuabatch">
                <label for="ceksemuabatch" class="form-check-label">
                    Centang Semua
                </label>
            </div>
            <input type="text" name="type" value="2" hidden>
            <input type="text" name="coy" value="{{ $companyID }}" hidden>
            <input type="text" name="filternull" value="{{ $filterViewNull }}" hidden>
            <input type="text" name="whs" value="{{ $gudangcode }}" hidden>
            <input type="text" name="itemname" value="{{ $itemname }}" hidden>
            <div style="overflow: auto; max-height: 56vh;">
                <table class="table table-sm table-hover table-striped table-bordered text-nowrap">
                    <thead class="table-dark">
                        <tr class="text-center ">
                            <th></th>
                            <th scope="col">Batch Item</th>
                            <th scope="col">Nama Item</th>
                            <th scope="col">Product</th>
                            <th scope="col">Sub Product</th>
                            <th scope="col">Batch No</th>
                            <th scope="col">Heat No</th>
                            <th scope="col">Dimension</th>
                            <th scope="col">Tolerance</th>
                            <th scope="col">Condition</th>
                            <th scope="col">Onhand All WRH</th>
                            <th scope="col">UOM</th>
                            @foreach ($gudang as $gdg)
                                <th scope="col">{{ $gdg }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach ($responsebatch['data'] as $index => $batches)
                            @foreach ($batches as $batch)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" name="checkboxImport[]"
                                                class="form-check-input cekboxsemuabatch"
                                                value={{ $batch['itembatchid'] }}>
                                        </div>
                                    </td>
                                    <td>{{ $batch['itembatchid'] }}</td>
                                    <td>{{ $batch['NamaItem'] }}</td>
                                    <td>{{ $batch['Product'] }}</td>
                                    <td>{{ $batch['SubProduct'] }}</td>
                                    <td>{{ $batch['batchno'] }}</td>
                                    <td>{{ $batch['heatNo'] }}</td>
                                    <td>{{ $batch['Dimension'] }}</td>
                                    <td>{{ $batch['Tolerance'] }}</td>
                                    <td>{{ $batch['condition'] }}</td>
                                    <td>{{ $batch['Onhand'] }}</td>
                                    <td>{{ $batch['UOM'] }}</td>
                                    @foreach ($gudang as $gdg)
                                        <td>{{ (float) $batch[$gdg] }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <hr>
    @if ($importedBatch > 0)
    <div class="float-end d-flex" >
        <button type="submit" class="btn btn-primary float-end">Impor</button>
        <button type="button" class="ms-2 btn btn-primary float-end" data-bs-dismiss="modal"
            aria-label="Close">Keluar</button>
    </div>
    @endisset
</form>

<script>
    $(document).ready(function() {
        $("#ceksemuabatch").click(function() {
            if ($(".cekboxsemuabatch").prop("checked")) {
                $(".cekboxsemuabatch").prop("checked", false);
            } else {
                $(".cekboxsemuabatch").prop("checked", true);
            }
        });
    });
</script>
