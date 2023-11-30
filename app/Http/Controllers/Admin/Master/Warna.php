<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Warna extends Controller
{
    public function index() {
        $warna = DB::table('dbmcolor')->get();
        //dd($warna);
        return view("admin.master.warna",["color"=> $warna]);
    }
}
