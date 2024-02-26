<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessController extends Controller
{
    public function addItem(Request $request)
    {
        DB::beginTransaction();
        $color = implode(",", $request->color);
        if ($request->csodet2id == "") {
            $selectdbtcsohed = DB::table('dbtcsohed')
                ->select(DB::raw("csoid,'$request->itemid', '$request->itembatchid','$request->lokasi','$color','$request->remark','$request->statusItem','D','D'"))
                ->where('pelakuuname', '=', $request->username)
                ->where('csoid', '=', $request->csoid)
                ->where('status', '=', 'A');

            $insertdbtcsodet1 = DB::table('dbtcsodet')->insertUsing(['csoid', 'itemid', 'itembatchid', 'locationid', 'color', 'remark', 'statusitem', 'statussubmit', 'statushslcso'], $selectdbtcsohed);

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
                    DB::commit();
                    return response()->json(['result' => 1]);
                } else {
                    DB::rollBack();
                    return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
                }
            } else {
                DB::rollBack();
                return response()->json(['result' => 'fail', 'message' => 'Penambahan data gagal']);
            }
        } else {
            $simpanItem = DB::table('dbtcsodet')
                ->join('dbtcsohed', 'dbtcsodet.csoid', '=', 'dbtcsohed.csoid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->where('dbtcsohed.pelakuuname', '=', $request->username)
                ->where('dbtcsodet.csodetid', '=', $request->csodetid)
                ->where('dbtcsohed.status', '=', 'A')
                ->update([
                    'dbtcsodet.itemid' => $request->itemid,
                    'dbtcsodet.locationid' => $request->lokasi,
                    'dbtcsodet.itembatchid' => $request->itembatchid,
                    'dbtcsodet.color' => $color,
                    'dbtcsodet.remark' => $request->remark,
                    'dbtcsodet2.qty' => $request->qtycso,
                ]);

            // if ($simpanItem == true) {
                DB::commit();
                return response()->json(['result' => 1, 'data' => $simpanItem]);
            // } else {
            //     DB::rollBack();
            //     return response()->json(['result' => 0, 'message' => 'Penambahan data item gagal']);
            // }
        }
    }

    public function simpanHitung(Request $request)
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

    public function addHitung(Request $request)
    {
        DB::beginTransaction();

        $color = implode(",", $request->color);

        $selectdbtcsohed = DB::table('dbtcsohed')
            ->select(DB::raw("csoid,$request->itemid,$request->itembatchid,$request->lokasi,'$color','$request->statusItem','D','D'"))
            ->where('pelakuuname', '=', $request->username)
            ->where('csoid', '=', $request->csoid)
            ->where('status', '=', 'A');

        $insertdbtcsodet1 = DB::table('dbtcsodet')->insertUsing(['csoid', 'itemid', 'itembatchid', 'locationid', 'color', 'statusitem', 'statussubmit', 'statushslcso'], $selectdbtcsohed);

        if ($insertdbtcsodet1 == true) {

            $csodetid = DB::table('dbtcsodet')
                ->join('dbtcsohed', 'dbtcsodet.csoid', '=', 'dbtcsohed.csoid')
                ->select('csodetid')
                ->where('dbtcsodet.csoid', '=', $request->csoid)
                ->where('dbtcsohed.status', '=', 'A')
                ->orderByDesc('csodetid')
                ->limit(1);

            $selectdbtcsodet = DB::table('dbtcsodet')
                ->select(DB::raw("csodetid,csoid,1"))
                ->where('csodetid', '=', $csodetid);

            $insertdbtcsodet2 = DB::table('dbtcsodet2')->insertUsing(['csodetid', 'csoid', 'csocount',], $selectdbtcsodet);

            if ($insertdbtcsodet2 == true) {
                $getdbtcsodet = $selectdbtcsodet->get();
                $selectdbtcsodet2 = DB::table('dbtcsodet2')
                    ->select('csodet2id')
                    ->where('csodetid', '=', $csodetid)
                    ->orderByDesc('csodet2id')
                    ->limit(1)
                    ->get();
                DB::commit();
                return response()->json(['result' => 1, 'csodetid' => $getdbtcsodet[0]->csodetid, 'csodet2id' => $selectdbtcsodet2[0]->csodet2id]);
            } else {
                DB::rollBack();
                return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
            }
        } else {
            DB::rollBack();
            return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
        }
    }

    public function addHitungTemuan(Request $request)
    {
        DB::beginTransaction();

        $color = implode(",", $request->color);

        if ($request->type == 1) {
            $itemId = DB::table('dbximpor')->select('itemid')->where('statusitem', '=', 'T')->orderByDesc('createddate')->limit(1)->get();

            if (count($itemId) > 0) $itemId = $itemId[0]->itemid + 1;
            else $itemId = 9999001;

            $insertDbxImpor = DB::table('dbximpor')->insert([
                'itemid' => $itemId,
                'itemname' => trim(ucwords($request->temuanname)),
                'statusitem' => 'T'
            ]);
            if ($insertDbxImpor == true) {
                $getTrsId = DB::table('dbttrshed')->select('trsid')->orderByDesc('trsid')->limit(1)->get();

                $trsId = $getTrsId[0]->trsid;

                $insertdbttrsdet = DB::table('dbttrsdet')->insert([
                    'trsid' => $trsId,
                    'itemid' => $itemId,
                    'itemname' => trim(ucwords($request->temuanname)),
                    'statusitem' => 'T',
                    'statuscso' => 1
                ]);
            } else {
                return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
            }
        } else {
            $itemId = DB::table('dbximporavalan')->select('itemid')->where('statusitem', '=', 'T')->orderByDesc('createddate')->limit(1)->get();

            if (count($itemId) > 0) $itemId = $itemId[0]->itemid + 1;
            else $itemId = 9999001;

            $insertDbxImpor = DB::table('dbximporavalan')->insert([
                'itemid' => $itemId,
                'itemname' => trim(ucwords($request->temuanname)),
                'statusitem' => 'T'
            ]);
            if ($insertDbxImpor == true) {

                $getTrsId = DB::table('dbttrsheda')->select('trsid')->orderByDesc('trsid')->limit(1)->get();

                $trsId = $getTrsId[0]->trsid;

                $insertdbttrsdet = DB::table('dbttrsdeta')->insert([
                    'trsid' => $trsId,
                    'itemid' => $itemId,
                    'itemname' => trim(ucwords($request->temuanname)),
                    'statusitem' => 'T',
                    'statuscso' => 1
                ]);
            } else {
                return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
            }
        }



        if ($insertdbttrsdet == true) {

            $selectdbtcsohed = DB::table('dbtcsohed')
                ->select(DB::raw("csoid,$itemId,$request->lokasi,'$color','$request->statusItem','D','D'"))
                ->where('pelakuuname', '=', $request->username)
                ->where('csoid', '=', $request->csoid)
                ->where('status', '=', 'A');

            $insertdbtcsodet1 = DB::table('dbtcsodet')->insertUsing(['csoid', 'itemid', 'locationid', 'color', 'statusitem', 'statussubmit', 'statushslcso'], $selectdbtcsohed);

            if ($insertdbtcsodet1 == true) {

                $csodetid = DB::table('dbtcsodet')
                    ->join('dbtcsohed', 'dbtcsodet.csoid', '=', 'dbtcsohed.csoid')
                    ->select('csodetid')
                    ->where('dbtcsodet.csoid', '=', $request->csoid)
                    ->where('dbtcsohed.status', '=', 'A')
                    ->orderByDesc('csodetid')
                    ->limit(1);

                $selectdbtcsodet = DB::table('dbtcsodet')
                    ->select(DB::raw("csodetid,csoid,1"))
                    ->where('csodetid', '=', $csodetid);

                $insertdbtcsodet2 = DB::table('dbtcsodet2')->insertUsing(['csodetid', 'csoid', 'csocount',], $selectdbtcsodet);

                if ($insertdbtcsodet2 == true) {
                    $getdbtcsodet = $selectdbtcsodet->get();
                    $selectdbtcsodet2 = DB::table('dbtcsodet2')
                        ->select('csodet2id')
                        ->where('csodetid', '=', $csodetid)
                        ->orderByDesc('csodet2id')
                        ->limit(1)
                        ->get();
                    DB::commit();
                    return response()->json(['result' => 1, 'csodetid' => $getdbtcsodet[0]->csodetid, 'csodet2id' => $selectdbtcsodet2[0]->csodet2id, 'itemid' => $itemId]);
                } else {
                    DB::rollBack();
                    return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
                }
            } else {
                DB::rollBack();
                return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
            }
        } else {
            DB::rollBack();
            return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
        }
    }

    public function addTemuanItem(Request $request)
    {
        DB::beginTransaction();
        $color = implode(",", $request->color);
        // $color =  $request->color;          

        if ($request->csodet2id == "") {
            $itemId = DB::table('dbximpor')->select('itemid')->where('statusitem', '=', 'T')->orderByDesc('createddate')->limit(1)->get();
            if (count($itemId) > 0) $itemId = $itemId[0]->itemid + 1;
            else $itemId = 9999001;

            $insertDbxImpor = DB::table('dbximpor')->insert([
                'itemid' => $itemId,
                'itembatchid' => $itemId,
                'itemname' => trim(ucwords($request->temuanname)),
                'statusitem' => 'T'
            ]);

            if ($insertDbxImpor == true) {
                $getTrsId = DB::table('dbttrshed')->select('trsid')->orderByDesc('trsid')->limit(1)->get();

                $trsId = $getTrsId[0]->trsid;

                $insertdbttrsdet = DB::table('dbttrsdet')->insert([
                    'trsid' => $trsId,
                    'itemid' => $itemId,
                    'itembatchid' => $itemId,
                    'itemname' => trim(ucwords($request->temuanname)),
                    'statusitem' => 'T',
                    'statuscso' => 1
                ]);

                if ($insertdbttrsdet == true) {
                    $selectdbtcsohed = DB::table('dbtcsohed')
                        ->select(DB::raw("csoid,'$itemId','$request->lokasi','$color','$request->remark','$request->statusItem','D','D'"))
                        ->where('pelakuuname', '=', $request->username)
                        ->where('csoid', '=', $request->csoid)
                        ->where('status', '=', 'A');

                    $insertdbtcsodet1 = DB::table('dbtcsodet')->insertUsing(['csoid', 'itemid', 'locationid', 'color', 'remark', 'statusitem', 'statussubmit', 'statushslcso'], $selectdbtcsohed);

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
                            DB::commit();
                            return response()->json(['result' => 1]);
                        } else {
                            DB::rollBack();
                            return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
                        }
                    } else {
                        DB::rollBack();
                        return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
                    }
                } else {
                    DB::rollBack();
                    return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
                }
            } else {
                DB::rollBack();
                return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
            }
        } else {
            $simpanDbxImpor = DB::table('dbximpor')
                ->where('itemid', '=', $request->itemid)
                ->update([
                    'itemname' => $request->temuanname
                ]);
            if ($simpanDbxImpor == true) {

                $simpanItem = DB::table('dbtcsodet')
                    ->join('dbtcsohed', 'dbtcsodet.csoid', '=', 'dbtcsohed.csoid')
                    ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                    ->where('dbtcsohed.pelakuuname', '=', $request->username)
                    ->where('dbtcsodet.csodetid', '=', $request->csodetid)
                    ->where('dbtcsohed.status', '=', 'A')
                    ->update([
                        'dbtcsodet.itemid' => $request->itemid,
                        'dbtcsodet.locationid' => $request->lokasi,
                        'dbtcsodet.color' => $color,
                        'dbtcsodet.remark' => $request->remark,
                        'dbtcsodet2.qty' => $request->qtycso,
                    ]);
                if ($simpanItem == true) {
                    DB::commit();
                    return response()->json(['result' => 1]);
                } else {
                    DB::rollBack();
                    return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
                }
            } else {
                DB::rollBack();
                return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
            }
        }
    }



    public function addTemuanAvalan(Request $request)
    {
        DB::beginTransaction();
        $color = implode(",", $request->color);
        // $color =  $request->color;


        if ($request->csodet2id == "") {
            $itemId = DB::table('dbximporavalan')->select('itemid')->where('statusitem', '=', 'T')->orderByDesc('createddate')->limit(1)->get();
            if (count($itemId) > 0) $itemId = $itemId[0]->itemid + 1;
            else $itemId = 9999001;

            $insertDbxImpor = DB::table('dbximporavalan')->insert([
                'itemid' => $itemId,
                'itemname' => trim(ucwords($request->temuanname)),
                'itembatchid' => $itemId,
                'statusitem' => 'T'
            ]);

            if ($insertDbxImpor == true) {
                $getTrsId = DB::table('dbttrsheda')->select('trsid')->orderByDesc('trsid')->limit(1)->get();

                $trsId = $getTrsId[0]->trsid;

                $insertdbttrsdeta = DB::table('dbttrsdeta')->insert([
                    'trsid' => $trsId,
                    'itemid' => $itemId,
                    'itemname' => trim(ucwords($request->temuanname)),
                    'itembatchid' => $itemId,
                    'statusitem' => 'T',
                    'statuscso' => 1
                ]);

                if ($insertdbttrsdeta) {
                    $selectdbtcsohed = DB::table('dbtcsohed')
                        ->select(DB::raw("csoid,'$itemId','$request->lokasi','$color','$request->remark','$request->statusItem','D','D'"))
                        ->where('pelakuuname', '=', $request->username)
                        ->where('csoid', '=', $request->csoid)
                        ->where('status', '=', 'A');

                    $insertdbtcsodet1 = DB::table('dbtcsodet')->insertUsing(['csoid', 'itemid', 'locationid', 'color', 'remark', 'statusitem', 'statussubmit', 'statushslcso'], $selectdbtcsohed);

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
                            DB::commit();
                            return response()->json(['result' => 1]);
                        } else {
                            DB::rollBack();
                            return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
                        }
                    } else {
                        DB::rollBack();
                        return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
                    }
                } else {
                    DB::rollBack();
                    return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
                }
            } else {
                DB::rollBack();
                return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
            }
        } else {
            $simpanDbxImpor = DB::table('dbximporavalan')
                ->where('itemid', '=', $request->itemid)
                ->update([
                    'itemname' => $request->temuanname
                ]);
            if ($simpanDbxImpor == true) {
                $simpanItem = DB::table('dbtcsodet')
                    ->join('dbtcsohed', 'dbtcsodet.csoid', '=', 'dbtcsohed.csoid')
                    ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                    ->where('dbtcsohed.pelakuuname', '=', $request->username)
                    ->where('dbtcsodet.csodetid', '=', $request->csodetid)
                    ->where('dbtcsohed.status', '=', 'A')
                    ->update([
                        'dbtcsodet.itemid' => $request->itemid,
                        'dbtcsodet.locationid' => $request->lokasi,
                        'dbtcsodet.color' => $color,
                        'dbtcsodet.remark' => $request->remark,
                        'dbtcsodet2.qty' => $request->qtycso,
                    ]);
                if ($simpanItem == true) {
                    DB::commit();
                    return response()->json(['result' => 1]);
                } else {
                    DB::rollBack();
                    return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
                }
            } else {
                DB::rollBack();
                return response()->json(['result' => 0, 'message' => 'Penambahan data gagal']);
            }
        }
    }
}
