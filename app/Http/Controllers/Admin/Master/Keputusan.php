<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Keputusan extends Controller
{
    public function index() {
        $keputusan = DB::table('dbmkeputusan')->get();
        //dd($keputusan);
        return view("admin.master.keputusan",["keputusan"=> $keputusan]);
    }
}
