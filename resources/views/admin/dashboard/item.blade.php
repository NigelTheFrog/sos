@extends('layouts.master')

@section('title', 'Dashboard Item')

@section('content')

    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard Item</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard Item</li>
        </ol>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body" id="title">Item belum proses</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ url('admin/itembelumproses') }}"
                            id="btnItemBlmProses" data-bs-mytitle="Ini Modal Belum Proses" data-bs-toggle="modal"
                            data-bs-target="#ModalItemBlmProses">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">Item sedang proses</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#" id="btnItemBlmProses"
                            data-bs-toggle="modal" data-bs-target="#ModalItemSdgProses">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">Item OK</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#" id="btnItemOk" data-bs-toggle="modal"
                            data-target="#ModalItemOk">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">Item selisih</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#" id="btnItemBlmProses"
                            data-bs-toggle="modal" data-bs-target="#ModalItemSelisih">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <div class="row justify-content-between pt-2 ps-4 pe-3">
                    <div class="col">
                        <h3 class="card-title">Hasil Stock Opname</h3>
                    </div>
                    <div class="col-3">
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" id="searchModItem" type="search" placeholder="Search"
                                aria-label="Search">
                        </form>
                    </div>
                </div>

                <div id="main-table-item" class="card-body">
                    @include('admin.dashboard.table.main-table-item')

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="ModalItemBlmProses" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="mdlMoreLabel">Item Belum Proses</h1>
                    <button type="button" class="btn-close align-middle" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-bordered table-hover table-responsive small table-striped">
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
                        <tbody>
                            @foreach ($itemBlmProses as $barang)
                                <tr>
                                    <td>{{ $barang->itemname }}</td>
                                    <td class="text-center">{{ $barang->dimension }}</td>
                                    <td class="text-center">{{ $barang->tolerance }}</td>
                                    <td class="text-center">{{ $barang->selisih }}</td>
                                    <td class="text-center">{{ $barang->onhand }}</td>
                                    <td class="text-center">{{ $barang->totalcso }}</td>
                                    <td class="text-center">{{ $barang->koreksi }}</td>
                                    <td class="text-center">{{ $barang->deviasi }}</td>
                                    <td class="text-center">{{ $barang->statuscso }}</td>
                                    <td class="text-center">{{ $barang->groupid }}</td>
                                    <td class="text-center">{{ $barang->analisator }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="ModalItemSdgProses" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="mdlMoreLabel">Item Sedang Proses</h1>
                    <button type="button" class="btn-close align-middle" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-bordered table-hover table-responsive small table-striped">
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
                        <tbody>
                            @foreach ($itemSdgProses as $barang)
                                <tr>
                                    <td>{{ $barang->itemname }}</td>
                                    <td class="text-center">{{ $barang->dimension }}</td>
                                    <td class="text-center">{{ $barang->tolerance }}</td>
                                    <td class="text-center">{{ $barang->selisih }}</td>
                                    <td class="text-center">{{ $barang->onhand }}</td>
                                    <td class="text-center">{{ $barang->totalcso }}</td>
                                    <td class="text-center">{{ $barang->koreksi }}</td>
                                    <td class="text-center">{{ $barang->deviasi }}</td>
                                    <td class="text-center">{{ $barang->statuscso }}</td>
                                    <td class="text-center">{{ $barang->groupid }}</td>
                                    <td class="text-center">{{ $barang->analisator }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="ModalItemSelisih" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="mdlMoreLabel">Item Selisih</h1>
                    <button type="button" class="btn-close align-middle" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        setInterval(function() {
            $.ajax({
                url: "{{ url('admin/dashboard/main-table-item') }}",
                type: 'GET',
                success: function(data) {
                    $('#main-table-item').html(data);
                    console.log(data);
                }
            });
        }, 3000);
    </script>
@endsection
