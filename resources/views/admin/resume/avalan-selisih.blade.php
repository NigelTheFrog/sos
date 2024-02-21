@extends('layouts.master')

@section('title', 'Daftar Avalan Selisih')

@section('content')

    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="mb-3 mt-3">
                    <h5>List Avalan Selisih</h5>
                </div>
                <div class="card card-secondary">
                    <div class="card-header bg-secondary text-white">
                        <h3 class="card-title">Avalan tertukar</h3>
                    </div>
                    <form action="{{ route('avalan-selisih.store') }}" method="POST">
                        @csrf
                        <input type="text" name="type" value="1" hidden>
                        <div class="card-body small">
                            <table class="table table-striped table-hover text-center">
                                <thead>
                                    <tr>
                                        <th class="d-none"></th>
                                        <th scope="col">No</th>
                                        <th>Nama Item</th>
                                        <th>Keputusan</th>
                                        <th>SLS LBR</th>
                                        <th>Realita LBR</th>
                                        <th>Selisih Plus (qty)</th>
                                        <th>Selisih Minus (qty)</th>
                                        <th>HPP</th>
                                        <th>Selisih Plus (nominal)</th>
                                        <th>Selisih Minus (nominal)</th>
                                        <th>Pembebanan (nominal)</th>
                                        <th>Group</th>
                                        <th>No Adjust (GI/SJ & GR)</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tertukar as $index => $tertukar)
                                        <tr>
                                            <td hidden><input type="text" name="trsdetid[]"
                                                    value="{{ $tertukar->trsdetid }}"></td>
                                            <th>{{ $index + 1 }}</th>
                                            <td>{{ $tertukar->itemname }}</td>
                                            <td><select class="form-select form-select-sm" name="keputusan[]">
                                                @if ($tertukar->keputusan != null)
                                                        <option value="{{ $tertukar->keputusan }}" selected>
                                                            @foreach ($keputusan as $kep)
                                                            @if ($kep->keputusanid == $tertukar->keputusan)
                                                            {{ $kep->keputusandesc }}
                                                            @endif                                                                
                                                            @endforeach
                                                            </option>
                                                        @foreach ($keputusan as $kep)
                                                            <option value="{{ $kep->keputusanid }}">
                                                                {{ $kep->keputusandesc }}</option>
                                                        @endforeach
                                                    @else
                                                        <option selected>Pilih Keputusan</option>
                                                        @foreach ($keputusan as $kep)
                                                            <option value="{{ $kep->keputusanid }}">
                                                                {{ $kep->keputusandesc }}</option>
                                                        @endforeach
                                                @endif                                                    
                                                </select> </td>
                                            <td>{{ $tertukar->onhand }}</td>
                                            <td>{{ $tertukar->statuscso }}</td>
                                            <td>{{ number_format($tertukar->selisihplus , 2, ',', '.') }}</td>
                                            <td>{{ number_format($tertukar->selisihmin , 2, ',', '.') }}</td>
                                            <td>Rp. {{ number_format($tertukar->cogs , 2, ',', '.') }}</td>
                                            <td>Rp. {{ number_format($tertukar->nominalplus , 2, ',', '.') }}</td>
                                            <td>Rp. {{ number_format($tertukar->nominalmin , 2, ',', '.         ') }}</td>
                                            <td>
                                                @if ($tertukar->pembebanan != null)
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="pembebanan[]" value="{{ $tertukar->pembebanan }}">
                                                @else
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="pembebanan[]">
                                                @endif
                                            </td>
                                            <td>{{ $tertukar->groupid }}</td>
                                            <td>
                                                @if ($tertukar->nodoc != null)
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="nodok[]" value="{{ $tertukar->nodoc }}">
                                                @else
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="nodok[]">
                                                @endif
                                            </td>
                                            <td>
                                                @if ($tertukar->keterangan != null)
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="keterangan[]" value="{{ $tertukar->keterangan }}">
                                                @else
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="keterangan[]">
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="submit" name="simpan-itm-tertukar" class="btn btn-primary mt-3"><i
                                    class="fas fa-save pe-2"></i>save</button>
                        </div>
                    </form>
                </div>

                <div class="card card-secondary">
                    <div class="card-header bg-secondary text-white">
                        <h3 class="card-title">Avalan Selisih Plus & Selisih Minus</h3>
                    </div>
                    <form action="{{ route('avalan-selisih.store') }}" method="POST">
                        @csrf
                        <input type="text" name="type" value="2" hidden>
                        <div class="card-body small">
                            <table class="table table-striped table-hover text-center">
                                <thead>
                                    <tr>
                                        <th class="d-none"></th>
                                        <th scope="col">No</th>
                                        <th>Nama Item</th>
                                        <th>Keputusan</th>
                                        <th>SLS LBR</th>
                                        <th>Realita LBR</th>
                                        <th>Selisih Plus (qty)</th>
                                        <th>Selisih Minus (qty)</th>
                                        <th>HPP</th>
                                        <th>Selisih Plus (nominal)</th>
                                        <th>Selisih Minus (nominal)</th>
                                        <th>Pembebanan (nominal)</th>
                                        <th>Group</th>
                                        <th>No Adjust (GI/SJ & GR)</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($selisih as $index => $selisih)
                                        <tr>
                                            <td hidden><input type="text" name="trsdetid[]"
                                                    value="{{ $selisih->trsdetid }}"></td>
                                            <td>{{ $index + 1 }}</th>
                                            <td>{{ $selisih->itemname }}</td>
                                            <td><select class="form-select form-select-sm" name="keputusan[]">
                                                    @if ($selisih->keputusan != null)
                                                        <option value="{{ $selisih->keputusan }}" selected>
                                                            @foreach ($keputusan as $kep)
                                                            @if ($kep->keputusanid == $selisih->keputusan)
                                                            {{ $kep->keputusandesc }}
                                                            @endif                                                                
                                                            @endforeach
                                                            </option>
                                                        @foreach ($keputusan as $kep)
                                                            <option value="{{ $kep->keputusanid }}">
                                                                {{ $kep->keputusandesc }}</option>
                                                        @endforeach
                                                    @else
                                                        <option selected>Pilih Keputusan</option>
                                                        @foreach ($keputusan as $kep)
                                                            <option value="{{ $kep->keputusanid }}">
                                                                {{ $kep->keputusandesc }}</option>
                                                        @endforeach
                                                    @endif
                                                </select> </td>
                                            <td>{{ $selisih->onhand }}</td>
                                            <td>{{ $selisih->statuscso }}</td>
                                            <td>{{ number_format($selisih->selisihplus, 2, '.', ',') }}</td>
                                            <td>{{ number_format($selisih->selisihmin, 2, '.', ',') }}</td>
                                            <td>
                                                @if ($selisih->cogs != 0)
                                                    Rp.{{ number_format($selisih->cogs, 2, '.', ',') }}
                                                
                                                @endif
                                            </td>
                                            <td>
                                                @if ($selisih->nominalplus != 0)
                                                    Rp.{{ number_format($selisih->nominalplus, 2, '.', ',') }}
                                               
                                                @endif
                                            </td>
                                            <td>
                                                @if ($selisih->nominalmin != 0)
                                                    Rp.{{ number_format($selisih->nominalmin, 2, '.', ',') }}
                                               
                                                @endif
                                            </td>
                                            <td>
                                                @if ($selisih->pembebanan != null)
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="pembebanan[]" value="{{ $selisih->pembebanan }}">
                                                @else
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="pembebanan[]">
                                                @endif
                                            </td>
                                            <td>{{ $selisih->groupid }}</td>
                                            <td>
                                                @if ($selisih->nodoc != null)
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="nodok[]" value="{{ $selisih->nodoc }}">
                                                @else
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="nodok[]">
                                                @endif
                                            </td>
                                            <td>
                                                @if ($selisih->keterangan != null)
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="keterangan[]" value="{{ $selisih->keterangan }}">
                                                @else
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="keterangan[]">
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="submit" name="simpan-itm-selisih" class="btn btn-primary mt-3"><i
                                    class="fas fa-save pe-2"></i>save</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
