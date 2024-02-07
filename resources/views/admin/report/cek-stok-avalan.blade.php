@extends('layouts.master')

@section('title', 'Cek Stok')

@section('content')

    <div class="content-wrapper mt-3">
        <!-- Main content -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="">
                        <div class="card card-secondary">
                            <div class="card-header bg-secondary text-white">
                                <h3 class="card-title"> Laporan CSO Avalan</h3>
                            </div>
                            <div class="card-body" style="background-color: #f8f8f8;">

                                <div class="list-group">
                                    <button class="list-group-item list-group-item-action"
                                        style="border-bottom: 1px solid #d2d2d2;" data-bs-toggle="modal"
                                        data-bs-target="#modalLaporanResume">
                                        <div class="d-flex w-100 justify-content-between">
                                            <div class="fw-bold">Laporan Resume Hasil Pelaksanaan Cek Stok</div>
                                        </div>
                                        <small>Keterangan</small>
                                    </button>
                                    <button class="list-group-item list-group-item-action"
                                        style="border-top: 1px solid #d2d2d2;" data-bs-toggle="modal"
                                        data-bs-target="#modalLaporanCSO">
                                        <div class="d-flex w-100 justify-content-between">
                                            <div class="fw-bold">Laporan CSO SRM All Material Pipa Industri, Siku, Strep
                                            </div>
                                        </div>
                                        <small>Keterangan</small>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
    <div class="modal fade text-left" id="modalLaporanResume" tabindex="-1">
        <div class="modal-dialog modal modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('cek-stok-avalan.store') }}" method="POST">
                    @csrf
                    <input type="text" name="type" value="1" hidden>
                    <div class="modal-header bg-secondary text-white">
                        <h1 class="modal-title fs-5" id="mdlMoreLabel">Laporan Hasil Pelaksanaan Cek Stok</h1>
                        <button type="button" class="btn-close btn-close-white align-middle"
                            onclick="closeLaporanResume(this)" aria-label="Close">
                    </div>
                    <div class="modal-body">
                        <div class="form-group row col">
                            <label class="col=sm-e col-form-label">Nomor Dokumen </label>
                            <div class="col-sm-9">
                                <select class="form-select" style="width: 110%" name="trsidresume">
                                    @foreach ($listNodoc as $nodoc)
                                        <option value="{{ $nodoc->trsid }}">{{ $nodoc->doccsoid }} -
                                            {{ $nodoc->startcsodate }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary text-white"><i
                                class="fas fa-print pe-2"></i>Preview</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="modalLaporanCSO" tabindex="-1">
        <div class="modal-dialog modal modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h1 class="modal-title fs-6" id="mdlMoreLabel">Laporan CSO SRM All Material Pipa Industri, Siku, Strep
                    </h1>
                    <button type="button" class="btn-close btn-close-white align-middle" onclick="closeLaporanCSO(this)"
                        aria-label="Close">
                    </button>
                </div>
                <form action="{{ route('cek-stok-avalan.store') }}" method="POST">
                    @csrf
                    <input type="text" name="type" value="2" hidden>
                    <div class="modal-body">
                        <div class="form-group row col">
                            <label class="col=sm-e col-form-label">Nomor Dokumen </label>
                            <div class="col-sm-9">
                                <select class="form-select" style="width: 110%" name="trsidlaporan">
                                    @foreach ($listNodoc as $nodoc)
                                        <option value="{{ $nodoc->trsid }}">{{ $nodoc->doccsoid }} -
                                            {{ $nodoc->startcsodate }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary text-white"><i
                                class="fas fa-print pe-2"></i>Preview</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function closeLaporanCSO(button) {
            $('#modalLaporanCSO').modal('hide');
        }

        function closeLaporanResume(button) {
            $('#modalLaporanResume').modal('hide');
        }

        function printLaporanResume(button) {
            const trsid = document.getElementById('trsidresume');
            window.location.href = `{{ url('admin/report/cek-stok/${trsid.value}') }}`;
        }

        function printLaporanCsoClik(button) {
            const trsid = document.getElementById('trsidlaporan');
            window.location.href = `{{ url('admin/report/cek-stok/${trsid.value}') }}`;
        }
    </script>


@endsection
