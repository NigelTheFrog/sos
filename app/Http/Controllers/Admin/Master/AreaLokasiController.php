<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Admin\Master\AreaLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AreaLokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lokasi = AreaLokasi::orderBy('locationcode')->get();
        return view("admin.master.area-lokasi",["lokasi"=> $lokasi]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new AreaLokasi;
        $data->locationcode = $request->locationcode;
        $data->locationname = $request->namalokasi;        
        $data->created_by = Auth::user()->username;
        $data->save();
        return redirect()->route("area-lokasi.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(AreaLokasi $areaLokasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AreaLokasi $areaLokasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AreaLokasi $areaLokasi)
    {
        $areaLokasi->locationcode = $request->locationcode;
        $areaLokasi->locationname = $request->namalokasi;
        $areaLokasi->updated_by = Auth::user()->username;
        $areaLokasi->save();
        return redirect()->route("area-lokasi.index")->with('status', 'Data lokasi berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AreaLokasi $areaLokasi)
    {
        try {
            $areaLokasi->delete();
            return redirect()->route("area-lokasi.index")->with('status', 'Data lokasi berhasil dihapus');
        } catch(\PDOException $e) {
            $msg = "Data gagal dihapus karena data ini merupakan data parent dari tabel lain";
            return redirect()->route("area-lokasi.index")->with('error', $msg);
        }
    }
}
