@if (Auth::user()->level != 1 && Auth::user()->level != 2)
<div class="mb-3">
    @if ($checkItemType->statusitem == 'T')
        <button type="button"  class="btn btn-danger " onclick="hapusAvalanTemuan(this)"><i class="fas fa-trash-alt"></i>
            Hapus Item</button>
    @endif
</div>
@endif
<div id="warning" class="alert alert-warning d-none"></div>
<input type="text" name="itembatchid" id="itembatchid" class="d-none" value="{{ $itembatchid }}">
<input type="text" name="batchno" class="d-none" value="{{ $batchno }}">
<input type="text" name="trsdetid" id="trsdetidparam" class="d-none" value="{{ $trsdetid }}">

<div class="row g-3 mb-3">
    <div class="form-floating col">
        <input class="form-control text-center bg-primary shadow-sm" value="{{ number_format($onhand, 2, ',', '.') }}" id="onHand"
            type="text" readonly>
        <label class="fw-bold" for="onHand">On Hand</label>
    </div>
    <div class="form-floating col">
        <input class="form-control text-center bg-warning shadow-sm" value="{{ number_format($totalcso, 2, ',', '.') }}" type="text"
            readonly>
        <label class="fw-bold">Qty CSO</label>
    </div>
    <div class="form-floating col">
        <input class="form-control text-center bg-danger shadow-sm" value="{{ number_format($selisih, 2, ',', '.') }}" type="text" readonly>
        <label class="fw-bold" for="vselisih">Selisih</label>
    </div>
    <div class="form-floating col">
        <input class="form-control text-center shadow-sm" name="koreksi" value="{{  $koreksi }}" type="number">
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
                    <td>{{ number_format($detail->qty, 2, ',', '.') }}</td>
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
                        @if ($cso->cso1 > 0 )
                            <td class="bg-info">{{ number_format($cso->cso1, 2, ',', '.') }}</td>
                        @else
                            <td>{{ $cso->cso1 }}</td>
                        @endif
                        @if ($cso->cso2 > 0)
                            <td class="bg-info">{{ number_format($cso->cso2, 2, ',', '.') }}</td>
                        @else
                            <td>{{ $cso->cso2 }}</td>
                        @endif
                        @if ($cso->cso3 > 0)
                            <td class="bg-info">{{ number_format($cso->cso3, 2, ',', '.') }}</td>
                        @else
                            <td>{{ $cso->cso3 }}</td>
                        @endif
                        @if ($cso->cso4 > 0)
                            <td class="bg-info">{{ number_format($cso->cso4, 2, ',', '.') }}</td>
                        @else
                            <td>{{ $cso->cso4 }}</td>
                        @endif
                    </tr>
                @endforeach

                @foreach ($totalCso as $tCso)
                    <tr class="table-secondary">
                        <td>Total</td>
                        <td>{{ number_format($tCso->totalcso1, 2, ',', '.') }}</td>
                        <td>{{ number_format($tCso->totalcso2, 2, ',', '.') }}</td>
                        <td>{{ number_format($tCso->totalcso3, 2, ',', '.') }}</td>
                        <td>{{ number_format($tCso->totalcso4, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-2">
        

        <button type="button" id="csoulang" onclick="csoUlang(this)" name="csoorder" class="btn btn-info mb-3"
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
    <textarea class="form-control form-control-sm" name="keterangan" id="vketerangan">{{$keterangan}}</textarea>
</div>

<script>
    function hapusAvalanTemuan(button) {
        var itembatchidparam = $("#itembatchid").val(); // Get the selected gudang values
        var batchnoparam = $("#batchno").val();
        var trsdetidparam = $("#trsdetidparam").val();

        $.ajax({
            url: "{{ url('admin/dashboard/item/hapus-temuan-avalan') }}",
            method: "POST",
            data: {
                itembatchid: itembatchidparam,
                trsdetid: trsdetidparam

            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data['result'] == 1) {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: `Temuan item dengan batch ${itembatchidparam}\nberhasil dihapus`,
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Terjadi kesalahan pada sistem, segera laporkan pada tim IT",
                    });
                }

            },
            error: function() {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Terjadi kesalahan pada sistem, segera laporkan pada tim IT",
                });
            }
        });
    }
    function csoUlang(button) {
        var itembatchidparam = $("#itembatchid").val(); // Get the selected gudang values
        var buttonCsoUlang = document.getElementById("csoulang");
        $.ajax({
            url: "{{ url('admin/dashboard/avalan/cso-ulang') }}",
            method: "POST",
            data: {
                itembatchid: itembatchidparam,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                console.log(data);
                if (data['result'] == 1) {                    
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: `Item dengan batch ${itembatchidparam} berhasil di CSO Ulang`,
                    });                    
                    buttonCsoUlang.disabled = true;
                } else {
                    Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Gagal melakukan CSO ulang",
                });
                }
            },
            error: function() {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Terjadi kesalahan pada sistem, segera laporkan pada tim IT",
                });
            }
        });
    }
</script>
