<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ViewDashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        $item = ViewDashboard::where('itemname','LIKE', '%%')->orWhere('analisator','LIKE','%%')->get();
        $itemBlmProses = ViewDashboard::where('status','=', '0')->get();
        $itemSdgProses = ViewDashboard::where('status','!=', '0')->where('status','!=', '3')->get();
        return view("admin.dashboarditem", ['item'=>$item,"itemBlmProses"=>$itemBlmProses,"itemSdgProses"=>$itemSdgProses]);
    }

   
}
