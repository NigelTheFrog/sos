<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ViewDashboard;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function listItem(Request $request)
    {
        $subQueryJoinDbtCsoDet2 = DB::table('dbtcsodet2')
            ->select(['csodet2id', 'csodetid AS id', DB::raw('MAX(csocount) AS csocount'), 'qty', 'history', 'inputs'])
            ->groupBy('csodet2id', 'id', 'qty');

        $subQueryJoinDbtTrsDet = DB::table('dbttrsdet')
            ->join('dbttrshed', 'dbttrsdet.trsid', '=', 'dbttrshed.trsid')
            ->select(['trsdetid', 'dbttrsdet.trsid', 'itemid', 'itembatchid', 'batchno', 'itemname', 'onhand', 'uom', 'analisatorid'])
            ->where('statusdoc', '=', 'A');    

        $data = DB::table('dbtcsodet')
            ->leftJoin('dbtcsohed', 'dbtcsohed.csoid', '=', 'dbtcsodet.csoid')
            ->leftJoinSub($subQueryJoinDbtCsoDet2, 'dbtcsodet2', function (JoinClause $join) {
                $join->on('dbtcsodet2.id', '=', 'dbtcsodet.csodetid');
            })
            ->leftJoin('dbmlocation', 'dbmlocation.locationid', '=', 'dbtcsodet.locationid')
            ->leftJoinSub($subQueryJoinDbtTrsDet, 'dbttrsdet', function (JoinClause $join) {
                $join->on('dbttrsdet.itembatchid', '=', 'dbtcsodet.itembatchid');
            })
            ->where('dbtcsohed.pelakuuname', '=', $request->username)
            ->where('dbtcsodet.csoid', '=', $request->csoid)
            ->where('dbtcsohed.status', '=', 'A')
            ->where('dbtcsohed.tipecso', '=', 'R')
            ->orderByDesc('dbtcsodet.csodetid')
            ->get();

        return response()->json(['data' => $data]);
    }   

    public function listAvalan(Request $request)
    {
        $subQueryJoinDbtCsoDet2 = DB::table('dbtcsodet2')
            ->select(['csodet2id', 'csodetid AS id', DB::raw('MAX(csocount) AS csocount'), 'qty', 'history', 'inputs'])
            ->groupBy('csodet2id', 'id', 'qty');

        $subQueryJoinDbtTrsDet = DB::table('dbttrsdeta')
            ->join('dbttrsheda', 'dbttrsdeta.trsid', '=', 'dbttrsheda.trsid')
            ->select(['trsdetid', 'dbttrsdeta.trsid', 'itemid', 'itembatchid', 'itemname', 'batchno', 'onhand', 'uom', 'analisatorid'])
            ->where('statusdoc', '=', 'A');    

        $data = DB::table('dbtcsodet')
            ->leftJoin('dbtcsohed', 'dbtcsohed.csoid', '=', 'dbtcsodet.csoid')
            ->leftJoinSub($subQueryJoinDbtCsoDet2, 'dbtcsodet2', function (JoinClause $join) {
                $join->on('dbtcsodet2.id', '=', 'dbtcsodet.csodetid');
            })
            ->leftJoin('dbmlocation', 'dbmlocation.locationid', '=', 'dbtcsodet.locationid')
            ->leftJoinSub($subQueryJoinDbtTrsDet, 'dbttrsdeta', function (JoinClause $join) {
                $join->on('dbttrsdeta.itembatchid', '=', 'dbtcsodet.itembatchid');
            })
            ->where('dbtcsohed.pelakuuname', '=', $request->username)
            ->where('dbtcsodet.csoid', '=', $request->csoid)
            ->where('dbtcsohed.status', '=', 'A')
            ->where('dbtcsohed.tipecso', '=', 'A')
            ->orderByDesc('dbtcsodet.csodetid')
            ->get();

        return response()->json(['data' => $data]);
    }   

    public function submitItem(Request $request) {
        DB::beginTransaction();
        $submitItem = DB::table('dbtcsodet')
            ->leftJoin('dbtcsodet2', 'dbtcsodet.csodetid', '=', 'dbtcsodet2.csodetid')
            ->where('dbtcsodet.csoid','=', $request->csoid)
            ->whereNotNull('dbtcsodet2.qty')
            ->update([
                'statussubmit' => 'P',
            ]);

        if ($submitItem == true) {
            DB::commit();
            return response()->json(['result' => 1]);
        } else {
            DB::rollBack();
            return response()->json(['result' => 0, 'message' => 'Penambahan data item gagal']);
        }   
    }

    public function checkCsoItemStatus(Request $request) {
        $data = DB::table('dbttrshed')->where('dbttrshed.statusdoc', '=', 'A')->orderByDesc('trsid')->limit(1)->get();

        if(count($data) > 0) {
            $checkDbxJob = DB::table('dbxjob')->where('username', '=', $request->username)->get();
            if(count($checkDbxJob) > 0 ) {
                return response()->json(['result' => 1, 'trsid' => $data[0]->trsid]);
            } else {
                return response()->json(['result' => 0]); 
            }            
        } else {
            return response()->json(['result' => 0]);
        }
    }

    public function checkCsoAvalanStatus(Request $request) {
        $data = DB::table('dbttrsheda')->where('dbttrsheda.statusdoc', '=', 'A')->orderByDesc('trsid')->limit(1)->get();

        if(count($data) > 0) {
            $checkDbxJob = DB::table('dbxjob')->where('username', '=', $request->username)->get();
            if(count($checkDbxJob) > 0 ) {
                return response()->json(['result' => 1, 'trsid' => $data[0]->trsid]);
            } else {
                return response()->json(['result' => 0]); 
            }            
        } else {
            return response()->json(['result' => 0]);
        }
    }
}
