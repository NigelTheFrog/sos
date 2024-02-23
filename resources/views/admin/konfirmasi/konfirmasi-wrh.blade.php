@extends('layouts.master')

@section('title', 'Konfirmasi WRH')

@section('content')
<div class="content-wrapper mt-4">
    <!-- Main content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header bg-secondary text-white">
                    <h3 class="card-title">Konfirmasi WRH </h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="input-group">
                                <!-- <div class="input-group-prepend"> -->
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <!-- </div> -->
                                <select  id="select-pelaku" name="pelaku" placeholder="Daftar Nama Pelaku" >
                                    {{-- <option value="" style="color: grey" selected disabled>Daftar Nama Pelaku</option> --}}
                                    @foreach ( $pelaku as $pelaku )
                                    <option value="{{$pelaku->userid }}">{{$pelaku->username}} - {{$pelaku->name}}</option>
                                    @endforeach                                    
                                </select>
                                <button class="btn btn-secondary" onclick="showData(this)" type="button" id="search-button" style="height: 36px;">Cari</button>
                            </div>
                        </div>
                    </div>
                    <div id="listsearch"></div>


                </div>
            </div>
    </section>
</div>

<script>
    document.getElementById("select-pelaku").selectedIndex = -1;
    VirtualSelect.init({
        search: true,
        ele: '#select-pelaku',
        silentInitialValueSet: false,
        maxWidth: '92%',
        noSearchResultsText: "Nama Pelaku tidak ditemukan"
    });

    function showData(button) {
        let pelaku = $('#select-pelaku').val();
        $.ajax({
                url: "{{ route('konfirmasi-wrh.store') }}",
                method: "POST",
                data: {
                    pelaku: pelaku,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('#listsearch').html(data);
                },
                
            });
    }
</script>
@endsection