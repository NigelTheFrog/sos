<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipeUser extends Controller
{
    public function index() {
        $tipe = DB::table('dbmjobtype')->get();
        //dd($tipe);
        return view("admin.master.tipe-user",["tipeUser"=> $tipe]);
    }
}
