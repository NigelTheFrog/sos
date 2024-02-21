<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailController extends Controller
{
    public function updatePerhitungan(Request $request)
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

    public function updateItem(Request $request)
    {
        DB::beginTransaction();
        // $color = implode(",", $request->color);

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
                    'dbtcsodet.color' => $request->color,
                    'dbtcsodet.remark' => $request->remark,
                    'dbtcsodet2.qty' => $request->qtycso,
                ]);
        


        if ($simpanItem == true) {
            DB::commit();
            return response()->json(['result' => 1, 'data' => $simpanItem]);
        } else {
            DB::rollBack();
            return response()->json(['result' => 0, 'message' => 'Penambahan data item gagal']);
        }
    }

    public function updateTemuan(Request $request)
    {
        DB::beginTransaction();
        $color = implode(",", $request->color);

        if ($request->statusItem == 'T') {
            $updateDbxImpor = DB::table('dbximpor')
                ->where('temid', '=', $request->itemid)
                ->update([
                    'itemname' => trim(ucwords($request->temuanname))
                ]);
        } else {
            $updateDbxImpor = DB::table('dbximporavalan')
                ->where('temid', '=', $request->itemid)
                ->update([
                    'itemname' => trim(ucwords($request->temuanname))
                ]);
        }
        if ($updateDbxImpor == true) {
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
                return response()->json(['result' => 1, 'data' => $simpanItem]);
            } else {
                DB::rollBack();
                return response()->json(['result' => 0, 'message' => 'Perubahan data temuan gagal']);
            }
        } else {
            DB::rollBack();
                return response()->json(['result' => 0, 'message' => 'Perubahan data temuan gagal']);
        }
    }
}
