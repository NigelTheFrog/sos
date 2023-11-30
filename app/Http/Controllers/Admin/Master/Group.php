<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Group extends Controller
{
    public function index() {
        $group = DB::table('dbmgroup')->get();
        //dd($group);
        return view("admin.master.group",["group"=> $group]);
    }
}
