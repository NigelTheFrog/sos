<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin\Dashboard\Item;
use App\Models\Admin\Master\Company;
use App\Models\Admin\Master\Group;
use App\Models\Admin\Penjadwalan\ImportItem;
use App\Models\ViewDashboard;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use \NumberFormatter;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = ViewDashboard::all();
        $checkCsoActive = DB::table('dbttrshed')->where('dbttrshed.statusdoc', '=', 'A')->get();

        $checkCsoEnd = DB::table('dbttrshed')->where('dbttrshed.statusdoc', '=', 'E')->get();

        $checkCsoFinal = DB::table('dbttrshed')->where('statusdoc', '=', 'P')->get();

        $getCsoDate = DB::table('dbttrshed')->select('startcsodate')->where('statusdoc', '!=', 'P')->orderByDesc('trsid')->limit(1)->get();

        if (count($getCsoDate) > 0) {
            $csoDate = Carbon::parse($getCsoDate[0]->startcsodate)->format('d M Y');
        } else {
            $csoDate = "Belum ada tanggal CSO"; 
        }

        $itemBlmProses = ViewDashboard::where('status', '=', '0')->get();
        $itemSdgProses = ViewDashboard::where('status', '!=', '0')->where('status', '!=', '3')->get();
        $itemOk = ViewDashboard::where('status', '=', '3')->get();
        $itemSelisihPlus = ViewDashboard::where('selisih', '>', '0')->get();
        $itemSelisihMinus = ViewDashboard::where('selisih', '<', '0')->get();
        $dbxjob = DB::table('dbxjob')->where('jobtypeid', '=', 2)->get();
        $group = Group::all();

        return view("admin.dashboard.item", [
            'countCsoActive' => count($checkCsoActive), 'countCsoEnd' => count($checkCsoEnd), 'countCsoFinal' => count($checkCsoFinal), 'item' => $item,
            "countItemBlmProses" => count($itemBlmProses), "itemBlmProses" => $itemBlmProses,
            "countItemSdgProses" => count($itemSdgProses), "itemSdgProses" => $itemSdgProses,
            "countItemOk" => count($itemOk), "itemSelesai" => $itemOk,
            "countItemSelisih" => (count($itemSelisihPlus) + count($itemSelisihMinus)), "itemSelisihPlus" => $itemSelisihPlus, "itemSelisihMinus" => $itemSelisihMinus,
            "dbxjob" => $dbxjob, "dbmgroup" => $group, "csodate" => $csoDate
        ]);
    }

    public function showBanner()
    {
        $itemBlmProses = ViewDashboard::where('status', '=', '0')->get();
        $itemSdgProses = ViewDashboard::where('status', '!=', '0')->where('status', '!=', '3')->get();
        $itemOk = ViewDashboard::where('status', '=', '3')->get();
        $itemSelisih = ViewDashboard::where('selisih', '>', '0')->get();
        return view("admin.dashboard.banner.banner-item", [
            "countItemBlmProses" => count($itemBlmProses),
            "countItemSdgProses" => count($itemSdgProses),
            "countItemOk" => count($itemOk),
            "countItemSelisih" => count($itemSelisih)
        ]);
    }

    public function print(String $request)
    {

        $pdf = App::make('dompdf.wrapper');

        if ($request == "1") {
            $data = ViewDashboard::where('status', '=', '0')->get();
            $view = view("admin.dashboard.pdf-item", ["itemBlmProses" => $data, "type" => 1]);
        } elseif ($request == "2") {
            $data = ViewDashboard::where('status', '!=', '0')->where('status', '!=', '3')->get();
            $view = view("admin.dashboard.pdf-item", ["itemSdgProses" => $data, "type" => 2]);
        } elseif ($request == "3") {
            $data =  ViewDashboard::where('status', '=', '3')->get();
            $view = view("admin.dashboard.pdf-item", ["itemSelesai" => $data, "type" => 3]);
        } else {
            $dataPlus = ViewDashboard::where('selisih', '>', '0')->get();
            $dataMinus = ViewDashboard::where('selisih', '<', '0')->get();
            $view = view("admin.dashboard.pdf-item", ["itemSelisihPlus" => $dataPlus, "itemSelisihMinus" => $dataMinus, "type" => 4]);
        }
        $pdf->loadHTML($view);
        return $pdf->stream();
    }

    public function showMainTable()
    {
        $item = ViewDashboard::all();
        return view("admin.dashboard.table.item.main-table-item", ["item" => $item]);
    }



    public function showBannerTable(String $request)
    {
        $dbxjob = DB::table('dbxjob')->where('jobtypeid', '=', 2)->get();
        $group = Group::all();
        if ($request == "1") {
            $itemBlmProses = ViewDashboard::where('status', '=', '0')->get();
            $view = view("admin.dashboard.table.item.item-belum-proses", [
                "itemBlmProses" => $itemBlmProses,
                "dbxjob" => $dbxjob, "dbmgroup" => $group
            ]);
        } else if ($request == '2') {
            $itemSdgProses = ViewDashboard::where('status', '!=', '0')->where('status', '!=', '3')->get();
            $view = view("admin.dashboard.table.item.item-sedang-proses", [
                "itemSdgProses" => $itemSdgProses,
                "dbxjob" => $dbxjob, "dbmgroup" => $group
            ]);
        } else if ($request == '3') {
            $itemOk = ViewDashboard::where('status', '=', '3')->get();
            $view = view("admin.dashboard.table.item.item-ok", [
                "itemSelesai" => $itemOk,
                "dbxjob" => $dbxjob, "dbmgroup" => $group
            ]);
        } else {
            $itemSelisihPlus = ViewDashboard::where('selisih', '>', '0')->get();
            $itemSelisihMinus = ViewDashboard::where('selisih', '<', '0')->get();
            $view = view("admin.dashboard.table.item.item-selisih", [
                "itemSelisihPlus" => $itemSelisihPlus, "itemSelisihMinus" => $itemSelisihMinus,
                "dbxjob" => $dbxjob, "dbmgroup" => $group
            ]);
        }
        return $view;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        DB::beginTransaction();

        $checkDbxImport = ImportItem::all();

        if (count($checkDbxImport) > 0) {
            $checkCsoMaterial = DB::table('dbxmaterial')->limit(1)->get();
            $checkCsoType = DB::table('dbxcsotype')->limit(1)->get();
            $getCoy = Company::select('coycode')->where('coyid', '=', '1')->get();

            if (count($checkCsoMaterial) > 0 && count($checkCsoType) > 0) {
                $checkMonth = DB::table('dbttrshed')
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

                $insertDbttrshed = DB::table('dbttrshed')->insert([
                    'doccsoid' => $doccsoid,
                    'startcsodate' => $today,
                    'idxno' => $idxno,
                    'csomaterial' => $checkCsoMaterial[0]->csomaterial,
                    'statusdoc' => 'A'
                ]);

                if ($insertDbttrshed == true) {
                    $getTrsHedId = DB::table('dbttrshed')->select('trsid')->where('statusdoc', '=', 'A')->limit(1)->get();
                    $selectDbxImporDet = DB::table('dbximpordet')->select('itembatchid', DB::raw('sum(qty)as qty'))->groupBy('itembatchid');

                    $selectDbxImpor = DB::table('dbximpor')
                        ->leftJoinSub($selectDbxImporDet, 'dbximpordet', function (JoinClause $join) {
                            $join->on('dbximpor.itembatchid', '=', 'dbximpordet.itembatchid');
                        })
                        ->select([
                            DB::raw($getTrsHedId[0]->trsid), "dbximpor.itemid", "dbximpor.itembatchid", "itemcode", "itemname",
                            DB::raw("case when dbximpor.batchid =0 then 0 else 1 end as isbatch"),
                            "batchid", "heatno", "dimension", "tolerance", "kondisi", "qty", "uom", "cogs", "statusitem", DB::raw(1)
                        ]);

                    $insertDbttrsdet = DB::table('dbttrsdet')->insertUsing(["trsid", "itemid", "itembatchid", "itemcode", "itemname", "isbatch", "batchno", "heatno", "dimension", "tolerance", "kondisi", "onhand", "uom", "cogs", "statusitem", "statuscso"], $selectDbxImpor);

                    if ($insertDbttrsdet == true) {
                        $getTrsDet2 = DB::table('dbttrsdet')
                            ->join('dbttrshed', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
                            ->select('trsdetid', 'itemid', 'itembatchid')
                            ->where('dbttrshed.statusdoc', '=', 'A')
                            ->get();

                        foreach ($getTrsDet2 as $trsDet2) {
                            $selectDbxImporDet2 = DB::table('dbximpordet')
                                ->select(DB::raw($trsDet2->trsdetid), "itemid", "itembatchid", "batchid", "wrh", "qty")
                                ->where('itembatchid', '=', $trsDet2->itembatchid);

                            DB::table('dbttrsdet2')->insertUsing(["trsdetid", "itemid", "itembatchid", "batchno", "wrh", "qty"], $selectDbxImporDet2);
                        }

                        DB::table('dbtcsoprsn')
                            ->where('trsid', '=', $getTrsHedId[0]->trsid)
                            ->update(["status" => "P"]);

                        $finalise = DB::table("dbxsetdate")->insert(["date" => Carbon::now(), "tipe" => "I"]);
                        if ($finalise == true) {
                            DB::commit();
                            return redirect()->route("item.index")->with('status', "Berhasil memulai CSO");
                        } else {
                            DB::rollBack();
                            return redirect()->route("item.index")->with('error', "Gagal memulai CSO, silahkan ulangi");
                        }
                    } else {
                        DB::rollBack();
                        return redirect()->route("item.index")->with('error', "Gagal memulai CSO, silahkan ulangi");
                    }
                } else {
                    DB::rollBack();
                    return redirect()->route("item.index")->with('error', "Gagal memulai CSO, silahkan ulangi");
                }
            } else {
                DB::rollBack();
                return redirect()->route("pengaturan.index")->with('error', "Harap lakukan input tipe CSO dan Materialnya terlebih dahulu");
            }
        } else {
            DB::rollBack();
            return redirect()->route("import-stok.index")->with('error', "Harap lakukan import item terlebih dahulu");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    public function updateCsoItem(Request $request)
    {
        DB::beginTransaction();
        if (!empty($request->check_kesalahan_admin)) {
            $kesalahan = 1;
        } else {
            $kesalahan = 0;
        }
        if ($request->batchno == null) {
            $updateAvalan = DB::table('dbttrsdet')
                ->where('itemid', $request->itemid)
                ->update([
                    'koreksi' => $request->koreksi,
                    'deviasi' => $request->deviasi,
                    'analisatorid' => $request->analisator,
                    'keterangan' => $request->keterangan,
                    'groupid' => $request->grouping,
                    'kesalahan_admin' => $kesalahan
                ]);
        } else {
            $updateAvalan = DB::table('dbttrsdet')
                ->where('itemid', $request->itemid)
                ->where('batchno', $request->batchno)
                ->update([
                    'koreksi' => $request->koreksi,
                    'deviasi' => $request->deviasi,
                    'analisatorid' => $request->analisator,
                    'keterangan' => $request->keterangan,
                    'groupid' => $request->grouping,
                    'kesalahan_admin' => $kesalahan
                ]);
        }

        if ($updateAvalan == true) {
            DB::commit();
            return redirect()->route("item.index")->with('status', "Berhasil mengubah data CSO item");
        } else {
            DB::rollBack();
            return redirect()->route("item.index")->with('error', "Gagal mengubah data CSO item");
        }
    }

    public function showDetailCso(Request $request)
    {
        if ($request->batchNo == null) {
            $data = ViewDashboard::where('itemid', '=', $request->id)->whereNull('batchNo')->get();

            $dataAnalisator = DB::table('dbttrsdet')
                ->join('dbttrshed', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
                ->leftJoin('dbmuser', 'dbttrsdet.analisatorid', '=', 'dbmuser.userid')
                ->leftJoin('dbmgroup', 'dbmgroup.groupid', '=', 'dbttrsdet.groupid')
                ->select(["dbttrsdet.groupid", "dbttrsdet.analisatorid", "dbmgroup.groupdesc", "name", "kesalahan_admin"])
                ->where('itemid', '=', $request->id)
                ->where('dbttrshed.statusdoc', '=', 'A')
                ->whereNotNull('analisatorid')
                ->get();

            $cekCso = DB::table('dbtcsodet2')
                ->select('dbtcsodet2.csodet2id', 'dbtcsodet.csodetid', 'dbtcsodet.csoid', 'dbtcsodet.itemid', 'dbttrsdet.itemname', 'dbtcsodet2.csocount', 'dbtcsodet2.qty', 'dbttrsdet.statuscso')
                ->leftJoin('dbtcsodet', 'dbtcsodet.csodetid', '=', 'dbtcsodet2.csodetid')
                ->leftJoin('dbtcsohed', 'dbtcsohed.csoid', '=', 'dbtcsodet2.csoid')
                ->leftJoin('dbttrsdet', 'dbttrsdet.itemid', '=', 'dbtcsodet.itemid')
                ->leftJoin('viewdashboard', 'viewdashboard.itemid', '=', 'dbtcsodet.itemid')
                ->where('dbtcsodet.itemid', '=', $request->id)
                ->whereRaw('ifnull(qty,0) <> 0')
                ->whereColumn('csocount', 'viewdashboard.statuscso')
                ->where('statussubmit', 'P')
                ->where('dbtcsohed.status', 'A')
                ->get();
        } else {
            $data = ViewDashboard::where('itemid', '=', $request->id)->where('batchNo', '=', $request->batchNo)->get();

            $dataAnalisator = DB::table('dbttrsdet')
                ->join('dbttrshed', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
                ->leftJoin('dbmuser', 'dbttrsdet.analisatorid', '=', 'dbmuser.userid')
                ->leftJoin('dbmgroup', 'dbmgroup.groupid', '=', 'dbttrsdet.groupid')
                ->select(["dbttrsdet.groupid", "dbttrsdet.analisatorid", "dbmgroup.groupdesc", "name", "kesalahan_admin"])
                ->where('itemid', '=', $request->id)
                ->where('batchNo', '=', $request->batchNo)
                ->where('dbttrshed.statusdoc', '=', 'A')
                ->whereNotNull('analisatorid')
                ->get();

            $cekCso = DB::table('dbtcsodet2')
                ->select('dbtcsodet2.csodet2id', 'dbtcsodet.csodetid', 'dbtcsodet.csoid', 'dbtcsodet.itemid', 'dbttrsdet.itemname', 'dbtcsodet2.csocount', 'dbtcsodet2.qty', 'dbttrsdet.statuscso')
                ->leftJoin('dbtcsodet', 'dbtcsodet.csodetid', '=', 'dbtcsodet2.csodetid')
                ->leftJoin('dbtcsohed', 'dbtcsohed.csoid', '=', 'dbtcsodet2.csoid')
                ->leftJoin('dbttrsdet', 'dbttrsdet.itemid', '=', 'dbtcsodet.itemid')
                ->leftJoin('viewdashboard', 'viewdashboard.itemid', '=', 'dbtcsodet.itemid')
                ->where('dbtcsodet.itemid', '=', $request->id)
                ->where('dbttrsdet.batchNo', '=', $request->batchNo)
                ->whereRaw('ifnull(qty,0) <> 0')
                ->whereColumn('csocount', 'viewdashboard.statuscso')
                ->where('statussubmit', 'P')
                ->where('dbtcsohed.status', 'A')
                ->get();
        }

        $dataDetailDashboard = DB::table('viewdetaildashb')->distinct()->where('itemid', '=', $request->id)->get();

        $dataTotalCso = DB::table('dbttrsdet')
            ->leftJoin('totalcso1', 'totalcso1.itemid', '=', 'dbttrsdet.itemid')
            ->leftJoin('totalcso2', 'totalcso2.itemid', '=', 'dbttrsdet.itemid')
            ->leftJoin('totalcso3', 'totalcso3.itemid', '=', 'dbttrsdet.itemid')
            ->leftJoin('totalcso4', 'totalcso4.itemid', '=', 'dbttrsdet.itemid')
            ->select('dbttrsdet.itemid')
            ->selectRaw('ifnull(totalcso1.qtytot,0) as totalcso1')
            ->selectRaw('ifnull(totalcso2.qtytot,0) as totalcso2')
            ->selectRaw('ifnull(totalcso3.qtytot,0) as totalcso3')
            ->selectRaw('ifnull(totalcso4.qtytot,0) as totalcso4')
            ->where('dbttrsdet.itemid', '=', $request->id)
            ->distinct()
            ->get();

        $dataCsoCount = DB::table('viewdetaildashb')
            ->select(['name', 'csocount', 'cso1', 'cso2', 'cso3', 'cso4'])
            ->where('itemid', '=', $request->id)
            ->distinct()
            ->get();

        $dataGroup = Group::all();

        $dataDbxJob = DB::table('analisator')
            ->select(['userid', 'name'])
            ->distinct()
            ->get();

        return view('admin.dashboard.table.item.detail-cso-item', [
            "itemid" => $data[0]->itemid,
            "batchno" => $data[0]->batchno,
            "heatno" => $data[0]->heatno,
            "dimension" => $data[0]->dimension,
            "tolerance" => $data[0]->tolerance,
            "kondisi" => $data[0]->kondisi,
            "onhand" => $data[0]->onhand,
            "totalcso" => $data[0]->totalcso,
            "selisih" => $data[0]->selisih,
            "koreksi" => $data[0]->koreksi,
            "deviasi" => $data[0]->deviasi,
            "tableDetailDashboard" => $dataDetailDashboard,
            "dataCso" => $dataCsoCount,
            "totalCso" => $dataTotalCso,
            "analisator" => $dataAnalisator,
            "group" => $dataGroup,
            "dbxJob" => $dataDbxJob,
            "checkCso" => count($cekCso)
        ]);
        // return response()->json(['data'=>$dataAnalisator]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        DB::beginTransaction();

        $updateDbtTrsHed = DB::table('dbttrshed')
            ->where('statusdoc', '=', 'A')
            ->update(['endcsodate' => Carbon::now(), 'statusdoc' => 'E']);

        DB::table('dbtcsohed')
            ->where('status', '=', 'A')
            ->where('tipecso', '=', 'R')
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


        if ($updateDbtTrsHed == true) {
            DB::commit();
            return redirect()->route("item.index")->with('status', 'CSO Item berhasil diberhentikan');
        } else {
            DB::rollBack();
            return redirect()->route("item.index")->with('error', 'Gagal memberhentikan CSO Item');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        // DB::beginTransaction();

        $updateDbtTrsHed = DB::table('dbttrshed')
            ->where('statusdoc', '=', 'E')
            ->update(['statusdoc' => 'P']);

        DB::table('dbximpor')->truncate();
        DB::table('dbximpordet')->truncate();

        DB::table('dbxsetdate')->where('tipe', '=', 'I')->delete();

        DB::table('dbxmaterial')->truncate();

        DB::table('dbtcsoprsn')
            ->update(['status' => 'P']);

        DB::table('dbxjob')->truncate();
        DB::table('dbxcsotype')->truncate();

        // if($updateDbtTrsHed == true ) {
        DB::commit();
        return redirect()->route("item.index")->with('status', 'CSO berhasil diakhiri');
        // } else {
        //     DB::rollBack();
        //     return redirect()->route("item.index")->with('error', 'Gagal mengakhiri CSO');
        // }

    }
}
