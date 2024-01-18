<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin\Dashboard\AvalanProduk;
use App\Models\Admin\Master\Company;
use App\Models\Admin\Master\Group;
use App\Models\Admin\Penjadwalan\ImportAvalan;
use App\Models\ViewDashboardAvalan;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
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

        $checkCsoActive = DB::table('dbttrsheda')->where('dbttrsheda.statusdoc', '=', 'A')->get();

        $checkCsoEnd = DB::table('dbttrsheda')->where('dbttrsheda.statusdoc', '=', 'E')->get();

        $checkCsoFinal = DB::table('dbttrsheda')->where('statusdoc', '=', 'P')->get();

        $getCsoDate = DB::table('dbttrsheda')->select('startcsodate')->where('statusdoc','<>','P')->orderByDesc('trsid')->limit(1)->get();

        if(count($getCsoDate) > 0) {
            $csoDate = Carbon::parse($getCsoDate[0]->startcsodate)->format('d M Y');
        } else {
            $csoDate = "";
        }

        return view("admin.dashboard.avalan", [
            'countCsoActive' => count($checkCsoActive), 'countCsoEnd' => count($checkCsoEnd), 'countCsoFinal' => count($checkCsoFinal), 'avalan'=>$avalan,
            "countAvalanBlmProses"=>$countAvalanBlmProses,"avalanBlmProses"=>$avalanBlmProses,
            "countAvalanSdgProses"=>$countAvalanSdgProses,"avalanSdgProses"=>$avalanSdgProses,
            "countAvalanOk"=>$countAvalanOk,"avalanSelesai"=>$avalanOk,
            "countAvalanSelisih"=>($countAvalanSelisihPlus + $countAvalanSelisihMinus),"avalanSelisihPlus"=>$avalanSelisihPlus, "avalanSelisihMinus"=>$avalanSelisihMinus,
            "dbxjob" => $dbxjob, "dbmgroup" => $group, "csodate" => $csoDate
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
    public function store()
    {
        DB::beginTransaction();

        $checkDbxImport = ImportAvalan::all();

        if(count($checkDbxImport) > 0) {
            $checkCsoMaterial = DB::table('dbxmaterial')->limit(1)->get();
            $checkCsoType = DB::table('dbxcsotype')->limit(1)->get();
            $getCoy = Company::select('coycode')->where('coyid','=','1')->get();

            if(count($checkCsoMaterial) > 0 && count($checkCsoType) > 0) {
                $checkMonth = DB::table('dbttrsheda')
                ->select(DB::raw("DATE_FORMAT(startcsodate, '%m') as monthbefore"),'idxno')
                ->orderByDesc('trsid')
                ->limit(1)
                ->get();
                $idxno = 0;

                if(count($checkMonth) > 0 && $checkMonth[0]->monthbefore == Carbon::now()->month) {
                    $idxno = $checkMonth[0]->idxno + 1;
                } else {
                    $idxno = 1;
                }
                $today=Carbon::now()->format('Y-m-d');

                $doccsoid = "{$checkCsoType[0]->csotype}{$getCoy[0]->coycode}{$today}-{$idxno}";

                $insertDbttrsheda = DB::table('dbttrsheda')->insert([
                    'doccsoid' => $doccsoid,
                    'startcsodate' => $today,
                    'idxno' => $idxno,
                    'csomaterial' => $checkCsoMaterial[0]->csomaterial,
                    'statusdoc' => 'A'
                ]);

                if($insertDbttrsheda == true) {
                    $getTrsHedId = DB::table('dbttrsheda')->select('trsid')->where('statusdoc','=','A')->limit(1)->get();
                    $selectDbxImporDet = DB::table('dbximpordetavalan')->select('itembatchid',DB::raw('sum(qty)as qty'))->groupBy('itembatchid');

                    $selectDbxImpor = DB::table('dbximporavalan')
                    ->leftJoinSub($selectDbxImporDet, 'dbximpordetavalan', function (JoinClause $join) {
                        $join->on('dbximporavalan.itembatchid', '=', 'dbximpordetavalan.itembatchid');
                    })
                    ->select([DB::raw($getTrsHedId[0]->trsid),"dbximporavalan.itemid","dbximporavalan.itembatchid","itemcode","itemname",
                    DB::raw("case when dbximporavalan.batchid =0 then 0 else 1 end as isbatch"),
                    "batchid","heatno","dimension","tolerance","kondisi","qty","uom","cogs","statusitem",DB::raw(1)]);
                    
                    $insertDbttrsdet = DB::table('dbttrsdeta')->insertUsing(["trsid","itemid","itembatchid","itemcode","itemname","isbatch","batchno","heatno","dimension","tolerance","kondisi","onhand","uom","cogs","statusitem","statuscso"],$selectDbxImpor);

                    if($insertDbttrsdet == true) {
                        $getTrsDet2 = DB::table('dbttrsdeta')
                        ->join('dbttrshed','dbttrshed.trsid','=','dbttrsdeta.trsid')
                        ->select('trsdetid','itemid','itembatchid')
                        ->where('dbttrshed.statusdoc','=','A')
                        ->get();

                        foreach($getTrsDet2 as $trsDet2) {
                            $selectDbxImporDet2 = DB::table('dbximpordetavalan')
                            ->select(DB::raw($trsDet2->trsdetid),"itemid","itembatchid","batchid","wrh","qty")
                            ->where('itembatchid','=',$trsDet2->itembatchid);
                            
                            DB::table('dbttrsdet2a')->insertUsing(["trsdetid","itemid","itembatchid","batchno","wrh","qty"],$selectDbxImporDet2);
                        }

                        DB::table('dbtcsoprsn')
                        ->where('trsid','=',$getTrsHedId[0]->trsid)
                        ->update(["status"=>"P"]);

                        $finalise = DB::table("dbxsetdate")->insert(["date"=>Carbon::now(),"tipe"=>"I"]);
                        if($finalise == true) {
                            DB::commit();
                            return redirect()->route("avalan.index")->with('status', "Berhasil memulai CSO");   
                        } else {
                            DB::rollBack();
                            return redirect()->route("avalan.index")->with('error', "Gagal memulai CSO, silahkan ulangi"); 
                        }
                    } else {
                        DB::rollBack();
                        return redirect()->route("avalan.index")->with('error', "Gagal memulai CSO, silahkan ulangi"); 
                    }
                } else {
                    DB::rollBack();
                    return redirect()->route("avalan.index")->with('error', "Gagal memulai CSO, silahkan ulangi"); 
                }                
            } else {
                DB::rollBack();
                return redirect()->route("pengaturan.index")->with('error', "Harap lakukan input tipe CSO dan Materialnya terlebih dahulu");  
            }                     
        } else {
            DB::rollBack();
            return redirect()->route("import-avalan.index")->with('error', "Harap lakukan import avalan terlebih dahulu");            
        }
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
        DB::beginTransaction();

        $updateDbtTrsHeda = DB::table('dbttrsheda')
            ->where('statusdoc', '=', 'A')
            ->update(['endcsodate' => Carbon::now(), 'statusdoc' => 'E']);

        DB::table('dbtcsoheda')
            ->where('status', '=', 'A')
            ->update(['status' => 'P',]);

        // $subquery = DB::table('dbttrshed')
        //     ->select('trsid')
        //     ->where('statusdoc', 'statusdoc', 'P')
        //     ->orderByDesc('trsid')
        //     ->limit(1);

        // $selectDbtCsoHed = DB::table('dbxjob')        
        // ->join('dbtcsohed', 'dbxjob.userid', '=', 'dbtcsohed.pelakuid')
        // ->selectRaw('DISTINCT dbtcsohed.trsid,userid,username,name,dbxjob.coyid,jobtypeid,"D" as status')
        // ->where('dbtcsohed.trsid', '=', $subquery);

        // $selectDbtTrsDet = DB::table('dbxjob')        
        // ->join('dbttrsdet', 'dbttrsdet.analisatorid', '=', 'dbxjob.userid')
        // ->selectRaw('DISTINCT dbttrsdet.trsid,userid,username,name,dbxjob.coyid,jobtypeid,"D" as status')
        // ->where('dbttrsdet.trsid', '=', $subquery);

        // $unionQuery = $selectDbtCsoHed->union($selectDbtTrsDet);

        // $inserDbtCsoPrsn = DB::table('dbtcsoprsn')->insertUsing(['trsid', 'userid', 'username', 'name', 'coyid', 'jobtypeid', 'status'],$unionQuery);


        if ($updateDbtTrsHeda == true ) {
            DB::commit();
            return redirect()->route("avalan.index")->with('status', 'CSO Avalan berhasil diberhentikan');
        } else {
            DB::rollBack();
            return redirect()->route("avalan.index")->with('error', 'Gagal memberhentikan CSO Avalan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AvalanProduk $avalanProduk)
    {
        $updateDbtTrsHed = DB::table('dbttrsheda')
            ->where('statusdoc', '=', 'E')
            ->update(['statusdoc' => 'P']);

        DB::table('dbximporavalan')->truncate();
        DB::table('dbximpordetavalan')->truncate();

        DB::table('dbxsetdate')->where('tipe','=','I')->delete();

        DB::table('dbxmaterial')->truncate();

        DB::table('dbtcsoprsn')
            ->update(['status' => 'P']);

        DB::table('dbxjob')->truncate();
        DB::table('dbxcsotype')->truncate();

        // if($updateDbtTrsHed == true ) {
            // DB::commit();
            return redirect()->route("avalan.index")->with('status', 'CSO avalan berhasil diakhiri');
        // } else {
        //     DB::rollBack();
        //     return redirect()->route("item.index")->with('error', 'Gagal mengakhiri CSO');
        // }
    }
}
