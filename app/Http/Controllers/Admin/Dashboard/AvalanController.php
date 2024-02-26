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
        $avalanBlmProses = ViewDashboardAvalan::where('status', '=', '0')->get();
        $countAvalanBlmProses = count($avalanBlmProses);
        $avalanOk = ViewDashboardAvalan::where('status', '=', '3')->get();
        $countAvalanOk = count($avalanOk);
        $avalanSelisihPlus = ViewDashboardAvalan::where('selisih', '>', '0')->get();
        $countAvalanSelisihPlus = count($avalanSelisihPlus);
        $avalanSelisihMinus = ViewDashboardAvalan::where('selisih', '<', '0')->get();
        $countAvalanSelisihMinus = count($avalanSelisihMinus);
        $dbxjob = DB::table('dbxjob')->where('jobtypeid', '=', 2)->get();
        $group = Group::all();

        $checkCsoActive = DB::table('dbttrsheda')->where('dbttrsheda.statusdoc', '=', 'A')->get();

        $checkCsoEnd = DB::table('dbttrsheda')->where('dbttrsheda.statusdoc', '=', 'E')->get();

        $checkCsoFinal = DB::table('dbttrsheda')->where('statusdoc', '=', 'P')->get();

        $getCsoDate = DB::table('dbttrsheda')->select('startcsodate')->where('statusdoc', '<>', 'P')->orderByDesc('trsid')->limit(1)->get();

        if (count($getCsoDate) > 0) {
            $csoDate = Carbon::parse($getCsoDate[0]->startcsodate)->format('d M Y');
        } else {
            $csoDate = "Belum ada tanggal CSO";
        }

        return view("admin.dashboard.avalan", [
            'countCsoActive' => count($checkCsoActive), 'countCsoEnd' => count($checkCsoEnd), 'countCsoFinal' => count($checkCsoFinal), 'avalan' => $avalan,
            "countAvalanBlmProses" => $countAvalanBlmProses, "avalanBlmProses" => $avalanBlmProses,
            "countAvalanOk" => $countAvalanOk, "avalanSelesai" => $avalanOk,
            "countAvalanSelisih" => ($countAvalanSelisihPlus + $countAvalanSelisihMinus), "avalanSelisihPlus" => $avalanSelisihPlus, "avalanSelisihMinus" => $avalanSelisihMinus,
            "dbxjob" => $dbxjob, "dbmgroup" => $group, "csodate" => $csoDate
        ]);
    }

    public function checkAvalanBlmProses() {
        $itemBlmProses = ViewDashboardAvalan::where('status', '=', '0')->get();

        return response()->json(['data' => count($itemBlmProses)]);
    }

    public function showBanner()
    {
        $avalanBlmProses = ViewDashboardAvalan::where('status', '=', '0')->get();
        $countAvalanBlmProses = count($avalanBlmProses);
        $avalanOk = ViewDashboardAvalan::where('status', '=', '3')->get();
        $countAvalanOk = count($avalanOk);
        $avalanSelisih = ViewDashboardAvalan::where('selisih', '>', '0')->get();
        $countAvalanSelisih = count($avalanSelisih);
        return view("admin.dashboard.banner.banner-avalan", [
            "countAvalanBlmProses" => $countAvalanBlmProses,
            "countAvalanOk" => $countAvalanOk,
            "countAvalanSelisih" => $countAvalanSelisih
        ]);
    }

    public function print(String $request)
    {

        $pdf = App::make('dompdf.wrapper');

        if ($request == "1") {
            $data = ViewDashboardAvalan::where('status', '=', '0')->get();
            $view = view("admin.dashboard.pdf-avalan", ["avalanBlmProses" => $data, "type" => 1]);
        } elseif ($request == "3") {
            $data =  ViewDashboardAvalan::where('status', '=', '3')->get();
            $view = view("admin.dashboard.pdf-avalan", ["avalanSelesai" => $data, "type" => 3]);
        } else {
            $dataPlus = ViewDashboardAvalan::where('selisih', '>', '0')->get();
            $dataMinus = ViewDashboardAvalan::where('selisih', '<', '0')->get();
            $view = view("admin.dashboard.pdf-avalan", ["avalanSelisihPlus" => $dataPlus, "avalanSelisihMinus" => $dataMinus, "type" => 4]);
        }
        $pdf->loadHTML($view);
        return $pdf->stream();
    }

    public function showMainTable(Request $request)
    {
        $avalan = ViewDashboardAvalan::where('itemname', 'like', '%' . $request->search . '%')
            ->orWhere('itemcode', 'like', '%' . $request->search . '%')
            ->orWhere('itemid', 'like', '%' . $request->search . '%')
            ->orWhere('batchno', 'like', '%' . $request->search . '%')
            ->orWhere('analisator', 'like', '%' . $request->search . '%')
            ->orWhere('analisatorid', 'like', '%' . $request->search . '%')
            ->orWhere('statusname', 'like', '%'.$request->search.'%')
            ->get();;
        return view("admin.dashboard.table.avalan.main-table-avalan", ["avalan" => $avalan]);
    }

    public function showBannerTable(String $request)
    {
        $dbxjob = DB::table('dbxjob')->where('jobtypeid', '=', 2)->get();
        $group = Group::all();

        if ($request == "1") {
            $avalanBlmProses = ViewDashboardAvalan::where('status', '=', '0')->get();
            return view("admin.dashboard.table.avalan.avalan-belum-proses", [
                "avalanBlmProses" => $avalanBlmProses,
                "dbxjob" => $dbxjob, "dbmgroup" => $group
            ]);
        } else if ($request == '2') {
            $avalanSdgProses = ViewDashboardAvalan::where('status', '!=', '0')->where('status', '!=', '3')->get();
            return view("admin.dashboard.table.avalan.avalan-sedang-proses", [
                "avalanSdgProses" => $avalanSdgProses,
                "dbxjob" => $dbxjob, "dbmgroup" => $group
            ]);
        } else if ($request == '3') {
            $avalanOk = ViewDashboardAvalan::where('status', '=', '3')->get();
            return view("admin.dashboard.table.avalan.avalan-ok", [
                "avalanSelesai" => $avalanOk,
                "dbxjob" => $dbxjob, "dbmgroup" => $group
            ]);
        } else {
            $avalanSelisihPlus = ViewDashboardAvalan::where('selisih', '>', '0')->get();
            $avalanSelisihMinus = ViewDashboardAvalan::where('selisih', '<', '0')->get();
            return view("admin.dashboard.table.avalan.avalan-selisih", [
                "avalanSelisihPlus" => $avalanSelisihPlus, "avalanSelisihMinus" => $avalanSelisihMinus,
                "dbxjob" => $dbxjob, "dbmgroup" => $group
            ]);
        }
    }

    public function csoUlang(Request $request)
    {
        DB::beginTransaction();
        $updateLCso = DB::table('dbtcsodet')
            ->leftJoin('dbtcsohed', 'dbtcsodet.csoid', '=', 'dbtcsohed.csoid')
            ->where('dbtcsodet.itembatchid', $request->itembatchid)
            ->where('dbtcsohed.status', 'A')
            ->update(['statushslcso' => 'C']);

        if ($updateLCso == true) {
            $getDataDbtCsoDet = DB::table('dbtcsodet')
                ->leftJoin('dbtcsohed', 'dbtcsodet.csoid', '=', 'dbtcsohed.csoid')
                ->select(DB::raw("dbtcsodet.csoid, dbtcsodet.itemid, dbtcsodet.itembatchid, dbtcsodet.locationid, dbtcsodet.grade, 'A', 'D', 'T' "))
                ->where('dbtcsodet.itembatchid', $request->itembatchid)
                ->where('dbtcsohed.status', '=', 'A')
                ->groupBy('dbtcsodet.itemid');

            $insertDbtCsoDet = DB::table('dbtcsodet')->insertUsing(['csoid', 'itemid', 'itembatchid', 'locationid', 'grade', 'statusitem', 'statussubmit', 'statushslcso'], $getDataDbtCsoDet);

            if ($insertDbtCsoDet == true) {
                $getDbtCsoDetOnDbtCsoDet2 = DB::table('dbtcsodet')
                    ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                    ->select(DB::raw("dbtcsodet.itemid, dbtcsodet.itembatchid, (dbtcsodet2.csocount+1) as count"))
                    ->where('dbtcsodet.itembatchid', $request->itembatchid)
                    ->where('dbtcsodet.statushslcso', '=', 'C');

                $getDbtCsoDetOnDbtCsoHed = DB::table('dbtcsodet')
                    ->leftJoin('dbtcsohed', 'dbtcsohed.csoid', '=', 'dbtcsodet.csoid')
                    ->leftJoinSub($getDbtCsoDetOnDbtCsoDet2, 'dbtcsodet2', function ($join) {
                        $join->on('dbtcsodet2.itemid', '=', 'dbtcsodet.itemid');
                    })
                    ->select(['dbtcsodet.csodetid', 'dbtcsodet.csoid', 'dbtcsodet2.count'])
                    ->where('dbtcsodet.itembatchid', $request->itembatchid)
                    ->where('dbtcsodet.statushslcso', '=', 'T')
                    ->where('dbtcsohed.status', '=', 'A')
                    ->groupBy('dbtcsodet.itemid');

                $insertDbtCsoDet2 = DB::table('dbtcsodet2')->insertUsing(['csodetid', 'csoid', 'csocount'], $getDbtCsoDetOnDbtCsoHed);

                if ($insertDbtCsoDet2 == true) {
                    $updateDbtTrsDet = DB::table('dbttrsdeta')
                        ->where('itembatchid', $request->itembatchid)
                        ->increment('statuscso');
                    if ($updateDbtTrsDet == true) {
                        DB::commit();
                        return response()->json(['result' => 1]);
                    } else {
                        DB::rollBack();
                        return response()->json(['result' => 0]);
                    }
                } else {
                    DB::rollBack();
                    return response()->json(['result' => 0]);
                }
            } else {
                DB::rollBack();
                return response()->json(['result' => 0]);
            }
        } else {
            DB::rollBack();
            return response()->json(['result' => 0]);
        }
    }

    public function updateCsoAvalan(Request $request)
    {
        DB::beginTransaction();
        if (!empty($request->check_kesalahan_admin)) {
            $kesalahan = 1;
        } else {
            $kesalahan = 0;
        }

        $updateAvalan = DB::table('dbttrsdeta')
        ->where('dbttrsdeta.itembatchid', '=', $request->itembatchid)
            ->where('dbttrsdeta.trsdetid', '=', $request->trsdetid)
            ->update([
                'koreksi' => $request->koreksi,
                'deviasi' => $request->deviasi,
                'analisatorid' => $request->analisator,
                'keterangan' => $request->keterangan,
                'groupid' => $request->grouping,
                'kesalahan_admin' => $kesalahan
            ]);        

        if ($updateAvalan == true) {
            DB::commit();
            return redirect()->route("avalan.index")->with('status', "Berhasil mengubah data CSO avalan");
        } else {
            DB::rollBack();
            return redirect()->route("avalan.index")->with('error', "Gagal mengubah data CSO avalan");
        }
    }

    public function showDetailCsoAvalan(Request $request)
    {
        $data = ViewDashboardAvalan::where('itembatchid', '=', $request->itembatchid)->get();

        $dataAnalisator = DB::table('dbttrsdeta')
            ->join('dbttrsheda', 'dbttrsheda.trsid', '=', 'dbttrsdeta.trsid')
            ->leftJoin('dbmuser', 'dbttrsdeta.analisatorid', '=', 'dbmuser.userid')
            ->leftJoin('dbmgroup', 'dbmgroup.groupid', '=', 'dbttrsdeta.groupid')
            ->select(["dbttrsdeta.groupid", "dbttrsdeta.analisatorid", "dbmgroup.groupdesc", "name", "kesalahan_admin"])
            ->where('itembatchid', '=', $request->itembatchid)
            ->where('dbttrsheda.statusdoc', '=', 'A')
            ->whereNotNull('analisatorid')
            ->get();
        

        $dataDetailDashboard = DB::table('viewdetaildashbavalan')->distinct()->where('itembatchid', '=', $request->itembatchid)->get();

        $dataTotalCso = DB::table('dbttrsdeta')
            ->leftJoin('totalcso1avalan', 'totalcso1avalan.itembatchid', '=', 'dbttrsdeta.itembatchid')
            ->leftJoin('totalcso2avalan', 'totalcso2avalan.itembatchid', '=', 'dbttrsdeta.itembatchid')
            ->leftJoin('totalcso3avalan', 'totalcso3avalan.itembatchid', '=', 'dbttrsdeta.itembatchid')
            ->leftJoin('totalcso4avalan', 'totalcso4avalan.itembatchid', '=', 'dbttrsdeta.itembatchid')
            ->select('dbttrsdeta.itembatchid')
            ->selectRaw('ifnull(totalcso1avalan.qtytot,0) as totalcso1')
            ->selectRaw('ifnull(totalcso2avalan.qtytot,0) as totalcso2')
            ->selectRaw('ifnull(totalcso3avalan.qtytot,0) as totalcso3')
            ->selectRaw('ifnull(totalcso4avalan.qtytot,0) as totalcso4')
            ->where('dbttrsdeta.itembatchid', '=', $request->itembatchid)
            ->distinct()
            ->get();

        $cekCso = DB::table('dbtcsodet2')
            ->select('dbtcsodet2.csodet2id', 'dbtcsodet.csodetid', 'dbtcsodet.csoid', 'dbtcsodet.itemid', 'dbtcsodet.itembatchid', 'dbttrsdeta.itemname', 'dbtcsodet2.csocount', 'dbtcsodet2.qty', 'dbttrsdeta.statuscso')
            ->leftJoin('dbtcsodet', 'dbtcsodet.csodetid', '=', 'dbtcsodet2.csodetid')
            ->leftJoin('dbtcsohed', 'dbtcsohed.csoid', '=', 'dbtcsodet2.csoid')
            ->leftJoin('dbttrsdeta', 'dbttrsdeta.itembatchid', '=', 'dbtcsodet.itembatchid')
            ->leftJoin('viewdashboardavalan', 'viewdashboardavalan.itembatchid', '=', 'dbtcsodet.itembatchid')
            ->where('dbttrsdeta.itembatchid', '=',  $request->itembatchid)
            ->whereNotNull('dbtcsodet2.qty')
            ->whereColumn('csocount', 'viewdashboardavalan.statuscso')
            ->where('statussubmit', 'P')
            ->where('dbtcsohed.status', 'A')
            ->get();

            $dataCsoCount = DB::table('viewdetaildashb')
            ->select(['name'])
            ->selectRaw('SUM(cso1) over (partition by name) as cso1')
            ->selectRaw('SUM(cso2) over (partition by name) as cso2')
            ->selectRaw('SUM(cso3) over (partition by name) as cso3')
            ->selectRaw('SUM(cso4) over (partition by name) as cso4')
            ->where('itembatchid', '=', $request->id . $request->batchno)
            ->distinct()
            ->get();

        $dataGroup = Group::all();

        $dataDbxJob = DB::table('analisator')
            ->select(['userid', 'name'])
            ->distinct()
            ->get();

         $cekItem = DB::table('dbttrsdeta')
            ->select('dbttrsdeta.statusitem','dbttrsdeta.trsid')
            ->leftjoin('dbttrsheda', 'dbttrsheda.trsid', '=', 'dbttrsdeta.trsid')
            ->where('dbttrsdeta.itembatchid', '=',  $request->itembatchid)
            ->where('dbttrsheda.statusdoc', '=', 'A')
            ->get();        

        return view('admin.dashboard.table.avalan.detail-cso-avalan', [
                "itemid" => $data[0]->itemid,
                "batchno" => $data[0]->batchno,
                "itembatchid" => $data[0]->itembatchid,
                "trsdetid" => $data[0]->trsdetid,
                "tolerance" => $data[0]->tolerance,
                "onhand" => $data[0]->onhand,
                "totalcso" => $data[0]->totalcso,
                "selisih" => $data[0]->selisih,
                "koreksi" => $data[0]->koreksi,
                "deviasi" => $data[0]->deviasi,
                "keterangan" => $data[0]->keterangan,
                "tableDetailDashboard" => $dataDetailDashboard,
                "dataCso" => $dataCsoCount,
                "totalCso" => $dataTotalCso,
                "analisator" => $dataAnalisator,
                "group" => $dataGroup,
                "dbxJob" => $dataDbxJob,
                "checkCso" => count($cekCso),
                "checkItemType" => $cekItem[0]
        ]);
    }

    public function hapusTemuanAvalan(Request $request)
    {
        DB::beginTransaction();

        $deleteDataFromDbtTrsDet = DB::table('dbttrsdeta')
            ->where('dbttrsdeta.itembatchid', '=', $request->itembatchid)
            ->where('dbttrsdeta.trsdetid', '=', $request->trsdetid)
            ->delete();

        if ($deleteDataFromDbtTrsDet == true) {
            $deleteDataFromDbxImpor = DB::table('dbximporavalan')
                ->where('dbximporavalan.itemid', '=', $request->itembatchid)
                ->delete();
            if ($deleteDataFromDbxImpor == true) {
                DB::commit();
                return response()->json(['result' => 1]);
            } else {
                DB::rollBack();
                return response()->json(['result' => 0]); 
            }
        } else {
            DB::rollBack();
            return response()->json(['result' => 0]);
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

        if (count($checkDbxImport) > 0) {
            $checkCsoMaterial = DB::table('dbxmaterial')->limit(1)->get();
            $checkCsoType = DB::table('dbxcsotype')->limit(1)->get();
            $getCoy = Company::select('coycode')->where('coyid', '=', '1')->get();

            if (count($checkCsoMaterial) > 0 && count($checkCsoType) > 0) {
                $checkMonth = DB::table('dbttrsheda')
                    ->select(DB::raw("DATE_FORMAT(startcsodate, '%m') as monthbefore"), 'idxno')
                    ->orderByDesc('trsid')
                    ->limit(1)
                    ->get();
                $idxno = 0;

                if (count($checkMonth) > 0 && $checkMonth[0]->monthbefore == Carbon::now()->month) {
                    $idxno = $checkMonth[0]->idxno + 1;
                } else {
                    $idxno = 1;
                }
                $today = Carbon::now()->format('Y-m-d');

                $doccsoid = "{$checkCsoType[0]->csotype}{$getCoy[0]->coycode}{$today}-{$idxno}";

                $insertDbttrsheda = DB::table('dbttrsheda')->insert([
                    'doccsoid' => $doccsoid,
                    'startcsodate' => $today,
                    'idxno' => $idxno,
                    'csomaterial' => $checkCsoMaterial[0]->csomaterial,
                    'statusdoc' => 'A'
                ]);

                if ($insertDbttrsheda == true) {
                    $getTrsHedId = DB::table('dbttrsheda')->select('trsid')->where('statusdoc', '=', 'A')->limit(1)->get();
                    $selectDbxImporDet = DB::table('dbximpordetavalan')->select('itembatchid', DB::raw('sum(qty)as qty'))->groupBy('itembatchid');

                    $selectDbxImpor = DB::table('dbximporavalan')
                        ->leftJoinSub($selectDbxImporDet, 'dbximpordetavalan', function (JoinClause $join) {
                            $join->on('dbximporavalan.itembatchid', '=', 'dbximpordetavalan.itembatchid');
                        })
                        ->select([
                            DB::raw($getTrsHedId[0]->trsid), "dbximporavalan.itemid", "dbximporavalan.itembatchid", "itemcode", "itemname",
                            DB::raw("case when dbximporavalan.batchid =0 then 0 else 1 end as isbatch"),
                            "batchid", "heatno", "dimension", "tolerance", "kondisi", "qty", "uom", "cogs", "statusitem", DB::raw(1)
                        ]);

                    $insertDbttrsdet = DB::table('dbttrsdeta')->insertUsing(["trsid", "itemid", "itembatchid", "itemcode", "itemname", "isbatch", "batchno", "heatno", "dimension", "tolerance", "kondisi", "onhand", "uom", "cogs", "statusitem", "statuscso"], $selectDbxImpor);

                    if ($insertDbttrsdet == true) {
                        $getTrsDet2 = DB::table('dbttrsdeta')
                            ->join('dbttrshed', 'dbttrshed.trsid', '=', 'dbttrsdeta.trsid')
                            ->select('trsdetid', 'itemid', 'itembatchid')
                            ->where('dbttrshed.statusdoc', '=', 'A')
                            ->get();

                        foreach ($getTrsDet2 as $trsDet2) {
                            $selectDbxImporDet2 = DB::table('dbximpordetavalan')
                                ->select(DB::raw($trsDet2->trsdetid), "itemid", "itembatchid", "batchid", "wrh", "qty")
                                ->where('itembatchid', '=', $trsDet2->itembatchid);

                            DB::table('dbttrsdet2a')->insertUsing(["trsdetid", "itemid", "itembatchid", "batchno", "wrh", "qty"], $selectDbxImporDet2);
                        }

                        DB::table('dbtcsoprsn')
                            ->where('trsid', '=', $getTrsHedId[0]->trsid)
                            ->update(["status" => "P"]);

                        $finalise = DB::table("dbxsetdate")->insert(["date" => Carbon::now(), "tipe" => "I"]);
                        if ($finalise == true) {
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

        DB::table('dbtcsohed')
            ->where('status', '=', 'A')
            ->where('tipecso', '=', 'A')
            ->update(['status' => 'P',]);

        $insertDbtCsoPrsn = DB::insert("INSERT INTO dbtcsoprsn (trsid,userid,username,name,coyid,jobtypeid,status,tipecso)
        SELECT DISTINCT ch.trsid,userid,username,name,j.coyid,jobtypeid,'D','A' as status FROM dbxjob j 
        INNER JOIN dbtcsohed ch ON j.userid = ch.pelakuid 
        WHERE ch.trsid = (SELECT trsid FROM dbttrsheda WHERE statusdoc='E' ORDER BY trsid DESC LIMIT 1) AND ch.tipecso = 'A'
        UNION 
        SELECT DISTINCT td.trsid,userid,username,name,j.coyid,jobtypeid,'D','A' as status FROM dbxjob j 
        INNER JOIN dbttrsdet td ON td.analisatorid =j.userid
        WHERE td.trsid = (SELECT trsid FROM dbttrsheda WHERE statusdoc='E' ORDER BY trsid DESC LIMIT 1) AND ch.tipecso = 'A'");


        if ($updateDbtTrsHeda == true) {
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

        DB::table('dbxsetdate')->where('tipe', '=', 'I')->delete();

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
