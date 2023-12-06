<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin\Dashboard\AvalanProduk;
use App\Models\ViewDashboardAvalan;
use Illuminate\Http\Request;

class AvalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $avalan = ViewDashboardAvalan::all();
        $avalanBlmProses = ViewDashboardAvalan::where('status','=', '0')->get();
        $avalanSdgProses = ViewDashboardAvalan::where('status','!=', '0')->where('status','!=', '3')->get();
        return view("admin.dashboard.avalan", ["avalan"=>$avalan,"avalanBlmProses"=>$avalanBlmProses,"avalanSdgProses"=>$avalanSdgProses]);
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
    public function show(AvalanProduk $avalanProduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AvalanProduk $avalanProduk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AvalanProduk $avalanProduk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AvalanProduk $avalanProduk)
    {
        //
    }
}
