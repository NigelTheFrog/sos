<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaLokasi extends Controller
{
    public function index() {
        $lokasi = DB::table('dbmlocation')->get();
        //dd($lokasi);
        return view("admin.master.area-lokasi",["lokasi"=> $lokasi]);
    }
}
