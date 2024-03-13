@extends('layouts.master')

@section('title', 'Susunan Tim Item')

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
            <div class="container-fluid mt-3">
                <div class="d-flex justify-content-between mb-3">
                    <div class="px-3">
                        <h5>Report Resume CSO</h5>
                    </div>
                </div>
                <form action="{{route('susunan-tim-cso.update','susunan_tim_cso')}}" class="mb-3" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" name="type" value="1" hidden>
                    <div class="card card-secondary">
                        <div class="card-header bg-secondary text-white">
                            <h3 class="card-title">Analisator CSO</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover mb-3">
                                <thead>
                                    <tr>
                                        <th hidden></th>
                                        <th scope="col">No</th>
                                        <th>Nama Analisator</th>
                                        <th>Departemen</th>
                                        <th>Catatan tentang Analisator</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($analisator as $index => $analisator)
                                        <td hidden><input type="text" name="jobidAnalisator[]"
                                                value="{{ $analisator->jobid }}"></td>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $analisator->name }}</td>


                                        <td><select name="deptAnalisator[]" id="">
                                                <option value="{{ $analisator->dept }}" selected>
                                                    @if ($analisator->dept != null || $analisator->dept != '')
                                                        {{ $analisator->dept }}
                                                    @else
                                                        Pilih Departemen
                                                    @endif
                                                </option>
                                                <option value="PUR">PUR</option>
                                                <option value="SAL">SAL</option>
                                                <option value="FAC">FAC</option>
                                                <option value="ITE">ITE</option>
                                                <option value="GAF">GAF</option>
                                            </select></td>
                                        <td><input type="text" value="{{ $analisator->note }}" name="ketAnalisator[]"
                                                class="form-control"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="submit" name="simpan-analisator" class="btn btn-primary"><i
                                    class="fas fa-save pe-2"></i>save</button>
                        </div>
                    </div>
                </form>

                <form action="{{route('susunan-tim-cso.update','susunan_tim_cso')}}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" name="type" value="2" hidden>
                    <div class="card card-secondary">
                        <div class="card-header bg-secondary text-white ">
                            <h3 class="card-title ">Pelaku CSO</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover mb-3">
                                <thead>
                                    <tr>
                                        <th hidden></th>
                                        <th scope="col">No</th>
                                        <th>Nama Pelaku</th>
                                        <th>Departemen</th>
                                        <th>Catatan tentang Pelaku</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pelaku as $index => $pelaku)
                                        <tr>
                                            <td hidden><input type="text" name="jobidPelaku[]"
                                                    value="{{ $pelaku->jobid }}"></td>
                                            <td>{{ $index + 1 }}</th>
                                            <td>{{ $pelaku->name }}</td>
                                            <td><select name="deptPelaku[]" id="">
                                                    <option value="{{ $pelaku->dept }}" selected>
                                                        @if ($pelaku->dept != null || $pelaku->dept != '')
                                                            {{ $pelaku->dept }}
                                                        @else
                                                            Pilih Departemen
                                                        @endif
                                                    </option>
                                                    <option value="PUR">PUR</option>
                                                    <option value="SAL">SAL</option>
                                                    <option value="FAC">FAC</option>
                                                    <option value="ITE">ITE</option>
                                                    <option value="GAF">GAF</option>
                                                </select></td>
                                            <td><input type="text" value="{{ $pelaku->note }}" name="ketPelaku[]"
                                                    class="form-control"></td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <button type="submit" name="simpan-pelaku" class="btn btn-primary"><i
                                    class="fas fa-save pe-2"></i>save</button>
                        </div>
                    </div>
                </form>
    </div>
@endsection
