<form method="post" action="{{ route('import-avalan.store') }}">
    @csrf
    <div class="container-lg" style="height: 60vh;">
        @if ($importedAvalan > 0)
            <input type="text" name="type" value="1" hidden>
            <input type="text" name="coy" value="{{ $companyID }}" hidden>
            <input type="text" name="filternull" value="{{ $filterViewNull }}" hidden>
            <input type="text" name="whs" value="{{ $gudangcode }}" hidden>
            <input type="text" name="itemname" value="{{ $itemname }}" hidden>
            <div class="ms-4 mb-2">
                <input class="form-check-input" type="checkbox" value="" id="ceksemuaavalan">
                <label for="ceksemuaavalan" class="form-check-label">
                    Centang Semua
                </label>
            </div>
            <div style="overflow: auto; max-height: 60vh;">
                <table class="table table-sm table-hover table-striped table-bordered text-nowrap">
                    <thead class="table-dark">
                        <tr class="text-center ">
                            <th></th>
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
                        @foreach ($responseavalan['data'] as $avalans)
                            @foreach ($avalans as $avalan)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" name="checkboxImport[]"
                                                class="form-check-input cekboxsemuaavalan"
                                                value={{ $avalan['itembatchid'] }}>
                                        </div>
                                    </td>
                                    <td>{{ $avalan['NamaItem'] }}</td>
                                    <td>{{ $avalan['Product'] }}</td>
                                    <td>{{ $avalan['SubProduct'] }}</td>
                                    <td>{{ $avalan['BatchNo'] }}</td>
                                    <td>{{ $avalan['HeatNo'] }}</td>
                                    <td>{{ $avalan['Dimension'] }}</td>
                                    <td>{{ $avalan['Tolerance'] }}</td>
                                    <td>{{ $avalan['condition'] }}</td>
                                    <td>{{ (float) $avalan['Onhand'] }}</td>
                                    <td>{{ $avalan['UOM'] }}</td>
                                    @foreach ($gudang as $gdg)
                                        <td>{{ (float) $avalan[$gdg] }}</td>
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
    @if ($importedAvalan > 0)
        <div class="float-end d-flex justify-content-between" style="width: 13%">
            <button type="submit" class="btn btn-primary float-end">Impor</button>
            <button type="button" class="btn btn-primary float-end" data-bs-dismiss="modal"
                aria-label="Close">Keluar</button>
        </div>
    @endisset
</form>

<script>
    $(document).ready(function() {
        $("#ceksemuaavalan").click(function() {
            if ($(".cekboxsemuaavalan").prop("checked")) {
                $(".cekboxsemuaavalan").prop("checked", false);
            } else {
                $(".cekboxsemuaavalan").prop("checked", true);
            }
        });
    });
</script>
