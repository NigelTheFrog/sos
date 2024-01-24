<?php

namespace App\Http\Controllers\Admin\Resume;

use App\Http\Controllers\Controller;
use App\Models\Admin\Resume\SusunanCso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SusunanTimCsoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getDataAnalisator = DB::table('dbtcsoprsn')->where('joBtypeid', '=', '2')->where('status', '=', 'D')->get();
        $getDataPelaku = DB::table('dbtcsoprsn')->where('joBtypeid', '=', '1')->where('status', '=', 'D')->get();
        return view('admin.resume.susunan-tim-cso', ['analisator' => $getDataAnalisator, 'pelaku' => $getDataPelaku]);
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
    public function show(SusunanCso $susunanCso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SusunanCso $susunanCso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        function updateDataSusunan($paramJobId, $paramDept, $paramKet, $jenisData)
        {
            $statusUpdate = true;
            for ($i = 0; $i < count($paramJobId); $i++) {
                $jobid = $paramJobId[$i];
                $dept = $paramDept[$i];
                $ket = $paramKet[$i];
                $checkStatusUpdate = DB::table('dbtcsoprsn')
                    ->where('jobid', '=', $jobid)
                    ->update(['dept' => $dept, 'note' => $ket]);
                
                    if($checkStatusUpdate == false) {
                        $statusUpdate = false;
                        break;
                    }
            }
            if($statusUpdate == true) {
                DB::commit();
                return redirect()->route("susunan-tim-cso.index")->with('status', "Berhasil mengubah data $jenisData susunan tim CSO");
            } else {
                DB::rollback();
                return redirect()->route("susunan-tim-cso.index")->with('error', "Gagal mengubah data $jenisData susunan tim CSO");
            }
        }

        if ($request->type == 1) {
            updateDataSusunan($request->jobidPelaku,$request->deptPelaku,$request->ketPelaku,"pelaku");
            
        } else {
            updateDataSusunan($request->jobidAnalisator,$request->deptAnalisator,$request->ketAnalisator,"analisator");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SusunanCso $susunanCso)
    {
        //
    }
}
