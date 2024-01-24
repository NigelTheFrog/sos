<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Admin\Master\AreaLokasi;
use App\Models\Admin\Master\Warna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddController extends Controller
{
    public function item() {
        $item = DB::table('dbttrsdet')
        ->join('dbttrshed', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
        ->where('dbttrshed.statusdoc', '=', 'A')
        ->get();
        return response()->json(['data'=>$item]); 
    }

    public function lokasi() {
        $lokasi = AreaLokasi::all()->sortBy('locationcode');
        return response()->json(['data'=>$lokasi]); 
    }

    public function warna() {
        $warna = Warna::all()->sortBy('colordesc');
        return response()->json(['data'=>$warna]); 
    }

    public function avalan() {
        $avalan= DB::table('dbttrsdeta')
        ->join('dbttrsheda', 'dbttrsheda.trsid', '=', 'dbttrsdeta.trsid')
        ->where('dbttrsheda.statusdoc', '=', 'A')
        ->get();
        return response()->json(['data'=>$avalan]); 
    }    
}
