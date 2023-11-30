<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Company extends Controller
{
    public function index() {
        $company = DB::table('dbmcoy')->get();
        return view("admin.master.company",["company"=> $company]);
    }}
