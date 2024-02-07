<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ReportCekStokAvalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getdbttrsheda = DB::table('dbttrsheda')->where('statusdoc', '=', 'P')->get();
        return view('admin.report.cek-stok-avalan', ['listNodoc' => $getdbttrsheda]);
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
        Carbon::setLocale('id');
        $pdf = App::make('dompdf.wrapper');
        if ($request->type == 1) {
            $datadbttrsheda = DB::table('dbttrsheda')->where('trsid', '=', $request->trsidresume)->get();

            $dataAnalisator = DB::table('dbtcsoprsn')
                ->where('trsid', '=', $request->trsidresume)
                ->where('joBtypeid', '=', '2')
                ->get();

            $dataPelaku = DB::table('dbtcsoprsn')
                ->where('trsid', '=', $request->trsidresume)
                ->where('joBtypeid', '=', '1')
                ->get();

            $dataTertukar = DB::table('reportselisih')
                ->where('groupid', '!=', 0)
                ->orderBy('groupid')
                ->orderBy('itemname')
                ->get();

            $dataSelisih = DB::table('reportselisih')
                ->where('groupid', 0)
                ->where(function ($query) {
                    $query->where('selisihplus', '<>', 0)
                        ->orWhere('selisihmin', '<>', 0);
                })
                ->orderBy('itemname')
                ->get();

            $dataRekapitulasi = DB::select('CALL RekapitulasiHasilCsoAvalan(?)', [$request->trsidresume]);

            $dataItemKesalahanAdmin = DB::table('dbttrsdeta')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdeta.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(
                    'dbttrsdeta.itemname',
                    'dbttrsdeta.batchno',
                    'dbttrsdeta.keputusan',
                    'dbttrsdeta.onhand',
                    'dbttrsdeta.nodoc',
                    DB::raw('dbttrsdeta.cogs as hpp'),
                    'dbttrsdeta.keterangan',
                    DB::raw('coalesce(dbttrsdeta.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdeta.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdeta.deviasi,0) as deviasi')
                )
                ->where('dbttrsdeta.trsid', '=', $request->trsidresume)
                ->whereRaw('coalesce(dbttrsdeta.kesalahan_admin,0) = 1')
                ->groupBy('dbttrsdeta.trsdetid')
                ->get();

            $dataItemSelisihTertukar = DB::table('dbttrsdeta')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdeta.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(
                    'dbttrsdeta.itemname',
                    'dbttrsdeta.batchno',
                    'dbttrsdeta.keputusan',
                    'dbttrsdeta.onhand',
                    'dbttrsdeta.nodoc',
                    DB::raw('dbttrsdeta.cogs as hpp'),
                    'dbttrsdeta.keterangan',
                    DB::raw('coalesce(dbttrsdeta.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdeta.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdeta.deviasi,0) as deviasi')
                )
                ->where('dbttrsdeta.trsid', '=', $request->trsidresume)
                ->whereRaw('not (coalesce(dbttrsdeta.groupid,0) = 0)')
                ->whereRaw('coalesce(dbttrsdeta.kesalahan_admin,0) = 0')
                ->groupBy('dbttrsdeta.trsdetid')
                ->get();

            $dataItemSelisih = DB::table('dbttrsdeta')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdeta.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(
                    'dbttrsdeta.itemname',
                    'dbttrsdeta.batchno',
                    'dbttrsdeta.keputusan',
                    'dbttrsdeta.onhand',
                    'dbttrsdeta.nodoc',
                    DB::raw('dbttrsdeta.cogs as hpp'),
                    'dbttrsdeta.keterangan',
                    DB::raw('coalesce(dbttrsdeta.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdeta.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdeta.deviasi,0) as deviasi')
                )
                ->where('dbttrsdeta.trsid', '=', $request->trsidresume)
                ->whereRaw('coalesce(dbttrsdeta.groupid,0) = 0')
                ->whereRaw('coalesce(dbttrsdeta.kesalahan_admin,0) = 0')
                ->groupBy('dbttrsdeta.trsdetid')
                ->get();

            $item_ok = DB::table('dbttrsheda')
                ->join('dbttrsdeta', 'dbttrsheda.trsid', '=', 'dbttrsdeta.trsid')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdeta.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(DB::raw("COUNT(distinct dbttrsdeta.trsdetid) as count, DATE_FORMAT(dbttrsheda.startcsodate, '%m') as monthstart, dbttrsheda.csomaterial"))
                ->where('dbttrsheda.statusdoc', 'P')
                ->whereRaw('(coalesce(dbttrsdeta.koreksi, 0) + coalesce(dbttrsdeta.deviasi, 0) + coalesce(dbtcsodet2.qty, 0)) = dbttrsdeta.onhand')
                ->whereRaw('dbttrsheda.startcsodate >= DATE_SUB(DATE_SUB(CURDATE(), interval 1 month), interval 3 month)')
                ->whereRaw('dbttrsheda.startcsodate < DATE_SUB(CURDATE(), interval 1 month)')
                ->groupBy('monthstart', 'dbttrsheda.csomaterial');

            $item_ada = DB::table('dbttrsheda')
                ->join('dbttrsdeta', 'dbttrsheda.trsid', '=', 'dbttrsdeta.trsid')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdeta.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(DB::raw("COUNT(distinct dbttrsdeta.trsdetid) as count, DATE_FORMAT(dbttrsheda.startcsodate, '%m') as monthstart, dbttrsheda.csomaterial"))
                ->where('dbttrsheda.statusdoc', 'P')
                ->whereRaw('coalesce(dbtcsodet2.qty, 0) > 0')
                ->whereRaw('dbttrsheda.startcsodate >= DATE_SUB(DATE_SUB(CURDATE(), interval 1 month), interval 3 month)')
                ->whereRaw('dbttrsheda.startcsodate < DATE_SUB(CURDATE(), interval 1 month)')
                ->groupBy('monthstart', 'dbttrsheda.csomaterial');

            $data3BulanTerakhir = DB::query()
                ->fromSub($item_ok, 'item_ok')
                ->joinSub($item_ada, 'item_ada', function ($join) {
                    $join->on('item_ok.monthstart', '=', 'item_ada.monthstart');
                    $join->on('item_ok.csomaterial', '=', 'item_ada.csomaterial');
                })
                ->select('item_ok.monthstart', 'item_ok.csomaterial', 'item_ok.count as item_ok', 'item_ada.count as item_ada')
                ->get();    
            

            $view = view("admin.report.stok-avalan.pdf-resume", [
                "data3BulanTerakhir" => $data3BulanTerakhir,
                "dataItemTertukar" => $dataItemSelisihTertukar,
                "dataItemKesalahanAdmin" => $dataItemKesalahanAdmin,
                "dataItemSelisih" => $dataItemSelisih,
                "dataCso" => $datadbttrsheda[0],
                "dataAnalisator" => $dataAnalisator,
                "dataPelaku" => $dataPelaku,
                "dataTertukar" => $dataTertukar,
                "dataSelisih" => $dataSelisih,
                "dataRekapitulasi" => $dataRekapitulasi[0],
            ]);
        } else {
            $dataDbtTrsHed = DB::table('dbttrsheda')->where('trsid', '=', $request->trsidlaporan)->get();
            $dataLaporan = DB::select('CALL GetDataLaporanAvalan(?)', [$request->trsidlaporan]);
            $dataWrh = DB::table('dbttrsdeta')
            ->join('dbttrsdet2a','dbttrsdeta.trsdetid','=','dbttrsdet2a.trsdetid')
            ->where('dbttrsdeta.trsid','=',$request->trsidlaporan)
            ->select('dbttrsdet2a.wrh')
            ->groupBy('dbttrsdet2a.wrh')
            ->get();
            $view = view("admin.report.stok-item.pdf-laporan-cso", [
                "dataCso" => $dataDbtTrsHed[0],
                "dataWrh"=>$dataWrh,
                "dataLaporan"=>$dataLaporan
            ]);
        }
        $pdf->loadHTML($view)->setPaper('a4', 'landscape')->add_info('Title', 'Your meta title');;
        return $pdf->stream();
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
