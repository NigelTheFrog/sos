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
        $itemSdgProses = ViewDashboard::where('status','!=', '0')->where('status','!=', '3')->get();
        return view("admin.dashboard.item", ['item'=>$item,"itemBlmProses"=>$itemBlmProses,"itemSdgProses"=>$itemSdgProses]);
    }

    public function showMainTable()
    {
        $item = ViewDashboard::all();
        return view("admin.dashboard.table.main-table-item", ["item" => $item]);
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
        //
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
