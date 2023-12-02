<?php

namespace App\Http\Controllers\Admin\Penjadwalan;

use App\Http\Controllers\Controller;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Pengaturan extends Controller
{
    public function index() {
        $jobtype = DB::table('dbxjob')->leftJoin('dbmjobtype','dbxjob.jobtypeid','=','dbmjobtype.jobtypeid')->get();
        $category = DB::table('dbmcategory')->get();

        $job = DB::table("dbxjob")
                        ->select("userid as useridjob");                        
        $user = DB::table('dbmuser')
        ->leftJoinSub($job, 'job', function (JoinClause $join) {
            $join->on('dbmuser.userid', '=', 'job.useridjob');
        })->whereNull('job.useridjob')->get();
        return view("admin.penjadwalan.pengaturan",["jobtype"=> $jobtype,"category"=>$category, "pelaku"=>$user]);
    }

}
