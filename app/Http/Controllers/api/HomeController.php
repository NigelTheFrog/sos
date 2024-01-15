<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function listItem(Request $request)
    {
        $subQueryJoinDbtCsoDet2 = DB::table('dbtcsodet2')
            ->select(['csodet2id', 'csodetid AS id', DB::raw('MAX(csocount) AS csocount'), 'qty'])
            ->groupBy('csodet2id', 'id', 'qty');

        $subQueryJoinDbtTrsDet = DB::table('dbttrsdet')
            ->join('dbttrshed', 'dbttrsdet.trsid', '=', 'dbttrshed.trsid')
            ->select(['trsdetid', 'dbttrsdet.trsid', 'itemid', 'itemname', 'onhand', 'uom', 'analisatorid'])
            ->where('statusdoc', '=', 'A');

        $data = DB::table('dbtcsodet')
            ->leftJoin('dbtcsohed', 'dbtcsohed.csoid', '=', 'dbtcsodet.csoid')
            ->leftJoinSub($subQueryJoinDbtCsoDet2, 'dbtcsodet2', function (JoinClause $join) {
                $join->on('dbtcsodet2.id', '=', 'dbtcsodet.csodetid');
            })
            ->leftJoin('dbmlocation', 'dbmlocation.locationid', '=', 'dbtcsodet.locationid')
            ->leftJoinSub($subQueryJoinDbtTrsDet, 'dbttrsdet', function (JoinClause $join) {
                $join->on('dbttrsdet.itemid', '=', 'dbtcsodet.itemid');
            })
            ->where('dbtcsohed.pelakuuname', '=', $request->username)
            ->where('dbtcsodet.csoid', '=', $request->csoid)
            ->where('dbtcsohed.status', '=', 'A')
            // ->orderBy('dbtcsodet.statussubmit', 'ASC')
            ->orderByDesc('dbtcsodet.csodetid')
            ->get();

        return response()->json(['data' => $data]);
    }

    public function submitItem(Request $request) {
        DB::beginTransaction();
        $submitItem = DB::table('dbtcsodet')
            ->leftJoin('dbtcsodet2', 'dbtcsodet.csodetid', '=', 'dbtcsodet2.csodetid')
            ->where('dbtcsodet.csoid','=', $request->csoid)
            ->whereRaw('IFNULL(dbtcsodet2.qty, 0) <> 0')
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
}
