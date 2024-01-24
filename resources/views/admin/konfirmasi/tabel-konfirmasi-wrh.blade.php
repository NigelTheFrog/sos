<form method="post" action="{{ route('konfirmasi-wrh.update',"konfirmasi_wrh") }}">
    @csrf
    @method('PUT')
    <table class="table table-sm table-bordered table-hover table-responsive small table-striped">
        <thead class="table-dark">
            <tr class="text-center ">
                <th class="align-middle" style="width: 5%">No</th>
                <th class="align-middle" style="width: 6%">Username</th>
                <th class="align-middle" style="width: 12%">Nama</th>
                <th class="align-middle" style="width: 15%">Nama Item</th>
                <th class="align-middle" style="width: 7%">Qty Cek Stok</th>
                <th class="align-middle" style="width: 6%">Location</th>
                <th class="align-middle" style="width: 18%">Warna</th>
                <th class="align-middle" style="width: 5%">CSO ke-</th>
                <th class="align-middle" style="width: 7%">Approve</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datauser as $index=>$datauser)
                <tr>
                    <td class="align-middle text-center">{{ $index + 1 }}</td>
                    <td class="align-middle text-center">{{ $datauser->pelakuuname }}</td>
                    <td class="align-middle text-center">{{ $datauser->name }}</td>
                    <td class="align-middle text-center">{{ $datauser->itemname }}</td>
                    <td class="align-middle text-center">{{ $datauser->qty }}</td>
                    <td class="align-middle text-center">{{ $datauser->locationname }}</td>
                    <td class="align-middle text-center">{{ $datauser->colordesc }}</td>
                    <td class="align-middle text-center">{{ $datauser->csocount }}</td>
                    <td class="align-middle">
                        @if ($datauser->approval == "Y")
                        <input type="text" value="1" hidden>
                        <button type="submit" data-id="{{$datauser->csodetid}}" id="approve" class="btn btn-success btn-sm" title="Konfirm">
                            <i class="bi bi-shield-fill-check pr-2"></i>Approved
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" disabled><i class="bi bi-shield-fill pr-2"></i>Reject</button>
                        @else
                        <input type="text" value="2" hidden>
                        <button type="submit" data-id="{{$datauser->csodetid}}" id="approve" class="btn btn-primary btn-sm" title="Konfirm"><i class="bi bi-shield-fill pr-2"></i>Approve</button>
                        <button type="button" class="btn btn-danger btn-sm"><i class="bi bi-shield-fill-check pr-2"></i>Reject</button>
                        @endif
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</form>
