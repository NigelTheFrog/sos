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
        $tertukar = DB::select('CALL ReportTertukar()');
        $selisih = DB::select('CALL ReportSelisih()');        
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

        if ($request->type == 1) {
            $statusUpdate = true;
            for ($i = 0; $i < count($request->trsdetid); $i++) {
                $trsDetId = $request->trsdetid[$i];
                $keputusan = $request->keputusan[$i];
                $pembebanan = $request->pembebanan[$i];
                $nodoc = $request->nodok[$i];
                $keterangan = $request->keterangan[$i];

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
                return redirect()->route("barang-selisih.index")->with('status', "Data item tertukar berhasil disimpan");
            } else {
                DB::rollback();
                return redirect()->route("barang-selisih.index")->with('error', "Gagal menyimpan data item tertukar ");
            }
            
        } else {

            $statusUpdate = true;
            for ($i = 0; $i < count($request->trsdetid); $i++) {
                $trsDetId = $request->trsdetid[$i];
                $keputusan = $request->keputusan[$i];
                $pembebanan = $request->pembebanan[$i];
                $nodoc = $request->nodok[$i];
                $keterangan = $request->keterangan[$i];

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
                return redirect()->route("barang-selisih.index")->with('status', "Data item selisih berhasil disimpan");
            } else {
                DB::rollback();
                return redirect()->route("barang-selisih.index")->with('error', "Gagal menyimpan data item selisih ");
            }
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
