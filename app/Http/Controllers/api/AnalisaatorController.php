<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ViewDashboard;
use App\Models\ViewDashboardAvalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalisaatorController extends Controller
{
    public function listItemAnalisator(Request $request)
    {
        $dataAnalisator = DB::table('dbttrshed')
            ->join('dbttrsdet', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
            ->join('dbmgroup', 'dbttrsdet.groupid', '=', 'dbmgroup.groupid')
            ->join('dbtcsohed', 'dbttrshed.trsid', '=', 'dbtcsohed.trsid')
            ->join('dbtcsodet', function ($join) {
                $join->on('dbtcsohed.csoid', '=', 'dbtcsodet.csoid')
                    ->on('dbttrsdet.itemid', '=', 'dbtcsodet.itemid');
            })
            ->join('dbtcsodet2', 'dbtcsodet.csodetid', '=', 'dbtcsodet2.csodetid')
            ->where('dbttrsdet.analisatorid', $request->userid)
            ->where('dbttrshed.statusdoc', 'A')
            ->select([
                'dbttrsdet.itemname',
                'dbmgroup.groupdesc',
                'dbttrsdet.onhand',
                'dbttrsdet.koreksi',
                'dbttrsdet.deviasi',
                'dbtcsohed.csoid',
                'dbtcsodet2.csodet2id',
                'dbtcsodet2.qty',
                'dbtcsodet2.history',
                'dbtcsodet2.inputs',
                DB::raw('(dbttrsdet.onhand - (dbtcsodet2.qty + dbttrsdet.koreksi + dbttrsdet.deviasi)) AS selisih'),
                'dbtcsodet2.csocount'
            ])
            ->distinct()
            ->get();
        return response()->json(['data' => $dataAnalisator]);
    }

    // public function addHitungItem(Request $request)
    // {
    //     DB::beginTransaction();

    //     if ($request->statusitem == 'R') {
    //         $selectdbtcsohed = DB::table('dbtcsohed')
    //             ->select(DB::raw("csoid,$request->itemid,'$request->statusitem','D','D'"))
    //             ->where('pelakuuname', '=', $request->username)
    //             ->where('csoid', '=', $request->csoid)
    //             ->where('status', '=', 'A')
    //             ->where('tipecso', '=', 'R');

    //         $insertdbtcsodet1 = DB::table('dbtcsodet')->insertUsing(['csoid', 'itemid', 'statusitem', 'statussubmit', 'statushslcso'], $selectdbtcsohed);
    //     } else {
    //         $selectdbtcsohed = DB::table('dbtcsohed')
    //             ->select(DB::raw("csoid,$request->itemid,$request->batchno,'$request->statusitem','D','D'"))
    //             ->where('pelakuuname', '=', $request->username)
    //             ->where('csoid', '=', $request->csoid)
    //             ->where('status', '=', 'A')
    //             ->where('tipecso', '=', 'A');

    //         $insertdbtcsodet1 = DB::table('dbtcsodet')->insertUsing(['csoid', 'itemid', 'itembatchid', 'statusitem', 'statussubmit', 'statushslcso'], $selectdbtcsohed);
    //     }

    //     if ($insertdbtcsodet1 == true) {

    //         $csodetid = DB::table('dbtcsodet')
    //             ->join('dbtcsohed', 'dbtcsodet.csoid', '=', 'dbtcsohed.csoid')
    //             ->select('csodetid')
    //             ->where('dbtcsodet.csoid', '=', $request->csoid)
    //             ->where('dbtcsohed.status', '=', 'A')
    //             ->orderByDesc('csodetid')
    //             ->limit(1);

    //         $selectdbtcsodet = DB::table('dbtcsodet')
    //             ->select(DB::raw("csodetid,csoid,1"))
    //             ->where('csodetid', '=', $csodetid);

    //         $insertdbtcsodet2 = DB::table('dbtcsodet2')->insertUsing(['csodetid', 'csoid', 'csocount',], $selectdbtcsodet);

    //         if ($insertdbtcsodet2 == true) {
    //             $getdbtcsodet = $selectdbtcsodet->get();
    //             $selectdbtcsodet2 = DB::table('dbtcsodet2')
    //                 ->select('csodet2id')
    //                 ->where('csodetid', '=', $csodetid)
    //                 ->orderByDesc('csodet2id')
    //                 ->limit(1)
    //                 ->get();
    //             DB::rollback();
    //             return response()->json(['result' => 1, 'csodetid' => $getdbtcsodet[0]->csodetid, 'csodet2id' => $selectdbtcsodet2[0]->csodet2id]);
    //         } else {
    //             DB::rollBack();
    //             return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
    //         }
    //     } else {
    //         DB::rollBack();
    //         return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
    //     }
    // }

    public function simpanHitungItem(Request $request)
    {
        DB::beginTransaction();
        $simpan = DB::table('dbtcsodet2')
            ->where('csodet2id', '=', $request->csodet2id)
            ->update([
                'qty' => $request->qty,
                'history' => $request->history,
                'inputs' => $request->inputs,
                'operand' => $request->operand
            ]);

        if ($simpan == true) {
            DB::commit();
            return response()->json(['result' => 1]);
        } else {
            DB::rollBack();
            return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
        }
    }

    public function listAvalanAnalisator(Request $request)
    {
        $dataAnalisator = DB::table('dbttrsheda')
        ->join('dbttrsdeta', 'dbttrsheda.trsid', '=', 'dbttrsdeta.trsid')
        ->join('dbmgroup', 'dbttrsdeta.groupid', '=', 'dbmgroup.groupid')
        ->join('dbtcsohed', 'dbttrsheda.trsid', '=', 'dbtcsohed.trsid')
        ->join('dbtcsodet', function ($join) {
            $join->on('dbtcsohed.csoid', '=', 'dbtcsodet.csoid')
                ->on('dbttrsdeta.itemid', '=', 'dbtcsodet.itemid');
        })
        ->join('dbtcsodet2', 'dbtcsodet.csodetid', '=', 'dbtcsodet2.csodetid')
        ->where('dbttrsdeta.analisatorid', $request->userid)
        ->where('dbttrsheda.statusdoc', 'A')
        ->select([
            'dbttrsdeta.itemname',
            'dbmgroup.groupdesc',
            'dbttrsdeta.onhand',
            'dbttrsdeta.koreksi',
            'dbttrsdeta.deviasi',
            'dbtcsoheda.csoid',
            'dbtcsodet2.csodet2id',
            'dbtcsodet2.qty',
            'dbtcsodet2.history',
            'dbtcsodet2.inputs',
            DB::raw('(dbttrsdeta.onhand - (dbtcsodet2.qty + dbttrsdeta.koreksi + dbttrsdeta.deviasi)) AS selisih'),
            'dbtcsodet2.csocount'
        ])
        ->distinct()
        ->get();
        // $dataAnalisator = ViewDashboardAvalan::where('analisatorid', '=', $request->userid)->get();

        return response()->json(['data' => $dataAnalisator]);
    }

    public function updateItemAnalisator(Request $request)
    {
        DB::beginTransaction();
        if ($request->csodet2id == "") {

            if ($request->statusitem == 'R') {
                $selectdbtcsohed = DB::table('dbtcsohed')
                    ->select(DB::raw("csoid,$request->itemid,'$request->statusitem','D','D'"))
                    ->where('pelakuuname', '=', $request->username)
                    ->where('csoid', '=', $request->csoid)
                    ->where('status', '=', 'A')
                    ->where('tipecso', '=', 'R');

                $insertdbtcsodet1 = DB::table('dbtcsodet')->insertUsing(['csoid', 'itemid', 'statusitem', 'statussubmit', 'statushslcso'], $selectdbtcsohed);
            } else {
                $selectdbtcsohed = DB::table('dbtcsohed')
                    ->select(DB::raw("csoid,$request->itemid,$request->batchno,'$request->statusitem','D','D'"))
                    ->where('pelakuuname', '=', $request->username)
                    ->where('csoid', '=', $request->csoid)
                    ->where('status', '=', 'A')
                    ->where('tipecso', '=', 'A');

                $insertdbtcsodet1 = DB::table('dbtcsodet')->insertUsing(['csoid', 'itemid', 'itembatchid', 'statusitem', 'statussubmit', 'statushslcso'], $selectdbtcsohed);
            }

            if ($insertdbtcsodet1 == true) {
                $csodetid = DB::table('dbtcsodet')
                    ->join('dbtcsohed', 'dbtcsodet.csoid', '=', 'dbtcsohed.csoid')
                    ->select('csodetid')
                    ->where('dbtcsodet.csoid', '=', $request->csoid)
                    ->where('dbtcsohed.status', '=', 'A')
                    ->orderByDesc('csodetid')
                    ->limit(1);

                $selectdbtcsodet2 = DB::table('dbtcsodet')
                    ->select(DB::raw("csodetid,csoid,1,'$request->qtycso'"))
                    ->where('csodetid', '=', $csodetid);

                $insertdbtcsodet2 = DB::table('dbtcsodet2')->insertUsing(['csodetid', 'csoid', 'csocount', 'qty'], $selectdbtcsodet2);

                if ($insertdbtcsodet2 == true) {
                    if ($request->statusitem == 'R') {
                        $updateAvalan = DB::table('dbttrsdet')
                            ->where('itemid', $request->itemid)
                            ->update([
                                'koreksi' => $request->koreksi,
                                'deviasi' => $request->deviasi,
                                'analisatorid' => $request->analisatorid,
                            ]);
                    } else {
                        $updateAvalan = DB::table('dbttrsdet')
                            ->where('itemid', $request->itemid)
                            ->where('batchno', $request->batchno)
                            ->update([
                                'koreksi' => $request->koreksi,
                                'deviasi' => $request->deviasi,
                                'analisatorid' => $request->analisatorid,
                            ]);
                    }

                    if ($updateAvalan == true) {
                        DB::rollback();
                        return response()->json(["result" => 1]);
                    } else {
                        DB::rollBack();
                        return response()->json(["result" => 0]);
                    }
                } else {
                    DB::rollBack();
                    return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
                }
            } else {
                DB::rollBack();
                return response()->json(['result' => 'fail', 'message' => 'Penambahan data gagal']);
            }
        } else {
            if ($request->statusitem == 'R') {
                $updateAvalan = DB::table('dbttrsdet')
                    ->where('itemid', $request->itemid)
                    ->update([
                        'koreksi' => $request->koreksi,
                        'deviasi' => $request->deviasi,
                        'analisatorid' => $request->analisatorid,
                    ]);
            } else {
                $updateAvalan = DB::table('dbttrsdet')
                    ->where('itemid', $request->itemid)
                    ->where('batchno', $request->batchno)
                    ->update([
                        'koreksi' => $request->koreksi,
                        'deviasi' => $request->deviasi,
                        'analisatorid' => $request->analisatorid,
                    ]);
            }



            if ($updateAvalan == true) {
                DB::commit();
                return response()->json(["result" => 1]);
            } else {
                DB::rollBack();
                return response()->json(["result" => 0]);
            }
        }
    }
}
