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
        $keputusan = Keputusan::all();

        return view('admin.resume.avalan-selisih', ['tertukar' => $tertukar, 'selisih' => $selisih, 'keputusan' => $keputusan]);
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

        if ($request->type == 1) {
            $statusUpdateTertukar = true;
            for ($i = 0; $i < count($request->trsdetid); $i++) {
                $trsDetId = $request->trsdetid[$i];
                $keputusan = $request->keputusan[$i];
                $pembebanan = $request->pembebanan[$i];
                $nodoc = $request->nodok[$i];
                $keterangan = $request->keterangan[$i];

                $checkStatusUpdate = DB::table('dbttrsdeta')
                    ->where('trsdetid', '=', $trsDetId)
                    ->update([
                        'keputusan' => $keputusan,
                        'pembebanan' => $pembebanan,
                        'nodoc' => $nodoc,
                        'keterangan' => $keterangan
                    ]);

                // if ($checkStatusUpdate == false) {
                //     $statusUpdateTertukar = false;
                //     break;
                // }
            }

            // if ($statusUpdateTertukar == true) {
                DB::commit();
                return redirect()->route("avalan-selisih.index")->with('status', "Data avalan tertukar berhasil disimpan");
            // } else {
            //     DB::rollback();
            //     return redirect()->route("avalan-selisih.index")->with('error', "Gagal menyimpan data avalan tertukar ");
            // }
        } else {

            for ($i = 0; $i < count($request->trsdetid); $i++) {
                $trsDetId = $request->trsdetid[$i];
                $keputusan = $request->keputusan[$i];
                $pembebanan = $request->pembebanan[$i];
                $nodoc = $request->nodok[$i];
                $keterangan = $request->keterangan[$i];

                $checkStatusUpdate = DB::table('dbttrsdeta')
                    ->where('trsdetid', '=', $trsDetId)
                    ->update([
                        'keputusan' => $keputusan,
                        'pembebanan' => $pembebanan,
                        'nodoc' => $nodoc,
                        'keterangan' => $keterangan
                    ]);
            }
                DB::commit();
                return redirect()->route("avalan-selisih.index")->with('status', "Data avalan selisih berhasil disimpan");
            
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
