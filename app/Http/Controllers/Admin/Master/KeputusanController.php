<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Admin\Master\Keputusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeputusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keputusan = Keputusan::all();
        return view("admin.master.keputusan",["keputusan"=> $keputusan]);
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
        $data = new Keputusan;
        $data->keputusandesc = $request->deskripsi;        
        $data->created_by = Auth::user()->username;
        $data->save();
        return redirect()->route("keputusan.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Keputusan $keputusan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keputusan $keputusan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keputusan $keputusan)
    {
        $keputusan->keputusandesc = $request->deskripsi;
        $keputusan->updated_by = Auth::user()->username;
        $keputusan->save();
        return redirect()->route("keputusan.index")->with('status', 'Data keputusan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keputusan $keputusan)
    {
        try {
            $keputusan->delete();
            return redirect()->route("keputusan.index")->with('status', 'Data keputusan berhasil dihapus');
        } catch(\PDOException $e) {
            $msg = "Data gagal dihapus karena data ini merupakan data parent dari tabel lain";
            return redirect()->route("keputusan.index")->with('error', $msg);
        }
    }
}
