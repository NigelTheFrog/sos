<form method="post" action="{{ route('import-stok.store') }}">
    @csrf
    <div class="container-lg" style="height: 60vh">
        @if ($importedItem > 0)
            <div class="ms-4 mb-2">
                <input class="form-check-input" type="checkbox" value="" id="ceksemuaitem">
                <label for="ceksemuaitem" class="form-check-label">
                    Centang Semua
                </label>
            </div>
            <input type="text" name="type" value="1" hidden>
            <input type="text" name="coy" value="{{ $companyID }}" hidden>
            <input type="text" name="filternull" value="{{ $filterViewNull }}" hidden>
            <input type="text" name="whs" value="{{ $gudangcode }}" hidden>
            <input type="text" name="itemname" value="{{ $itemname }}" hidden>
            <div style="overflow: auto; max-height: 56vh;">
                <table class="table table-sm table-hover table-striped table-bordered text-nowrap">
                    <thead class="table-dark">
                        <tr class="text-center ">
                            <th></th>
                            <th scope="col">Nama Item</th>
                            <th scope="col">Product</th>
                            <th scope="col">Sub Product</th>
                            <th scope="col">Onhand All WRH</th>
                            <th scope="col">UOM</th>
                            @foreach ($gudang as $gdg)
                                <th scope="col">{{ $gdg }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach ($responseitem['data'] as $index => $items)
                            @foreach ($items as $item)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" name="checkboxImport[]"
                                                class="form-check-input checkboxsemuaitem" value={{ $item['ITEMID'] }}>
                                        </div>
                                    </td>
                                    <td>{{ $item['NamaItem'] }}</td>
                                    <td>{{ $item['Product'] }}</td>
                                    <td>{{ $item['SubProduct'] }}</td>
                                    <td>{{ $item['Onhand'] }}</td>
                                    <td>{{ $item['UOM'] }}</td>
                                    @foreach ($gudang as $gdg)
                                        <td>{{ (int) $item[$gdg] }}</td>
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
    @if ($importedItem > 0)
    <div class="float-end d-flex" >
        <button type="submit" class="btn btn-primary float-end" id="buttonImpor" >Impor</button>
        <button type="button" class="ms-2 btn btn-primary float-end" data-bs-dismiss="modal"
            aria-label="Close" id="buttonKeluar">Keluar</button>
    </div>
    @endisset
</form>

<script>
    $(document).ready(function() {
        $("#ceksemuaitem").click(function() {
            if ($(".checkboxsemuaitem").prop("checked")) {
                $(".checkboxsemuaitem").prop("checked", false);
            } else {
                $(".checkboxsemuaitem").prop("checked", true);
            }
        });
    });

    function clickImpor(button) {
        var buttonImpor = document.getElementById("buttonImpor");
        var buttonKeluar = document.getElementById("buttonKeluar");
        buttonImpor.disabled = true;
        buttonKeluar.disabled = true;
    }
</script>
