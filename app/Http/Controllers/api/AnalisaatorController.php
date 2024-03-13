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
        //     $dataAnalisator = DB::table('dbttrshed')
        // ->join('dbttrsdet', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
        // ->leftjoin('dbmgroup', 'dbttrsdet.groupid', '=', 'dbmgroup.groupid')
        // ->join('dbtcsohed', 'dbttrshed.trsid', '=', 'dbtcsohed.trsid')
        // ->leftjoin('dbtcsodet', function ($join) {
        //     $join->on('dbtcsohed.csoid', '=', 'dbtcsodet.csoid')
        //         ->on('dbttrsdet.itemid', '=', 'dbtcsodet.itemid');
        // })
        // ->leftjoin('dbtcsodet2', 'dbtcsodet.csodetid', '=', 'dbtcsodet2.csodetid')
        // ->where('dbttrsdet.analisatorid', '=', $request->userid)
        // ->where('dbttrshed.statusdoc', 'A')

        // ->select([
        //     'dbttrsdet.itemid',
        //     'dbttrsdet.itembatchid',
        //     'dbttrsdet.itemname',
        //     'dbmgroup.groupdesc',
        //     'dbttrsdet.onhand',
        //     'dbttrsdet.koreksi',
        //     'dbttrsdet.deviasi',
        //     'dbtcsohed.csoid',
        //     'dbtcsodet2.csodet2id',
        //     'dbtcsodet2.qty',
        //     'dbtcsodet2.history',
        //     'dbtcsodet2.inputs',
        //     DB::raw('(dbttrsdet.onhand - (dbtcsodet2.qty + dbttrsdet.koreksi + dbttrsdet.deviasi)) AS selisih'),
        //     'dbtcsodet2.csocount',
        // ])
        // ->get();
        $dataAnalisator = DB::table('dbttrshed as trshed')
            ->join('dbttrsdet as trsdet', 'trshed.trsid', '=', 'trsdet.trsid')
            ->leftJoin('dbmgroup', 'trsdet.groupid', '=', 'dbmgroup.groupid')
            ->join('dbtcsohed', 'trshed.trsid', '=', 'dbtcsohed.trsid')
            ->leftJoin('dbtcsodet', function ($join) {
                $join->on('dbtcsohed.csoid', '=', 'dbtcsodet.csoid')
                    ->on('trsdet.itemid', '=', 'dbtcsodet.itemid');
            })
            ->leftJoin('dbtcsodet2', 'dbtcsodet.csodetid', '=', 'dbtcsodet2.csodetid')
            ->where('trsdet.analisatorid', '=', '997595')
            ->where('trshed.statusdoc', 'A')
            ->select([
                'trsdet.itemid',
                'trsdet.itembatchid',
                'trsdet.itemname',
                'dbmgroup.groupdesc',
                'trsdet.onhand',
                'trsdet.koreksi',
                'trsdet.deviasi',
                'dbtcsohed.csoid',
                'dbtcsodet.csodetid',
                'dbtcsodet2.csodet2id',
                'dbtcsodet2.qty',
                'dbtcsodet2.history',
                'dbtcsodet2.inputs',
                DB::raw('(trsdet.onhand - (dbtcsodet2.qty + trsdet.koreksi + trsdet.deviasi)) AS selisih'),
                'dbtcsodet2.csocount',
            ])
            ->havingRaw('
    dbtcsodet2.csocount = (
        SELECT MAX(dbtcsodet2.csocount)
        FROM 
            dbttrshed
        JOIN 
            dbttrsdet ON dbttrshed.trsid = dbttrsdet.trsid
        LEFT JOIN 
            dbmgroup ON dbttrsdet.groupid = dbmgroup.groupid
        JOIN 
            dbtcsohed ON dbttrshed.trsid = dbtcsohed.trsid
        LEFT JOIN 
            dbtcsodet ON dbtcsohed.csoid = dbtcsodet.csoid AND dbttrsdet.itembatchid = dbtcsodet.itembatchid
        LEFT JOIN 
            dbtcsodet2 ON dbtcsodet.csodetid = dbtcsodet2.csodetid
        WHERE dbttrsdet.analisatorid =  trsdet.analisatorid AND dbttrshed.statusdoc = trshed.statusdoc 
        AND dbttrsdet.itembatchid = trsdet.itembatchid
        )
    ')
            ->get();

        return response()->json(['data' => $dataAnalisator]);
    }

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
        $dataAnalisator = DB::table('dbttrsheda as trsheda')
        ->join('dbttrsdeta as trsdeta', 'trsheda.trsid', '=', 'trsdeta.trsid')
        ->leftJoin('dbmgroup', 'trsdeta.groupid', '=', 'dbmgroup.groupid')
        ->join('dbtcsohed', 'trsheda.trsid', '=', 'dbtcsohed.trsid')
        ->leftJoin('dbtcsodet', function ($join) {
            $join->on('dbtcsohed.csoid', '=', 'dbtcsodet.csoid')
                ->on('trsdeta.itemid', '=', 'dbtcsodet.itemid');
        })
        ->leftJoin('dbtcsodet2', 'dbtcsodet.csodetid', '=', 'dbtcsodet2.csodetid')
        ->where('trsdeta.analisatorid', '=', '997595')
        ->where('trsheda.statusdoc', 'A')
        ->select([
            'trsdeta.itemid',
            'trsdeta.itembatchid',
            'trsdeta.itemname',
            'dbmgroup.groupdesc',
            'trsdeta.onhand',
            'trsdeta.koreksi',
            'trsdeta.deviasi',
            'dbtcsohed.csoid',
            'dbtcsodet.csodetid',
            'dbtcsodet2.csodet2id',
            'dbtcsodet2.qty',
            'dbtcsodet2.history',
            'dbtcsodet2.inputs',
            DB::raw('(trsdeta.onhand - (dbtcsodet2.qty + trsdeta.koreksi + trsdeta.deviasi)) AS selisih'),
            'dbtcsodet2.csocount',
        ])
            
            ->havingRaw('
                dbtcsodet2.csocount = (
                    SELECT MAX(dbtcsodet2.csocount)
                    FROM 
                        dbttrsheda
                    JOIN 
                        dbttrsdeta ON dbttrsheda.trsid = dbttrsdeta.trsid
                    LEFT JOIN 
                        dbmgroup ON dbttrsdeta.groupid = dbmgroup.groupid
                    JOIN 
                        dbtcsohed ON dbttrsheda.trsid = dbtcsohed.trsid
                    LEFT JOIN 
                        dbtcsodet ON dbtcsohed.csoid = dbtcsodet.csoid AND dbttrsdeta.itembatchid = dbtcsodet.itembatchid
                    LEFT JOIN 
                        dbtcsodet2 ON dbtcsodet.csodetid = dbtcsodet2.csodetid
                    WHERE dbttrsdeta.analisatorid =  trsdeta.analisatorid AND dbttrsheda.statusdoc = trsheda.statusdoc 
                    AND dbttrsdeta.itembatchid = trsdeta.itembatchid
                    )
                ')
            ->get();

        return response()->json(['data' => $dataAnalisator]);
    }

    public function updateItemAnalisator(Request $request)
    {
        DB::beginTransaction();
            if ($request->statusitem == 'R' ||$request->statusitem == 'T' ) {
                $updateItem = DB::table('dbttrsdet')
                    ->where('itembatchid', $request->itembatchid)
                    ->update([
                        'koreksi' => $request->koreksi,
                        'deviasi' => $request->deviasi,
                        'keterangan' => $request->keterangan,
                        'analisatorid' => $request->analisatorid,
                    ]);
            } else {
                $updateItem = DB::table('dbttrsdeta')
                    ->where('itembatchid', $request->itembatchid)
                    ->update([
                        'koreksi' => $request->koreksi,
                        'deviasi' => $request->deviasi,
                        'keterangan' => $request->keterangan,
                        'analisatorid' => $request->analisatorid,
                    ]);
            }

            if ($updateItem == true) {
                DB::commit();
                return response()->json(["result" => 1]);
            } else {
                DB::rollBack();
                return response()->json(["result" => 0]);
            }
    }
}
