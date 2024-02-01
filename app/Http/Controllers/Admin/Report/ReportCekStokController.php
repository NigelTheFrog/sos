<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;


class ReportCekStokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getDbtTrsHed = DB::table('dbttrshed')->where('statusdoc', '=', 'P')->get();
        // dd($getDbtTrsHed);
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
        $pdf = App::make('dompdf.wrapper');
        if ($request->type == 1) {
            $dataDbtTrsHed = DB::table('dbttrshed')->where('trsid', '=', $request->trsidresume)->get();

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

            // $data3BulanTerakhir = DB::table('dbttrshed')
            //     ->select(DB::raw("DATE_FORMAT(dbttrshed.startcsodate, '%m') as monthstart"), 'dbttrshed.csomaterial')
            //     ->whereRaw('dbttrshed.startcsodate >= DATE_SUB(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), INTERVAL 3 MONTH)')
            //     ->whereRaw('dbttrshed.startcsodate < DATE_SUB(CURDATE(), INTERVAL 1 MONTH)')
            //     ->groupBy('monthstart', 'dbttrshed.csomaterial')
            //     ->get();

            $data3BulanTerakhir = DB::select("
            SELECT 
                item_ok.monthstart,
                item_ok.csomaterial,
                item_ok.count as 'item_ok',
                item_ada.count as 'item_ada'
            FROM
                (SELECT 
                    COUNT(distinct dbttrsdet.trsdetid) as 'count',
                    DATE_FORMAT(dbttrshed.startcsodate, '%m') as 'monthstart',
                    dbttrshed.csomaterial
                FROM
                    dbttrshed
                INNER JOIN dbttrsdet ON
                    dbttrshed.trsid = dbttrsdet.trsid
                LEFT JOIN dbtcsodet ON
                    dbtcsodet.itemid = dbttrsdet.itemid
                LEFT JOIN dbtcsodet2 ON
                    dbtcsodet2.csodetid = dbtcsodet.csodetid
                WHERE
                    dbttrshed.statusdoc = 'P'
                    AND (coalesce(dbttrsdet.koreksi, 0) + coalesce(dbttrsdet.deviasi, 0) + coalesce(dbtcsodet2.qty, 0)) = dbttrsdet.onhand
                    AND dbttrshed.startcsodate >= DATE_SUB(DATE_SUB(CURDATE(), interval 1 month), interval 3 month)
                    AND dbttrshed.startcsodate < DATE_SUB(CURDATE(), interval 1 month)      
                GROUP BY monthstart, dbttrshed.csomaterial) as item_ok
            JOIN
                (SELECT 
                    COUNT(distinct dbttrsdet.trsdetid) as 'count',
                    DATE_FORMAT(dbttrshed.startcsodate, '%m') as 'monthstart',
                    dbttrshed.csomaterial
                FROM
                    dbttrshed
                INNER JOIN dbttrsdet ON
                    dbttrshed.trsid = dbttrsdet.trsid
                LEFT JOIN dbtcsodet ON
                    dbtcsodet.itemid = dbttrsdet.itemid
                LEFT JOIN dbtcsodet2 ON
                    dbtcsodet2.csodetid = dbtcsodet.csodetid
                WHERE
                    dbttrshed.statusdoc = 'P'
                    AND coalesce(dbtcsodet2.qty, 0) > 0
                    AND dbttrshed.startcsodate >= DATE_SUB(DATE_SUB(CURDATE(), interval 1 month), interval 3 month)
                    AND dbttrshed.startcsodate < DATE_SUB(CURDATE(), interval 1 month)      
                GROUP BY monthstart, dbttrshed.csomaterial) as item_ada
            ON
                item_ok.monthstart = item_ada.monthstart
                AND item_ok.csomaterial = item_ada.csomaterial;            
            ");

            $view = view("admin.report.pdf-resume", [
                "data3BulanTerakhir" => $data3BulanTerakhir,
                "dataItemTertukar" => $dataItemSelisihTertukar,
                "dataItemKesalahanAdmin" => $dataItemKesalahanAdmin,
                "dataItemSelisih" => $dataItemSelisih,
                "dataCso" => $dataDbtTrsHed[0],
                "dataAnalisator" => $dataAnalisator,
                "dataPelaku" => $dataPelaku,
                "dataTertukar" => $dataTertukar,
                "dataSelisih" => $dataSelisih,
                "dataRekapitulasi" => $dataRekapitulasi[0],
            ]);
        }
        $pdf->loadHTML($view)->setPaper('a4', 'landscape');
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
