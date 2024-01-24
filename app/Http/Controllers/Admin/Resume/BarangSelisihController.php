<?php

namespace App\Http\Controllers\Admin\Resume;

use App\Http\Controllers\Controller;
use App\Models\Admin\Master\Keputusan;
use App\Models\Admin\Resume\BarangSelisih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangSelisihController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tertukar = BarangSelisih::where('groupid', '!=', '0')->orderBy('groupid')->get();
        $selisih = BarangSelisih::all();
        // $selisih = BarangSelisih::where('groupid', '=', '0')
        //     ->where(function ($query) {
        //         $query->where('selisihplus', '!=', 0)
        //             ->orWhere('selisihmin', '!=', 0);
        //     })
        //     ->orderBy('itemname')
        //     ->get();
        
        $keputusan = Keputusan::all();

        return view('admin.resume.barang-selisih',['tertukar'=>$tertukar,'selisih'=>$selisih,'keputusan'=>$keputusan]);
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
    public function show(BarangSelisih $barangSelisih)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarangSelisih $barangSelisih)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        DB::beginTransaction();

        function updateDataSelisih($paramTrsId, $paramKeputusan, $paramPembebanan, $paramNodoc,$paramKeterangan, $jenisData)
        {
            $statusUpdate = true;
            for ($i = 0; $i < count($paramTrsId); $i++) {
                $trsDetId = $paramTrsId[$i];
                $keputusan = $paramKeputusan[$i];
                $pembebanan = $paramPembebanan[$i];
                $nodoc = $paramNodoc[$i];
                $keterangan = $paramKeterangan[$i];

                $checkStatusUpdate = DB::table('dbttrsdet')
                    ->where('trsdetid', '=', $trsDetId)
                    ->update([
                        'keputusan' => $keputusan, 
                        'pembebanan' => $pembebanan,
                        'nodoc' => $nodoc, 
                        'keterangan' => $keterangan
                    ]);
                
                    if($checkStatusUpdate == false) {
                        $statusUpdate = false;
                        break;
                    }
            }
            if($statusUpdate == true) {
                DB::commit();
                return redirect()->route("barang-selisih.index")->with('status', "Data $jenisData berhasil disimpan");
            } else {
                DB::rollback();
                return redirect()->route("barang-selisih.index")->with('error', "Gagal menyimpan data $jenisData ");
            }
        }

        if ($request->type == 1) {
            updateDataSelisih($request->trsdetid,$request->keputusan,$request->pembebanan,$request->nodok,$request->keterangan,"tertukar");
            
        } else {
            updateDataSelisih($request->trsdetid,$request->keputusan,$request->pembebanan,$request->nodok,$request->keterangan,"selisih");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangSelisih $barangSelisih)
    {
        //
    }
}
