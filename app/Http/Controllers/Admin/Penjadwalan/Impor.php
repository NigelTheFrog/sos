<?php

namespace App\Http\Controllers\Admin\Penjadwalan;

use App\Http\Controllers\Controller;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Impor extends Controller
{
    public function imporStok() {
        $itembatch = DB::table("dbximpordet")
                        ->select("itembatchid as itembid", DB::raw('SUM(qty) as qty'))
                        ->groupBy("itembid");

        $stok = DB::table('dbximpor')
        ->leftJoinSub($itembatch, 'itembatch', function (JoinClause $join) {
            $join->on('dbximpor.itembatchid', '=', 'itembatch.itembid');
        })->get();
        return view("admin.penjadwalan.import-stok",["stok"=> $stok]);
    }

    public function imporAvalan() {
        $avalanBatch = DB::table("dbximpordetavalan")
                        ->select("itemid","batchid as batchiddet", DB::raw('SUM(qty) as qty'))
                        ->groupBy("itemid","batchiddet");
                        
        $avalan = DB::table('dbximporavalan')
        ->leftJoinSub($avalanBatch, 'avalanBatch', function (JoinClause $join) {
            $join->on('dbximporavalan.itemid', '=', 'avalanBatch.itemid')->on('dbximporavalan.batchid', '=', 'avalanBatch.batchiddet');
        })->get();
        return view("admin.penjadwalan.import-avalan",["avalan"=> $avalan]);
    }
}
