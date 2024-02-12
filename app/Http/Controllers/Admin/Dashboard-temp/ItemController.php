<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ViewDashboard;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index() {
        $item = ViewDashboard::where('itemname','LIKE', '%%')->orWhere('analisator','LIKE','%%')->get();
        $itemBlmProses = ViewDashboard::where('status','=', '0')->get();
        $itemSdgProses = ViewDashboard::where('status','!=', '0')->where('status','!=', '3')->get();
        return view("admin.dashboard.item", ['item'=>$item,"itemBlmProses"=>$itemBlmProses,"itemSdgProses"=>$itemSdgProses]);
    }
}
