<?php

namespace App\Http\Controllers\Admin\Resume;

use App\Http\Controllers\Controller;
use App\Models\Admin\Master\Keputusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AvalanSelisihController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tertukar = DB::select('CALL ReportAvalanTertukar()');
        $selisih = DB::select('CALL ReportAvalanSelisih()');
        $kesalahan_admin = DB::select('CALL ReportAvalanKesalahanAdmin()');
        $keputusan = Keputusan::all();

        return view('admin.resume.avalan-selisih', [
            'tertukar' => $tertukar, 
            'selisih' => $selisih, 
            'keputusan' => $keputusan,
            'kesalahan_admin' => $kesalahan_admin

        ]);
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
        DB::beginTransaction();

            $statusUpdate = true;
            for ($i = 0; $i < count($request->trsdetid); $i++) {
                $trsDetId = $request->trsdetid[$i];
                $keputusan = $request->keputusan[$i];
                $pembebanan = $request->pembebanan[$i];
                $nodoc = $request->nodok[$i];
                $keterangan = $request->keterangan[$i];
                $hpp = $request->hpp[$i];

                $checkStatusUpdate = DB::table('dbttrsdeta')
                    ->where('trsdetid', '=', $trsDetId)
                    ->update([
                        'keputusan' => $keputusan,
                        'pembebanan' => $pembebanan,
                        'nodoc' => $nodoc,
                        'keterangan' => $keterangan,
                        'cogs_manual' => $hpp
                    ]);

                if ($checkStatusUpdate == false) {
                        $statusUpdate = false;
                        break;
                    }

                
            }

            if ($statusUpdate == true) {
                DB::commit();
                if ($request->type == 1) return redirect()->route("avalan-selisih.index")->with('status',  "Data avalan tertukar berhasil disimpan");
                elseif ($request->type == 2) return redirect()->route("avalan-selisih.index")->with('status',  "Data avalan selisih berhasil disimpan");
                else return redirect()->route("avalan-selisih.index")->with('status',  "Data avalan kesalahan admin berhasil disimpan");
            } else {
                DB::rollback();
                if ($request->type == 1) return redirect()->route("avalan-selisih.index")->with('error', "Gagal menyimpan data avalan tertukar ");
                elseif ($request->type == 2) return redirect()->route("avalan-selisih.index")->with('error', "Gagal menyimpan data avalan selisih ");
                else return redirect()->route("avalan-selisih.index")->with('error', "Gagal menyimpan data avalan kesalahan admin ");
            }

              
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
