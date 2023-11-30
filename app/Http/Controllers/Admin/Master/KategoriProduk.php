<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriProduk extends Controller
{
    public function index() {
        $kategori = DB::table('dbmcategory')->get();
        //dd($kategori);
        return view("admin.master.kategori-produk",["kategori"=> $kategori]);
    }
}
