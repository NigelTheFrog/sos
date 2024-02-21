<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Admin\Resume\SusunanCso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;

class ReportCekStokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getDbtTrsHed = DB::table('dbttrshed')->where('statusdoc', '=', 'P')->get();
        return view('admin.report.cek-stok', ['listNodoc' => $getDbtTrsHed]);
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
            
            $dataDbtTrsHed = DB::table('dbttrshed')->where('trsid', '=', $request->trsidresume)->get();

            $dataAnalisator = SusunanCso::where('trsid', '=', $request->trsidresume)->where('joBtypeid', '=', '2')->where('tipecso', '=', 'R')->get();

            $dataPelaku = SusunanCso::where('trsid', '=', $request->trsidresume)->where('joBtypeid', '=', '1')->where('tipecso', '=', 'R')->get();

            $dataRekapitulasi = DB::select('CALL RekapitulasiHasilCso(?)', [$request->trsidresume]);

            $dataItemKesalahanAdmin = DB::table('dbttrsdet')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdet.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(
                    'dbttrsdet.itemname',
                    'dbttrsdet.batchno',
                    'dbttrsdet.keputusan',
                    'dbttrsdet.onhand',
                    'dbttrsdet.nodoc',
                    DB::raw('dbttrsdet.cogs as hpp'),
                    'dbttrsdet.keterangan',
                    DB::raw('coalesce(dbttrsdet.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdet.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdet.deviasi,0) as deviasi')
                )
                ->where('dbttrsdet.trsid', '=', $request->trsidresume)
                ->whereRaw('coalesce(dbttrsdet.kesalahan_admin,0) = 1')
                ->groupBy('dbttrsdet.trsdetid')
                ->get();

            $dataItemSelisihTertukar = DB::table('dbttrsdet')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdet.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(
                    'dbttrsdet.itemname',
                    'dbttrsdet.batchno',
                    'dbttrsdet.keputusan',
                    'dbttrsdet.onhand',
                    'dbttrsdet.nodoc',
                    DB::raw('dbttrsdet.cogs as hpp'),
                    'dbttrsdet.keterangan',
                    DB::raw('coalesce(dbttrsdet.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdet.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdet.deviasi,0) as deviasi')
                )
                ->where('dbttrsdet.trsid', '=', $request->trsidresume)
                ->whereRaw('not (coalesce(dbttrsdet.groupid,0) = 0)')
                ->whereRaw('coalesce(dbttrsdet.kesalahan_admin,0) = 0')
                ->groupBy('dbttrsdet.trsdetid')
                ->get();

            $dataItemSelisih = DB::table('dbttrsdet')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdet.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(
                    'dbttrsdet.itemname',
                    'dbttrsdet.batchno',
                    'dbttrsdet.keputusan',
                    'dbttrsdet.onhand',
                    'dbttrsdet.nodoc',
                    DB::raw('dbttrsdet.cogs as hpp'),
                    'dbttrsdet.keterangan',
                    DB::raw('coalesce(dbttrsdet.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdet.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdet.deviasi,0) as deviasi')
                )
                ->where('dbttrsdet.trsid', '=', $request->trsidresume)
                ->whereRaw('coalesce(dbttrsdet.groupid,0) = 0')
                ->whereRaw('coalesce(dbttrsdet.kesalahan_admin,0) = 0')
                ->groupBy('dbttrsdet.trsdetid')
                ->get();

            $item_ok = DB::table('dbttrshed')
                ->join('dbttrsdet', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdet.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(DB::raw("COUNT(distinct dbttrsdet.trsdetid) as count, DATE_FORMAT(dbttrshed.startcsodate, '%m') as monthstart, dbttrshed.csomaterial"))
                ->where('dbttrshed.statusdoc', 'P')
                ->whereRaw('(coalesce(dbttrsdet.koreksi, 0) + coalesce(dbttrsdet.deviasi, 0) + coalesce(dbtcsodet2.qty, 0)) = dbttrsdet.onhand')
                ->whereRaw("dbttrshed.startcsodate >= DATE_SUB(DATE_SUB('".$dataDbtTrsHed[0]->startcsodate."', interval 1 month), interval 3 month)")
                ->whereRaw("dbttrshed.startcsodate < DATE_SUB('".$dataDbtTrsHed[0]->startcsodate."', interval 1 month)")
                // ->setBindings([$dataDbtTrsHed[0]->startcsodate, $dataDbtTrsHed[0]->startcsodate]) 
                ->groupBy('monthstart', 'dbttrshed.csomaterial');

            $item_ada = DB::table('dbttrshed')
                ->join('dbttrsdet', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdet.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(DB::raw("COUNT(distinct dbttrsdet.trsdetid) as count, DATE_FORMAT(dbttrshed.startcsodate, '%m') as monthstart, dbttrshed.csomaterial"))
                ->where('dbttrshed.statusdoc', 'P')
                ->whereRaw('coalesce(dbtcsodet2.qty, 0) > 0')
                ->whereRaw("dbttrshed.startcsodate >= DATE_SUB(DATE_SUB('".$dataDbtTrsHed[0]->startcsodate."', interval 1 month), interval 3 month)")
                ->whereRaw("dbttrshed.startcsodate < DATE_SUB('".$dataDbtTrsHed[0]->startcsodate."', interval 1 month)")
                // ->setBindings([$dataDbtTrsHed[0]->startcsodate, $dataDbtTrsHed[0]->startcsodate]) 
                ->groupBy('monthstart', 'dbttrshed.csomaterial');

            $data3BulanTerakhir = DB::query()
                ->fromSub($item_ok, 'item_ok')
                ->joinSub($item_ada, 'item_ada', function ($join) {
                    $join->on('item_ok.monthstart', '=', 'item_ada.monthstart');
                    $join->on('item_ok.csomaterial', '=', 'item_ada.csomaterial');
                })
                ->select('item_ok.monthstart', 'item_ok.csomaterial', 'item_ok.count as item_ok', 'item_ada.count as item_ada')
                ->get();

            $view = view("admin.report.stok-item.pdf-resume", [
                "data3BulanTerakhir" => $data3BulanTerakhir,
                "dataItemTertukar" => $dataItemSelisihTertukar,
                "dataItemKesalahanAdmin" => $dataItemKesalahanAdmin,
                "dataItemSelisih" => $dataItemSelisih,
                "dataCso" => $dataDbtTrsHed[0],
                "dataAnalisator" => $dataAnalisator,
                "dataPelaku" => $dataPelaku,
                // "dataTertukar" => $dataTertukar,
                // "dataSelisih" => $dataSelisih,
                "dataRekapitulasi" => $dataRekapitulasi[0],
            ]);
        } else {
            $dataDbtTrsHed = DB::table('dbttrshed')->where('trsid', '=', $request->trsidlaporan)->get();
            $dataLaporan = DB::select('CALL GetDataLaporan(?)', [$request->trsidlaporan]);
            $dataWrh = DB::table('dbttrsdet')
                ->join('dbttrsdet2', 'dbttrsdet.trsdetid', '=', 'dbttrsdet2.trsdetid')
                ->where('dbttrsdet.trsid', '=', $request->trsidlaporan)
                ->select('dbttrsdet2.wrh')
                ->groupBy('dbttrsdet2.wrh')
                ->get();
            $view = view("admin.report.stok-item.pdf-laporan-cso", [
                "dataCso" => $dataDbtTrsHed[0],
                "dataWrh" => $dataWrh,
                "dataLaporan" => $dataLaporan
            ]);
        }
        $pdf->loadHTML($view)->setPaper('a4', 'landscape')->add_info('Title', 'Your meta title');
        return $pdf->stream();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
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
