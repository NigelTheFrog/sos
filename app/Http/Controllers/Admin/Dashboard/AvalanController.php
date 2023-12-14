<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin\Dashboard\AvalanProduk;
use App\Models\Admin\Master\Group;
use App\Models\ViewDashboardAvalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

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
        $avalanSelisihPlus = ViewDashboardAvalan::where('selisih','>', '0')->get();
        $countAvalanSelisihPlus = count($avalanSelisihPlus);
        $avalanSelisihMinus = ViewDashboardAvalan::where('selisih','<', '0')->get();
        $countAvalanSelisihMinus = count($avalanSelisihMinus);
        $dbxjob = DB::table('dbxjob')->where('jobtypeid','=',2)->get();
        $group = Group::all();
        return view("admin.dashboard.avalan", [
            'avalan'=>$avalan,
            "countAvalanBlmProses"=>$countAvalanBlmProses,"avalanBlmProses"=>$avalanBlmProses,
            "countAvalanSdgProses"=>$countAvalanSdgProses,"avalanSdgProses"=>$avalanSdgProses,
            "countAvalanOk"=>$countAvalanOk,"avalanSelesai"=>$avalanOk,
            "countAvalanSelisih"=>($countAvalanSelisihPlus + $countAvalanSelisihMinus),"avalanSelisihPlus"=>$avalanSelisihPlus, "avalanSelisihMinus"=>$avalanSelisihMinus,
            "dbxjob" => $dbxjob, "dbmgroup" => $group
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

    public function print(String $request)
    {

        $pdf = App::make('dompdf.wrapper');
        
        if($request =="1") {
            $data = ViewDashboardAvalan::where('status', '=', '0')->get();
            $view = view("admin.dashboard.pdf-avalan", ["avalanBlmProses" => $data, "type"=>1]);
        } elseif($request =="2") {
            $data = ViewDashboardAvalan::where('status', '!=', '0')->where('status', '!=', '3')->get();
            $view = view("admin.dashboard.pdf-avalan", ["avalanSdgProses" => $data, "type"=>2]);
        } elseif($request =="3") {
            $data =  ViewDashboardAvalan::where('status', '=', '3')->get();
            $view = view("admin.dashboard.pdf-avalan", ["avalanSelesai" => $data, "type"=>3]);
        } else {
            $dataPlus = ViewDashboardAvalan::where('selisih', '>', '0')->get();
            $dataMinus = ViewDashboardAvalan::where('selisih', '<', '0')->get();
            $view = view("admin.dashboard.pdf-avalan", ["avalanSelisihPlus" => $dataPlus, "avalanSelisihMinus" => $dataMinus, "type"=>4]);
        }
        $pdf->loadHTML($view);
        return $pdf->stream();
    }

    public function showMainTable()
    {
        $avalan = ViewDashboardAvalan::all();
        return view("admin.dashboard.table.avalan.main-table-avalan", ["avalan" => $avalan]);
    }

    public function showBannerTable(String $request) {
        $dbxjob = DB::table('dbxjob')->where('jobtypeid','=',2)->get();
        $group = Group::all();

        if($request == "1") {
            $avalanBlmProses = ViewDashboardAvalan::where('status','=', '0')->get();
            return view("admin.dashboard.table.avalan.avalan-belum-proses",[
                "avalanBlmProses"=>$avalanBlmProses,
                "dbxjob" => $dbxjob, "dbmgroup" => $group
            ]);
        } else if($request == '2') {
            $avalanSdgProses = ViewDashboardAvalan::where('status','!=', '0')->where('status','!=', '3')->get();
            return view("admin.dashboard.table.avalan.avalan-sedang-proses",[
                "avalanSdgProses"=>$avalanSdgProses,
                "dbxjob" => $dbxjob, "dbmgroup" => $group
            ]);
        } else if($request == '3') {
            $avalanOk = ViewDashboardAvalan::where('status','=', '3')->get();
            return view("admin.dashboard.table.avalan.avalan-ok",[
                "avalanSelesai"=>$avalanOk,
                "dbxjob" => $dbxjob, "dbmgroup" => $group
            ]);
        } else {
            $avalanSelisihPlus = ViewDashboardAvalan::where('selisih','>', '0')->get();
            $avalanSelisihMinus = ViewDashboardAvalan::where('selisih','<', '0')->get();
            return view("admin.dashboard.table.avalan.avalan-selisih",[
                "avalanSelisihPlus"=>$avalanSelisihPlus, "avalanSelisihMinus"=>$avalanSelisihMinus,
                "dbxjob" => $dbxjob, "dbmgroup" => $group
            ]);
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
