<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class User extends Controller
{
    public function index() {
        $user = DB::table('dbmuser')->leftJoin('dbmlevel','dbmuser.level','=','dbmlevel.levelid')->get();
        //dd($user);
        return view("admin.master.user",["user"=> $user]);
    }

    
}
