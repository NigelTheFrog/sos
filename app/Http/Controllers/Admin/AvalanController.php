<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ViewDashboardAvalan;
use Illuminate\Http\Request;

class AvalanController extends Controller
{
    public function index() {
        $avalan = ViewDashboardAvalan::where('itemname','LIKE', '%%')->orWhere('analisator','LIKE','%%')->get();
        $avalanBlmProses = ViewDashboardAvalan::where('status','=', '0')->get();
        $avalanSdgProses = ViewDashboardAvalan::where('status','!=', '0')->where('status','!=', '3')->get();
        return view("admin.dashboard.avalan", ["avalan"=>$avalan,"avalanBlmProses"=>$avalanBlmProses,"avalanSdgProses"=>$avalanSdgProses]);
    }
}
