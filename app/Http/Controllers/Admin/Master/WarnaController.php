<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Admin\Master\Warna;
use Illuminate\Console\View\Components\Warn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarnaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warna = Warna::all();
        return view("admin.master.warna",["color"=> $warna]);
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
        $data = new Warna;
        $data->colordesc = $request->deskripsi;        
        $data->created_by = Auth::user()->username;
        $data->save();
        return redirect()->route("warna.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Warna $warna)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warna $warna)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warna $warna)
    {
        $warna->colordesc = $request->deskripsi;
        $warna->updated_by = Auth::user()->username;
        $warna->save();
        return redirect()->route("warna.index")->with('status', 'Data warna berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warna $warna)
    {
        try {
            $warna->delete();
            return redirect()->route("warna.index")->with('status', 'Data warna berhasil dihapus');
        } catch(\PDOException $e) {
            $msg = "Data gagal dihapus karena data ini merupakan data parent dari tabel lain";
            return redirect()->route("warna.index")->with('error', $msg);
        }
    }
}
