<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin\Dashboard\Item;
use App\Models\ViewDashboard;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = ViewDashboard::all();
        $itemBlmProses = ViewDashboard::where('status','=', '0')->get();
        $countItemBlmProses = count($itemBlmProses);
        $itemSdgProses = ViewDashboard::where('status','!=', '0')->where('status','!=', '3')->get();
        $countItemSdgProses = count($itemSdgProses);
        $itemOk = ViewDashboard::where('status','=', '3')->get();
        $countItemOk=count($itemOk);
        $itemSelisih = ViewDashboard::where('selisih','>', '0')->get();
        $countItemSelisih = count($itemSelisih);
        return view("admin.dashboard.item", [
            'item'=>$item,
            "countItemBlmProses"=>$countItemBlmProses,"itemBlmProses"=>$itemBlmProses,
            "countItemSdgProses"=>$countItemSdgProses,"itemSdgProses"=>$itemSdgProses,
            "countItemOk"=>$countItemOk,"itemSelesai"=>$itemOk,
            "countItemSelisih"=>$countItemSelisih,"itemSelisih"=>$itemSelisih
        ]);
    }

    public function showMainTable()
    {
        $item = ViewDashboard::all();
        return view("admin.dashboard.table.main-table-item", ["item" => $item]);
    }

    public function showBannerTable(String $request) {
        if($request == "1") {
            $itemBlmProses = ViewDashboard::where('status','=', '0')->get();
            return view("admin.dashboard.table.item.item-belum-proses",["itemBlmProses"=>$itemBlmProses]);
        } else if($request == '2') {
            $itemSdgProses = ViewDashboard::where('status','!=', '0')->where('status','!=', '3')->get();
            return view("admin.dashboard.table.item.item-sedang-proses",["itemSdgProses"=>$itemSdgProses]);
        } else if($request == '3') {
            $itemOk = ViewDashboard::where('status','=', '3')->get();
            return view("admin.dashboard.table.item.item-ok",["itemSelesai"=>$itemOk]);
        } else {
            $itemSelisih = ViewDashboard::where('selisih','>', '0')->get();
            return view("admin.dashboard.table.item.item-selisih",["itemSelisih"=>$itemSelisih]);
        }

        // $countItemBlmProses = count($itemBlmProses);
        // $countItemSdgProses = count($itemSdgProses);
        // $countItemOk=count($itemOk);
        // $countItemSelisih = count($itemSelisih);
        // return view("admin.dashboard.table.banner-item", [
        //     "countItemBlmProses"=>$countItemBlmProses,"itemBlmProses"=>$itemBlmProses,
        //     "countItemSdgProses"=>$countItemSdgProses,"itemSdgProses"=>$itemSdgProses,
        //     "countItemOk"=>$countItemOk,"itemSelesai"=>$itemOk,
        //     "countItemSelisih"=>$countItemSelisih,"itemSelisih"=>$itemSelisih
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
