<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Admin\Master\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = KategoriProduk::all();
        return view("admin.master.kategori-produk",["kategori"=> $kategori]);
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
        $data = new KategoriProduk;
        $data->categorydesc = $request->deskripsi;        
        $data->created_by = Auth::user()->username;
        $data->save();
        return redirect()->route("kategori-produk.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriProduk $kategoriProduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriProduk $kategoriProduk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriProduk $kategoriProduk)
    {
        $kategoriProduk->categorydesc = $request->deskripsi;
        $kategoriProduk->updated_by = Auth::user()->username;
        $kategoriProduk->save();
        return redirect()->route("kategori-produk.index")->with('status', 'Data kategori berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriProduk $kategoriProduk)
    {
        try {
            $kategoriProduk->delete();
            return redirect()->route("kategori-produk.index")->with('status', 'Data kategori berhasil dihapus');
        } catch(\PDOException $e) {
            $msg = "Data gagal dihapus karena data ini merupakan data parent dari tabel lain";
            return redirect()->route("kategori-produk.index")->with('error', $msg);
        }
    }
}
