<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function item() {
        $item = DB::table('dbttrsdet')
        ->join('dbttrshed', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
        ->where('dbttrshed.statusdoc', '=', 'A')
        ->get();
        return response()->json(['result'=>0,'data'=>$item]); 
    }

    public function lokasi() {
        $item = DB::table('dbttrsdet')
        ->join('dbttrshed', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
        ->where('dbttrshed.statusdoc', '=', 'A')
        ->get();
        return response()->json(['result'=>0,'data'=>$item]); 
    }

    public function warna() {
        $item = DB::table('dbttrsdet')
        ->join('dbttrshed', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
        ->where('dbttrshed.statusdoc', '=', 'A')
        ->get();
        return response()->json(['result'=>0,'data'=>$item]); 
    }

}
