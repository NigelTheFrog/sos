<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin\Dashboard\AvalanProduk;
use App\Models\ViewDashboardAvalan;
use Illuminate\Http\Request;

class AvalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $avalan = ViewDashboardAvalan::all();
        $avalanBlmProses = ViewDashboardAvalan::where('status','=', '0')->get();
        $countAvalanBlmProses = count($avalanBlmProses);
        $avalanSdgProses = ViewDashboardAvalan::where('status','!=', '0')->where('status','!=', '3')->get();
        $countAvalanSdgProses = count($avalanSdgProses);
        $avalanOk = ViewDashboardAvalan::where('status','=', '3')->get();
        $countAvalanOk=count($avalanOk);
        $avalanSelisih = ViewDashboardAvalan::where('selisih','>', '0')->get();
        $countAvalanSelisih = count($avalanSelisih);
        return view("admin.dashboard.avalan", [
            'avalan'=>$avalan,
            "countAvalanBlmProses"=>$countAvalanBlmProses,"avalanBlmProses"=>$avalanBlmProses,
            "countAvalanSdgProses"=>$countAvalanSdgProses,"avalanSdgProses"=>$avalanSdgProses,
            "countAvalanOk"=>$countAvalanOk,"avalanSelesai"=>$avalanOk,
            "countAvalanSelisih"=>$countAvalanSelisih,"avalanSelisih"=>$avalanSelisih
        ]);
    }

    public function showBanner() {
        $avalanBlmProses = ViewDashboardAvalan::where('status','=', '0')->get();
        $countAvalanBlmProses = count($avalanBlmProses);
        $avalanSdgProses = ViewDashboardAvalan::where('status','!=', '0')->where('status','!=', '3')->get();
        $countAvalanSdgProses = count($avalanSdgProses);
        $avalanOk = ViewDashboardAvalan::where('status','=', '3')->get();
        $countAvalanOk=count($avalanOk);
        $avalanSelisih = ViewDashboardAvalan::where('selisih','>', '0')->get();
        $countAvalanSelisih = count($avalanSelisih);
        return view("admin.dashboard.banner.banner-avalan", [
            "countAvalanBlmProses"=>$countAvalanBlmProses,
            "countAvalanSdgProses"=>$countAvalanSdgProses,
            "countAvalanOk"=>$countAvalanOk,
            "countAvalanSelisih"=>$countAvalanSelisih
        ]);
    }

    public function showMainTable()
    {
        $avalan = ViewDashboardAvalan::all();
        return view("admin.dashboard.table.avalan.main-table-avalan", ["avalan" => $avalan]);
    }

    public function showBannerTable(String $request) {
        if($request == "1") {
            $avalanBlmProses = ViewDashboardAvalan::where('status','=', '0')->get();
            return view("admin.dashboard.table.avalan.avalan-belum-proses",["avalanBlmProses"=>$avalanBlmProses]);
        } else if($request == '2') {
            $avalanSdgProses = ViewDashboardAvalan::where('status','!=', '0')->where('status','!=', '3')->get();
            return view("admin.dashboard.table.avalan.avalan-sedang-proses",["avalanSdgProses"=>$avalanSdgProses]);
        } else if($request == '3') {
            $avalanOk = ViewDashboardAvalan::where('status','=', '3')->get();
            return view("admin.dashboard.table.avalan.avalan-ok",["avalanSelesai"=>$avalanOk]);
        } else {
            $avalanSelisih = ViewDashboardAvalan::where('selisih','>', '0')->get();
            return view("admin.dashboard.table.avalan.avalan-selisih",["avalanSelisih"=>$avalanSelisih]);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AvalanProduk $avalanProduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AvalanProduk $avalanProduk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AvalanProduk $avalanProduk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AvalanProduk $avalanProduk)
    {
        //
    }
}
