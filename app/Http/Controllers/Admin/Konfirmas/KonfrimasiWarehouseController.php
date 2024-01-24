<?php

namespace App\Http\Controllers\Admin\Konfirmas;

use App\Http\Controllers\Controller;
use App\Models\Admin\Konfirmasi\KonfirmasiWarehouse;
use App\Models\Admin\Penjadwalan\Pengaturan;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KonfrimasiWarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelaku = DB::table('dbtcsohed')
        ->join('dbtcsodet','dbtcsohed.csoid','=','dbtcsodet.csoid')
        ->join('dbmuser','dbtcsohed.pelakuid', '=', 'dbmuser.userid')
        ->where('dbtcsohed.status','=', 'A')
        ->where('dbtcsodet.statussubmit','=', 'P')
        ->get();
        return view("admin.konfirmasi.konfirmasi-wrh",['pelaku'=>$pelaku]);
       
        
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
        $selectDbtTrsDet = DB::table('dbttrsdet')->select('itemid','itemname')->distinct();
        $getData = DB::table('dbtcsodet')
        ->join('dbtcsohed','dbtcsohed.csoid','=','dbtcsodet.csoid')
        ->leftJoin('dbtcsodet2','dbtcsodet2.csodetid','=','dbtcsodet.csodetid')
        ->leftJoinSub($selectDbtTrsDet, 'dbttrsdet', function (JoinClause $join) {
            $join->on('dbttrsdet.itemid', '=', 'dbtcsodet.itemid');
        })
        ->leftjoin('dbmuser','dbmuser.userid','=','dbtcsohed.pelakuid')
        ->leftjoin('dbmcolor','dbmcolor.colorid','=','dbtcsodet.color')
        ->leftjoin('dbmlocation','dbmlocation.locationid','=','dbtcsodet.locationid')        
        ->where('dbtcsohed.status','=','A')
        ->where('dbtcsohed.pelakuid', '=', $request->pelaku)
        ->get();

        return view('admin.konfirmasi.tabel-konfirmasi-wrh',['datauser'=>$getData]);
    }

    /**
     * Display the specified resource.
     */
    public function show(KonfirmasiWarehouse $konfirmasiWarehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KonfirmasiWarehouse $konfirmasiWarehouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // DB::table('dbtcsodet')->
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KonfirmasiWarehouse $konfirmasiWarehouse)
    {
        //
    }
}
