<?php

namespace App\Http\Controllers\Admin\Penjadwalan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Pengaturan extends Controller
{
    public function index() {
        $jobtype = DB::table('dbxjob')->leftJoin('dbmjobtype','dbxjob.jobtypeid','=','dbmjobtype.jobtypeid')->get();
        //dd($jobtype);
        return view("admin.penjadwalan.pengaturan",["jobtype"=> $jobtype]);
    }

}
