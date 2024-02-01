<div id="warning" class="alert alert-warning d-none"></div>
<input type="text" name="itemid" class="d-none" value="{{ $itemid }}">
<input type="text" name="batchno" class="d-none" value="{{ $batchno }}">

<div class="row g-3 mb-3">
    <div class="form-floating col">
        <input class="form-control text-center bg-primary shadow-sm" value="{{ $onhand }}" id="onHand"
            type="text" readonly>
        <label class="fw-bold" for="onHand">On Hand</label>
    </div>
    <div class="form-floating col">
        <input class="form-control text-center bg-warning shadow-sm" value="{{ $totalcso }}" type="text"
            readonly>
        <label class="fw-bold">Qty CSO</label>
    </div>
    <div class="form-floating col">
        <input class="form-control text-center bg-danger shadow-sm" value="{{ $selisih }}" type="text" readonly>
        <label class="fw-bold" for="vselisih">Selisih</label>
    </div>
    <div class="form-floating col">
        <input class="form-control text-center shadow-sm" name="koreksi" value="{{ $koreksi }}" type="number">
        <label class="fw-bold" for="vkoreksi">Input Koreksi</label>
    </div>
    <div class="form-floating col">
        <input class="form-control text-center shadow-sm" name="deviasi" value="{{ $deviasi }}" type="number">
        <label class="fw-bold" for="vdeviasi">Input Deviasi</label>
    </div>
</div>
<div id="tbldetail">
    <table class="table table-sm table-hover table-bordered table-responsive-md small shadow-sm">
        <thead class="table-secondary">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Pelaku</th>
                <th scope="col">Lokasi</th>
                <th scope="col">Color</th>
                <th scope="col">Qty/lokasi</th>
                <th scope="col">CSO ke-</th>
                <th scope="col">Remark</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tableDetailDashboard as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->name }}</td>
                    <td>{{ $detail->locationname }}</td>
                    <td>{{ $detail->color }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>{{ $detail->csocount }}</td>
                    <td>{{ $detail->remark }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="row mb-2">
    <div class="col-7">
        <table class="table table-sm table-responsive-md table-hover table-bordered shadow-sm small">
            <thead class="table-secondary">
                <tr>
                    <th scope="col">Pelaku</th>
                    <th scope="col">CSO 1</th>
                    <th scope="col">CSO 2</th>
                    <th scope="col">CSO 3</th>
                    <th scope="col">CSO 4</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataCso as $cso)
                    <tr>
                        <td>{{ $cso->name }}</td>
                        @if ($cso->csocount == 1)
                            <td class="bg-info">{{ $cso->cso1 }}</td>
                        @else
                            <td>{{ $cso->cso1 }}</td>
                        @endif
                        @if ($cso->csocount == 2)
                            <td class="bg-info">{{ $cso->cso2 }}</td>
                        @else
                            <td>{{ $cso->cso2 }}</td>
                        @endif
                        @if ($cso->csocount == 3)
                            <td class="bg-info">{{ $cso->cso3 }}</td>
                        @else
                            <td>{{ $cso->cso3 }}</td>
                        @endif
                        @if ($cso->csocount == 4)
                            <td class="bg-info">{{ $cso->cso4 }}</td>
                        @else
                            <td>{{ $cso->cso4 }}</td>
                        @endif
                    </tr>
                @endforeach

                @foreach ($totalCso as $tCso)
                    <tr class="table-secondary">
                        <td>Total</td>
                        <td>{{ $tCso->totalcso1 }}</td>
                        <td>{{ $tCso->totalcso2 }}</td>
                        <td>{{ $tCso->totalcso3 }}</td>
                        <td>{{ $tCso->totalcso4 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-2">
        <button type="button" id="csoorder" name="csoorder" class="btn btn-info mb-3"
            @if ($checkCso == 0) disabled @endif>CSO Ulang</button>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkkesalahanadmin" name="check_kesalahan_admin"
            @if (count($analisator) > 0 && $analisator[0]->kesalahan_admin == 1) checked @endif>
            <label class="form-check-label small" for="checkkesalahanadmin">
                Kesalahan Admin
            </label>
        </div>
    </div>
    <div class="col-3 small">
        <div class="w-100 mb-2">
            <label class="input-group-text small">Analisator</label>
            <select class="form-select form-select-sm" id="" name="analisator"
                @if (Auth::user()->level != 1 && Auth::user()->level != 2) disabled @endif>
                @if (count($analisator) == 0)
                    <option value="" selected>--Pilih Analisator--</option>
                    @foreach ($dbxJob as $job)
                        <option value="{{ $job->userid }}">{{ $job->name }}</option>
                    @endforeach
                @else
                    <option value="">-</option>
                    @foreach ($dbxJob as $job)
                        <option value="{{ $job->userid }}"
                            @foreach ($analisator as $analis)
                                @if ($job->userid == $analis->analisatorid)
                                selected                            
                                @endif @endforeach>
                            {{ $job->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="w-100 mb-2">
            <label class="input-group-text small">Grouping</label>
            <select class="form-select form-select-sm" id="" name="grouping">
                @if (count($analisator) == 0)
                    <option value="" selected>--Pilih Group--</option>
                    @foreach ($group as $grup)
                        <option value="{{ $grup->groupid }}">{{ $grup->groupdesc }}</option>
                    @endforeach
                @else
                    <option value="0">-</option>
                    @foreach ($group as $grup)
                        <option value="{{ $grup->groupid }}"
                            @foreach ($analisator as $analis)
                                @if ($grup->groupid == $analis->groupid)
                                selected                            
                                @endif @endforeach>
                            {{ $grup->groupdesc }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>

<div class="">
    <label for="vketerangan" class="input-group-text">Keterangan Koreksi</label>
    <textarea class="form-control form-control-sm" name="keterangan" id="vketerangan"></textarea>
</div>
