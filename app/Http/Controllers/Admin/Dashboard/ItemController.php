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
        $checkCsoActive = DB::table('dbttrshed')->where('dbttrshed.statusdoc', '=', 'A')->orderByDesc('trsid')->limit(1)->get();

        $checkCsoEnd = DB::table('dbttrshed')->where('dbttrshed.statusdoc', '=', 'E')->orderByDesc('trsid')->limit(1)->get();

        $checkCsoFinal = DB::table('dbttrshed')->where('statusdoc', '=', 'P')->orderByDesc('trsid')->limit(1)->get();

        $getCsoDate = DB::table('dbttrshed')->select('startcsodate')->where('statusdoc', '!=', 'P')->orderByDesc('trsid')->limit(1)->get();

        if (count($getCsoDate) > 0) {
            $csoDate = Carbon::parse($getCsoDate[0]->startcsodate)->format('d M Y');
        } else {
            $csoDate = "Belum ada tanggal CSO";
        }

        $itemBlmProses = ViewDashboard::where('status', '=', '0')->get();
        $itemOk = ViewDashboard::where('status', '=', '3')->get();
        $itemSelisihPlus = ViewDashboard::where('selisih', '>', '0')->get();
        $itemSelisihMinus = ViewDashboard::where('selisih', '<', '0')->get();
        $dbxjob = DB::table('dbxjob')->where('jobtypeid', '=', 2)->get();
        $group = Group::all();

        return view("admin.dashboard.item", [
            'countCsoActive' => count($checkCsoActive), 'countCsoEnd' => count($checkCsoEnd), 'countCsoFinal' => count($checkCsoFinal), 'item' => $item,
            "countItemBlmProses" => count($itemBlmProses), "itemBlmProses" => $itemBlmProses,
            "countItemOk" => count($itemOk), "itemSelesai" => $itemOk,
            "countItemSelisih" => (count($itemSelisihPlus) + count($itemSelisihMinus)), "itemSelisihPlus" => $itemSelisihPlus, "itemSelisihMinus" => $itemSelisihMinus,
            "dbxjob" => $dbxjob, "dbmgroup" => $group, "csodate" => $csoDate
        ]);
    }

    public function checkItemBlmProses()
    {
        $itemBlmProses = ViewDashboard::where('status', '=', '0')->get();

        return response()->json(['data' => count($itemBlmProses)]);
    }

    public function showBanner()
    {
        $itemBlmProses = ViewDashboard::where('status', '=', '0')->get();
        $itemOk = ViewDashboard::where('status', '=', '3')->get();
        $itemSelisih = ViewDashboard::where('selisih', '>', '0')->get();
        return view("admin.dashboard.banner.banner-item", [
            "countItemBlmProses" => count($itemBlmProses),
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

    public function showMainTable(Request $request)
    {
        $item = DB::table('viewdashboard')
            ->where('itemname', 'like', '%' . $request->search . '%')
            ->orWhere('itemcode', 'like', '%' . $request->search . '%')
            ->orWhere('itemid', 'like', '%' . $request->search . '%')
            ->orWhere('batchno', 'like', '%' . $request->search . '%')
            ->orWhere('analisator', 'like', '%' . $request->search . '%')
            ->orWhere('analisatorid', 'like', '%' . $request->search . '%')
            ->orWhere('statusname', 'like', '%' . $request->search . '%')
            ->get();

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

    public function csoUlang(Request $request)
    {
        DB::beginTransaction();
        if ($request->batchno == null || $request->batchno == "") {
            // $updateLCso = Dbtcsodet::whereHas('dbtcsohed',function($query) {
            //     $query->where('status', '=', 'A');
            // })
            // ->findOrFail($request->itemid)
            // ->update(['dbtcsodet.statushslcso' => 'C']);

            // $updateLCso->save();

            // if ($updateLCso == true) {
            //     $getDataDbtCsoDet = Dbtcsodet::whereHas('dbtcsohed',function($query) {
            //         $query->where('status', '=', 'A');
            //     })
            //     ->findOrFail($request->itemid)
            //     ->select(DB::raw("dbtcsodet.csoid, dbtcsodet.itemid, dbtcsodet.itemid as 'itembatchid', dbtcsodet.color, dbtcsodet.locationid, dbtcsodet.grade, 'R', 'D', 'T'"))
            //     ->groupBy('dbtcsodet.itemid');

            //     $insertDbtCsoDet = new Dbtcsodet;
            //     $insertDbtCsoDet->fill($getDataDbtCsoDet);
            //     $insertDbtCsoDet->save();

            //     if ($insertDbtCsoDet == true) {
            //         $getDbtCsoDetOnDbtCsoDet2 = Dbtcsodet2::whereHas('dbtcsodet',function($query) {
            //             $query
            //             ->where('itemid', '=', $request->itemid)
            //             ->where('statushslcso', '=', 'C');
            //         })
            //         ->select(DB::raw("dbtcsodet.itemid, (dbtcsodet2.csocount+1) as count"))
            //         ->distinct();

            //         $getDbtCsoDetOnDbtCsoHed = DB::table('dbtcsodet')
            //             ->leftJoin('dbtcsohed', 'dbtcsohed.csoid', '=', 'dbtcsodet.csoid')
            //             ->leftJoinSub($getDbtCsoDetOnDbtCsoDet2, 'dbtcsodet2', function ($join) {
            //                 $join->on('dbtcsodet2.itemid', '=', 'dbtcsodet.itemid');
            //             })
            //             ->select(['dbtcsodet.csodetid', 'dbtcsodet.csoid', 'dbtcsodet2.count'])
            //             ->where('dbtcsodet.itemid', '=', $request->itemid)
            //             ->where('dbtcsodet.statushslcso', '=', 'T')
            //             ->where('dbtcsohed.status', '=', 'A')
            //             // ->distinct();
            //             ->groupBy('dbtcsodet.itemid');

            //         $insertDbtCsoDet2 = DB::table('dbtcsodet2')->insertUsing(['csodetid', 'csoid', 'csocount'], $getDbtCsoDetOnDbtCsoHed);

            //         if ($insertDbtCsoDet2 == true) {
            //             $updateDbtTrsDet = DB::table('dbttrsdet')
            //                 ->where('itemid', $request->itemid)
            //                 ->increment('statuscso');
            //             if ($updateDbtTrsDet == true) {
            //                 DB::commit();
            //                 return response()->json(['result' => 1]);
            //             } else {
            //                 DB::rollBack();
            //                 return response()->json(['result' => 0]);
            //             }
            //         } else {
            //             DB::rollBack();
            //             return response()->json(['result' => 0]);
            //         }
            //     } else {
            //         DB::rollBack();
            //         return response()->json(['result' => 0]);
            //     }
            // } else {
            //     DB::rollBack();
            //     return response()->json(['result' => 0]);
            // }
            $updateLCso = DB::table('dbtcsodet')
                ->leftJoin('dbtcsohed', 'dbtcsodet.csoid', '=', 'dbtcsohed.csoid')
                ->where('dbtcsodet.itemid', $request->itemid)
                ->where('dbtcsohed.status', 'A')
                ->update(['dbtcsodet.statushslcso' => 'C']);

            if ($updateLCso == true) {
                $getDataDbtCsoDet = DB::table('dbtcsodet')
                    ->leftJoin('dbtcsohed', 'dbtcsodet.csoid', '=', 'dbtcsohed.csoid')
                    ->select(DB::raw("dbtcsodet.csoid, dbtcsodet.itemid, dbtcsodet.itemid as 'itembatchid', dbtcsodet.color, dbtcsodet.locationid, dbtcsodet.grade, 'R', 'D', 'T'"))
                    ->where('dbtcsodet.itemid', '=', $request->itemid)
                    ->where('dbtcsohed.status', '=', 'A')
                    ->groupBy('dbtcsodet.itemid');

                $insertDbtCsoDet = DB::table('dbtcsodet')->insertUsing(['csoid', 'itemid', 'itembatchid', 'color', 'locationid', 'grade', 'statusitem', 'statussubmit', 'statushslcso'], $getDataDbtCsoDet);

                if ($insertDbtCsoDet == true) {
                    $getDbtCsoDetOnDbtCsoDet2 = DB::table('dbtcsodet')
                        ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                        ->select(DB::raw("dbtcsodet.itemid, (dbtcsodet2.csocount+1) as count"))
                        ->where('dbtcsodet.itemid', '=', $request->itemid)
                        ->where('dbtcsodet.statushslcso', '=', 'C')
                        ->distinct();
                        // ->groupBy('dbtcsodet.itemid');

                    $getDbtCsoDetOnDbtCsoHed = DB::table('dbtcsodet')
                        ->leftJoin('dbtcsohed', 'dbtcsohed.csoid', '=', 'dbtcsodet.csoid')
                        ->leftJoinSub($getDbtCsoDetOnDbtCsoDet2, 'dbtcsodet2', function ($join) {
                            $join->on('dbtcsodet2.itemid', '=', 'dbtcsodet.itemid');
                        })
                        ->select(['dbtcsodet.csodetid', 'dbtcsodet.csoid', 'dbtcsodet2.count'])
                        ->where('dbtcsodet.itemid', '=', $request->itemid)
                        ->where('dbtcsodet.statushslcso', '=', 'T')
                        ->where('dbtcsohed.status', '=', 'A')
                        // ->distinct();
                        ->groupBy('dbtcsodet.itemid');

                    $insertDbtCsoDet2 = DB::table('dbtcsodet2')->insertUsing(['csodetid', 'csoid', 'csocount'], $getDbtCsoDetOnDbtCsoHed);

                    if ($insertDbtCsoDet2 == true) {
                        $updateDbtTrsDet = DB::table('dbttrsdet')
                            ->where('itemid', $request->itemid)
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
        } else {
            $updateLCso = DB::table('dbtcsodet')
                ->leftJoin('dbtcsohed', 'dbtcsodet.csoid', '=', 'dbtcsohed.csoid')
                ->where('dbtcsodet.itembatchid', $request->itemid . $request->batchno)
                ->where('dbtcsohed.status', 'A')
                ->update(['statushslcso' => 'C']);

            if ($updateLCso == true) {
                $getDataDbtCsoDet = DB::table('dbtcsodet')
                    ->leftJoin('dbtcsohed', 'dbtcsodet.csoid', '=', 'dbtcsohed.csoid')
                    ->select(DB::raw("dbtcsodet.csoid, dbtcsodet.itemid, dbtcsodet.itembatchid, dbtcsodet.locationid, dbtcsodet.grade, 'R', 'D', 'T' "))
                    ->where('dbtcsodet.itembatchid', $request->itemid . $request->batchno)
                    ->where('dbtcsohed.status', '=', 'A')
                    ->distinct();

                $insertDbtCsoDet = DB::table('dbtcsodet')->insertUsing(['csoid', 'itemid', 'itembatchid', 'locationid', 'grade', 'statusitem', 'statussubmit', 'statushslcso'], $getDataDbtCsoDet);

                if ($insertDbtCsoDet == true) {
                    $getDbtCsoDetOnDbtCsoDet2 = DB::table('dbtcsodet')
                        ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                        ->select(DB::raw("dbtcsodet.itemid, dbtcsodet.itembatchid, (dbtcsodet2.csocount+1) as count"))
                        ->where('dbtcsodet.itembatchid', $request->itemid . $request->batchno)
                        ->where('dbtcsodet.statushslcso', '=', 'C')
                        ->distinct();

                    $getDbtCsoDetOnDbtCsoHed = DB::table('dbtcsodet')
                        ->leftJoin('dbtcsohed', 'dbtcsohed.csoid', '=', 'dbtcsodet.csoid')
                        ->leftJoinSub($getDbtCsoDetOnDbtCsoDet2, 'dbtcsodet2', function ($join) {
                            $join->on('dbtcsodet2.itemid', '=', 'dbtcsodet.itemid');
                        })
                        ->select(['dbtcsodet.csodetid', 'dbtcsodet.csoid', 'dbtcsodet2.count'])
                        ->where('dbtcsodet.itembatchid', $request->itemid . $request->batchno)
                        ->where('dbtcsodet.statushslcso', '=', 'T')
                        ->where('dbtcsohed.status', '=', 'A')
                        ->distinct();

                    $insertDbtCsoDet2 = DB::table('dbtcsodet2')->insertUsing(['csodetid', 'csoid', 'csocount'], $getDbtCsoDetOnDbtCsoHed);

                    if ($insertDbtCsoDet2 == true) {

                        $updateDbtTrsDet = DB::table('dbttrsdet')
                            ->where('itembatchid', $request->itemid . $request->batchno)
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
    }

    public function updateCsoItem(Request $request)
    {
        DB::beginTransaction();
        if (!empty($request->check_kesalahan_admin)) {
            $kesalahan = 1;
        } else {
            $kesalahan = 0;
        }

        if (!empty($request->check_batch_tertukar)) {
            $batch_tertukar = 1;
        } else {
            $batch_tertukar = 0;
        }
        if ($request->batchno == null) {
            $updateAvalan = DB::table('dbttrsdet')
                ->where('itemid', $request->itemid)
                ->where('dbttrsdet.trsdetid', '=', $request->trsdetid)
                ->update([
                    'koreksi' => $request->koreksi,
                    'deviasi' => $request->deviasi,
                    'analisatorid' => $request->analisator,
                    'keterangan' => $request->keterangan,
                    'groupid' => $request->grouping,
                    'kesalahan_admin' => $kesalahan,
                    "batch_tertukar" => $batch_tertukar
                ]);
        } else {
            $updateAvalan = DB::table('dbttrsdet')
                ->where('itemid', $request->itemid)
                ->where('batchno', $request->batchno)
                ->where('dbttrsdet.trsdetid', '=', $request->trsdetid)
                ->update([
                    'koreksi' => $request->koreksi,
                    'deviasi' => $request->deviasi,
                    'analisatorid' => $request->analisator,
                    'keterangan' => $request->keterangan,
                    'groupid' => $request->grouping,
                    'kesalahan_admin' => $kesalahan,
                    "batch_tertukar" => $batch_tertukar
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
        if ($request->batchno == null) {
            $data = ViewDashboard::where('itemid', '=', $request->id)->whereNull('batchno')->get();

            $dataAnalisator = DB::table('dbttrsdet')
                ->join('dbttrshed', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
                ->leftJoin('dbmuser', 'dbttrsdet.analisatorid', '=', 'dbmuser.userid')
                ->leftJoin('dbmgroup', 'dbmgroup.groupid', '=', 'dbttrsdet.groupid')
                ->select(["dbttrsdet.groupid", "dbttrsdet.analisatorid", "dbmgroup.groupdesc", "name"])
                ->where('itemid', '=', $request->id)
                ->whereNot('dbttrshed.statusdoc', '=', 'P')
                ->whereNotNull('analisatorid')
                ->get();
            
            $dataAdminBatch = DB::table('dbttrsdet')
                ->join('dbttrshed', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
                ->select(['kesalahan_admin', 'batch_tertukar'])
                ->where('dbttrsdet.itemid', '=', $request->id)
                ->whereNot('dbttrshed.statusdoc', '=', 'P')
                ->get(); 

            $cekCso = DB::table('dbtcsodet2')
                ->select('dbtcsodet2.csodet2id', 'dbtcsodet.csodetid', 'dbtcsodet.csoid', 'dbtcsodet.itemid', 'dbttrsdet.itemname', 'dbttrsdet.statusitem', 'dbtcsodet2.csocount', 'dbtcsodet2.qty', 'dbttrsdet.statuscso')
                ->leftJoin('dbtcsodet', 'dbtcsodet.csodetid', '=', 'dbtcsodet2.csodetid')
                ->leftJoin('dbtcsohed', 'dbtcsohed.csoid', '=', 'dbtcsodet2.csoid')
                ->leftJoin('dbttrsdet', 'dbttrsdet.itemid', '=', 'dbtcsodet.itemid')
                ->leftJoin('viewdashboard', 'viewdashboard.itemid', '=', 'dbtcsodet.itemid')
                ->where('dbtcsodet.itemid', '=', $request->id)
                ->whereNotNull('dbtcsodet2.qty')
                ->whereColumn('csocount', 'viewdashboard.statuscso')
                ->where('statussubmit', 'P')
                ->where('dbtcsohed.status', 'A')
                ->get();

            $cekItem = DB::table('dbttrsdet')
                ->select('dbttrsdet.statusitem','dbttrsdet.trsid')
                ->leftjoin('dbttrshed', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
                ->where('dbttrsdet.itemid', '=', $request->id)
                ->whereNot('dbttrshed.statusdoc', '=', 'P')
                ->get();
        } else {
            $data = ViewDashboard::where('itembatchid', '=', $request->id . $request->batchno)->get();

            $dataAnalisator = DB::table('dbttrsdet')
                ->join('dbttrshed', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
                ->leftJoin('dbmuser', 'dbttrsdet.analisatorid', '=', 'dbmuser.userid')
                ->leftJoin('dbmgroup', 'dbmgroup.groupid', '=', 'dbttrsdet.groupid')
                ->select(["dbttrsdet.groupid", "dbttrsdet.analisatorid", "dbmgroup.groupdesc", "name"])
                ->where('dbttrsdet.itembatchid', '=', $request->id . $request->batchno)
                ->whereNot('dbttrshed.statusdoc', '=', 'P')
                ->whereNotNull('analisatorid')
                ->get();            
            
            $dataAdminBatch = DB::table('dbttrsdet')
                ->join('dbttrshed', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
                ->select(['kesalahan_admin', 'batch_tertukar'])
                ->where('dbttrsdet.itembatchid', '=', $request->id . $request->batchno)
                ->whereNot('dbttrshed.statusdoc', '=', 'P')
                ->get();      

            $cekCso = DB::table('dbtcsodet2')
                ->select('dbtcsodet2.csodet2id', 'dbtcsodet.csodetid', 'dbtcsodet.csoid', 'dbtcsodet.itemid', 'dbttrsdet.itemname', 'dbttrsdet.statusitem', 'dbtcsodet2.csocount', 'dbtcsodet2.qty', 'dbttrsdet.statuscso')
                ->leftJoin('dbtcsodet', 'dbtcsodet.csodetid', '=', 'dbtcsodet2.csodetid')
                ->leftJoin('dbtcsohed', 'dbtcsohed.csoid', '=', 'dbtcsodet2.csoid')
                ->leftJoin('dbttrsdet', 'dbttrsdet.itemid', '=', 'dbtcsodet.itemid')
                ->leftJoin('viewdashboard', 'viewdashboard.itembatchid', '=', 'dbtcsodet.itembatchid')
                ->where('dbttrsdet.itembatchid', '=', $request->id . $request->batchno)
                ->whereNotNull('dbtcsodet2.qty')
                ->whereColumn('csocount', 'viewdashboard.statuscso')
                ->where('statussubmit', 'P')
                ->where('dbtcsohed.status', 'A')
                ->get();

            $cekItem = DB::table('dbttrsdet')
                ->select('dbttrsdet.statusitem','dbttrsdet.trsid')
                ->leftjoin('dbttrshed', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
                ->where('dbttrsdet.itembatchid', '=', $request->id . $request->batchno)
                ->whereNot('dbttrshed.statusdoc', '=', 'P')
                ->get();
        }

        $dataDetailDashboard = DB::table('viewdetaildashb')->distinct()->where('itembatchid', '=', $request->id . $request->batchno)->get();

        $dataTotalCso = DB::table('dbttrsdet')
            ->leftJoin('totalcso1', 'totalcso1.itembatchid', '=', 'dbttrsdet.itembatchid')
            ->leftJoin('totalcso2', 'totalcso2.itembatchid', '=', 'dbttrsdet.itembatchid')
            ->leftJoin('totalcso3', 'totalcso3.itembatchid', '=', 'dbttrsdet.itembatchid')
            ->leftJoin('totalcso4', 'totalcso4.itembatchid', '=', 'dbttrsdet.itembatchid')
            ->select('dbttrsdet.itembatchid')
            ->selectRaw('ifnull(totalcso1.qtytot,0) as totalcso1')
            ->selectRaw('ifnull(totalcso2.qtytot,0) as totalcso2')
            ->selectRaw('ifnull(totalcso3.qtytot,0) as totalcso3')
            ->selectRaw('ifnull(totalcso4.qtytot,0) as totalcso4')
            ->where('dbttrsdet.itembatchid', '=', $request->id . $request->batchno)
            ->distinct()
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

        return view('admin.dashboard.table.item.detail-cso-item', [
            "itemid" => $data[0]->itemid,
            "batchno" => $data[0]->batchno,
            "trsdetid" => $data[0]->trsdetid,
            "heatno" => $data[0]->heatno,
            "dimension" => $data[0]->dimension,
            "tolerance" => $data[0]->tolerance,
            "kondisi" => $data[0]->kondisi,
            "onhand" => $data[0]->onhand,
            "totalcso" => $data[0]->totalcso,
            "selisih" => $data[0]->selisih,
            "koreksi" => $data[0]->koreksi,
            "deviasi" => $data[0]->deviasi,
            "keterangan" => $data[0]->keterangan,
            "dataAdminBatch" => $dataAdminBatch[0],
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

    public function hapusTemuanItem(Request $request)
    {
        DB::beginTransaction();

        $deleteDataFromDbtTrsDet = DB::table('dbttrsdet')
            ->where('dbttrsdet.itembatchid', '=', $request->itemid . $request->batchno)
            ->where('dbttrsdet.trsdetid', '=', $request->trsdetid)
            ->delete();

        if ($deleteDataFromDbtTrsDet == true) {
            $deleteDataFromDbxImpor = DB::table('dbximpor')
                ->where('dbximpor.itemid', '=', $request->itemid)
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
     * Update the specified resource in storage.
     */
    public function update()
    {
        DB::beginTransaction();

        $updateDbtTrsHed = DB::table('dbttrshed')
            ->where('statusdoc', '=', 'A')
            ->update(['endcsodate' => Carbon::now(), 'statusdoc' => 'E']);

        $insertDbtCsoPrsn = DB::insert("INSERT INTO dbtcsoprsn (trsid,userid,username,name,coyid,jobtypeid,status,tipecso)
        SELECT DISTINCT ch.trsid,userid,username,name,j.coyid,jobtypeid,'D','R' as status FROM dbxjob j 
        INNER JOIN dbtcsohed ch ON j.userid = ch.pelakuid 
        WHERE ch.trsid = (SELECT trsid FROM dbttrshed WHERE statusdoc='E' ORDER BY trsid DESC LIMIT 1) AND ch.tipecso  = 'R'
        UNION 
        SELECT DISTINCT td.trsid,userid,username,name,j.coyid,jobtypeid,'D','R' as status FROM dbxjob j 
        INNER JOIN dbttrsdet td ON td.analisatorid =j.userid
        INNER JOIN dbtcsohed ch ON td.analisatorid = ch.pelakuid 
        WHERE td.trsid = (SELECT trsid FROM dbttrshed WHERE statusdoc='E' ORDER BY trsid DESC LIMIT 1) AND ch.tipecso = 'R'");
        if ($insertDbtCsoPrsn == true) {
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
