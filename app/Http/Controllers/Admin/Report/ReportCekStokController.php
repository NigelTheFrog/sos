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
        $getDbtTrsHed = DB::table('dbttrshed')->whereNot('statusdoc', '=', 'A')->get();
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
        if ($request->type == 1 || $request->type == 2) {

            $dataDbtTrsHed = DB::table('dbttrshed')->where('trsid', '=', $request->trsidresume)->get();

            $dataAnalisator = SusunanCso::where('trsid', '=', $request->trsidresume)->where('joBtypeid', '=', '2')->where('tipecso', '=', 'R')->get();

            $dataPelaku = SusunanCso::where('trsid', '=', $request->trsidresume)->where('joBtypeid', '=', '1')->where('tipecso', '=', 'R')->get();

            $dataRekapitulasi = DB::select('CALL RekapitulasiHasilCso(?)', [$request->trsidresume]);

            $dataItemKesalahanAdmin = DB::table('dbttrsdet')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdet.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->leftJoin('dbmkeputusan', 'dbttrsdet.keputusan', '=', 'dbmkeputusan.keputusanid')
                ->select(
                    'dbttrsdet.itemname',
                    'dbttrsdet.batchno',
                    'dbttrsdet.keputusan',
                    'dbmkeputusan.keputusandesc',
                    'dbttrsdet.onhand',
                    'dbttrsdet.nodoc',
                    DB::raw('dbttrsdet.cogs as hpp'),
                    DB::raw('dbttrsdet.cogs_manual as hpp_manual'),
                    'dbttrsdet.keterangan',
                    DB::raw('coalesce(dbttrsdet.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdet.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdet.deviasi,0) as deviasi')
                )
                ->where('dbttrsdet.trsid', '=', $request->trsidresume)
                ->whereRaw('coalesce(dbttrsdet.kesalahan_admin,0) = 1')
                ->where('dbtcsodet2.csocount', '=', function ($query) {
                    $query->from('dbtcsodet')
                        ->join('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                        ->whereColumn('dbtcsodet.itembatchid', 'dbttrsdet.itembatchid')
                        ->selectRaw('max(dbtcsodet2.csocount)');
                })
                ->groupBy('dbttrsdet.trsdetid')
                ->havingRaw("dbttrsdet.onhand = (SUM(COALESCE(dbtcsodet2.qty, 0)) + koreksi + deviasi)")
                ->get();

            $dataItemSelisihTertukar = DB::table('dbttrsdet')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdet.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->leftJoin('dbmkeputusan', 'dbttrsdet.keputusan', '=', 'dbmkeputusan.keputusanid')
                ->select(
                    'dbttrsdet.itemname',
                    'dbttrsdet.batchno',
                    'dbttrsdet.keputusan',
                    'dbmkeputusan.keputusandesc',
                    'dbttrsdet.onhand',
                    'dbttrsdet.nodoc',
                    DB::raw('dbttrsdet.cogs as hpp'),
                    DB::raw('dbttrsdet.cogs_manual as hpp_manual'),
                    'dbttrsdet.keterangan',
                    DB::raw('coalesce(dbttrsdet.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdet.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdet.deviasi,0) as deviasi')
                )
                ->where('dbttrsdet.trsid', '=', $request->trsidresume)
                ->whereRaw('not (coalesce(dbttrsdet.groupid,0) = 0)')
                ->whereRaw('coalesce(dbttrsdet.kesalahan_admin,0) = 0')
                ->where('dbtcsodet2.csocount', '=', function ($query) {
                    $query->from('dbtcsodet')
                        ->join('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                        ->whereColumn('dbtcsodet.itembatchid', 'dbttrsdet.itembatchid')
                        ->selectRaw('max(dbtcsodet2.csocount)');
                })
                ->groupBy('dbttrsdet.trsdetid')
                ->havingRaw("dbttrsdet.onhand = (SUM(COALESCE(dbtcsodet2.qty, 0)) + koreksi + deviasi)")
                ->get();

            $dataItemSelisih = DB::table('dbttrsdet')
                ->leftJoin('dbtcsodet', function ($join) {
                    $join->on('dbtcsodet.itembatchid', '=', 'dbttrsdet.itembatchid');
                })
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->leftJoin('dbmkeputusan', 'dbttrsdet.keputusan', '=', 'dbmkeputusan.keputusanid')
                ->select(
                    'dbttrsdet.itemid',
                    'dbttrsdet.itemname',
                    'dbttrsdet.itembatchid',
                    'dbttrsdet.batchno',
                    'dbttrsdet.keputusan',
                    'dbmkeputusan.keputusandesc',
                    'dbttrsdet.onhand',
                    'dbttrsdet.nodoc',
                    DB::raw('dbttrsdet.cogs as hpp'),
                    DB::raw('dbttrsdet.cogs_manual as hpp_manual'),
                    'dbttrsdet.keterangan',
                    DB::raw('coalesce(dbttrsdet.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdet.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdet.deviasi,0) as deviasi')
                )
                ->where('dbttrsdet.trsid', '=', $request->trsidresume)
                ->whereRaw('coalesce(dbttrsdet.groupid,0) = 0')
                ->whereRaw('coalesce(dbttrsdet.kesalahan_admin,0) = 0')
                ->where('dbtcsodet2.csocount', '=', function ($query) {
                    $query->from('dbtcsodet')
                        ->join('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                        ->whereColumn('dbtcsodet.itembatchid', 'dbttrsdet.itembatchid')
                        ->selectRaw('max(dbtcsodet2.csocount)');
                })
                ->groupBy('dbttrsdet.trsdetid')
                ->havingRaw("NOT dbttrsdet.onhand = (SUM(COALESCE(dbtcsodet2.qty, 0)) + koreksi + deviasi)")
                ->get();

            $endOfDatePreviousMonth = Carbon::parse($dataDbtTrsHed[0]->startcsodate)
                ->copy()
                ->subMonth()
                ->endOfMonth()
                ->toDateString();

            $startDatePreviou3sMonth = Carbon::parse($dataDbtTrsHed[0]->startcsodate)
                ->copy()
                ->subMonths(3)
                ->startOfMonth()
                ->toDateString();

            $item_ok = DB::table('dbttrshed')
                ->join('dbttrsdet', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdet.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(DB::raw("dbttrshed.trsid as trsid, COUNT(distinct dbttrsdet.trsdetid) as count, DATE_FORMAT(dbttrshed.startcsodate, '%m') as monthstart, dbttrshed.csomaterial"))
                ->where('dbttrshed.statusdoc', 'P')
                ->whereRaw('(coalesce(dbttrsdet.koreksi, 0) + coalesce(dbttrsdet.deviasi, 0) + coalesce(dbtcsodet2.qty, 0)) = dbttrsdet.onhand')
                ->whereBetween('dbttrshed.startcsodate', [$startDatePreviou3sMonth, $endOfDatePreviousMonth])
                ->orderBy('dbttrshed.startcsodate')
                ->groupBy('dbttrshed.trsid');

            $item_ada = DB::table('dbttrshed')
                ->join('dbttrsdet', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdet.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(DB::raw("dbttrshed.trsid as trsid, COUNT(distinct dbttrsdet.trsdetid) as count, DATE_FORMAT(dbttrshed.startcsodate, '%m') as monthstart, dbttrshed.csomaterial"))
                ->where('dbttrshed.statusdoc', 'P')
                ->whereRaw('coalesce(dbtcsodet2.qty, 0) > 0')
                ->whereBetween('dbttrshed.startcsodate', [$startDatePreviou3sMonth, $endOfDatePreviousMonth])
                ->orderBy('dbttrshed.startcsodate')
                ->groupBy('dbttrshed.trsid');


            $data3BulanTerakhir = DB::query()
                ->fromSub($item_ok, 'item_ok')
                ->joinSub($item_ada, 'item_ada', function ($join) {
                    $join->on('item_ok.trsid', '=', 'item_ada.trsid');
                })
                ->select('item_ok.monthstart', 'item_ok.csomaterial', 'item_ok.count as item_ok', 'item_ada.count as item_ada')
                ->get();
            
            if($request->orientation == 1) {
                $view = view("admin.report.stok-item.pdf-resume-potrait", [
                    "data3BulanTerakhir" => $data3BulanTerakhir,
                    "dataItemTertukar" => $dataItemSelisihTertukar,
                    "dataItemKesalahanAdmin" => $dataItemKesalahanAdmin,
                    "dataItemSelisih" => $dataItemSelisih,
                    "dataCso" => $dataDbtTrsHed[0],
                    "dataAnalisator" => $dataAnalisator,
                    "dataPelaku" => $dataPelaku,
                    "dataRekapitulasi" => $dataRekapitulasi[0],
                    "type" => $request->type
                ]);
                $pdf->loadHTML($view)->setPaper('a4');
            } else {
                $view = view("admin.report.stok-item.pdf-resume", [
                    "data3BulanTerakhir" => $data3BulanTerakhir,
                    "dataItemTertukar" => $dataItemSelisihTertukar,
                    "dataItemKesalahanAdmin" => $dataItemKesalahanAdmin,
                    "dataItemSelisih" => $dataItemSelisih,
                    "dataCso" => $dataDbtTrsHed[0],
                    "dataAnalisator" => $dataAnalisator,
                    "dataPelaku" => $dataPelaku,
                    "dataRekapitulasi" => $dataRekapitulasi[0],
                    "type" => $request->type
                ]);
                $pdf->loadHTML($view)->setPaper('a4', 'landscape');
            } 
            
        } else {
            $dataDbtTrsHed = DB::table('dbttrshed')->where('trsid', '=', $request->trsidlaporan)->get();
            $dataLaporan = DB::select('CALL GetDataLaporan(?)', [$request->trsidlaporan]);
            $dataWrh = DB::table('dbttrsdet')
                ->join('dbttrsdet2', 'dbttrsdet.trsdetid', '=', 'dbttrsdet2.trsdetid')
                ->where('dbttrsdet.trsid', '=', $request->trsidlaporan)
                ->select('dbttrsdet2.wrh')
                ->groupBy('dbttrsdet2.wrh')
                ->get();
            $dataWrhQty = DB::table('dbttrsdet')
                ->join('dbttrsdet2', 'dbttrsdet.trsdetid', '=', 'dbttrsdet2.trsdetid')
                ->where('dbttrsdet.trsid', '=', $request->trsidlaporan)
                ->select('dbttrsdet2.wrh','dbttrsdet2.trsdetid', 'dbttrsdet2.qty')
                ->get();
            $view = view("admin.report.stok-item.pdf-laporan-cso", [
                "dataCso" => $dataDbtTrsHed[0],
                "dataWrh" => $dataWrh,
                "dataLaporan" => $dataLaporan,
                "dataWrhQty" => $dataWrhQty
            ]);
            $pdf->loadHTML($view)->setPaper('a4', 'landscape');
        }        
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
    public function update(Request $request)
    {
        Carbon::setLocale('id');
        if ($request->type == 1) {

            $dataDbtTrsHed = DB::table('dbttrshed')->where('trsid', '=', $request->trsidresume)->get();

            $dataAnalisator = SusunanCso::where('trsid', '=', $request->trsidresume)->where('joBtypeid', '=', '2')->where('tipecso', '=', 'R')->get();

            $dataPelaku = SusunanCso::where('trsid', '=', $request->trsidresume)->where('joBtypeid', '=', '1')->where('tipecso', '=', 'R')->get();

            $dataRekapitulasi = DB::select('CALL RekapitulasiHasilCso(?)', [$request->trsidresume]);

            $dataItemKesalahanAdmin = DB::table('dbttrsdet')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdet.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->leftJoin('dbmkeputusan', 'dbttrsdet.keputusan', '=', 'dbmkeputusan.keputusanid')
                ->select(
                    'dbttrsdet.itemname',
                    'dbttrsdet.batchno',
                    'dbttrsdet.keputusan',
                    'dbmkeputusan.keputusandesc',
                    'dbttrsdet.onhand',
                    'dbttrsdet.nodoc',
                    DB::raw('dbttrsdet.cogs as hpp'),
                    DB::raw('dbttrsdet.cogs_manual as hpp_manual'),
                    'dbttrsdet.keterangan',
                    DB::raw('coalesce(dbttrsdet.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdet.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdet.deviasi,0) as deviasi')
                )
                ->where('dbttrsdet.trsid', '=', $request->trsidresume)
                ->whereRaw('coalesce(dbttrsdet.kesalahan_admin,0) = 1')
                ->where('dbtcsodet2.csocount', '=', function ($query) {
                    $query->from('dbtcsodet')
                        ->join('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                        ->whereColumn('dbtcsodet.itembatchid', 'dbttrsdet.itembatchid')
                        ->selectRaw('max(dbtcsodet2.csocount)');
                })
                ->groupBy('dbttrsdet.trsdetid')
                ->havingRaw("dbttrsdet.onhand = (SUM(COALESCE(dbtcsodet2.qty, 0)) + koreksi + deviasi)")
                ->get();

            $dataItemSelisihTertukar = DB::table('dbttrsdet')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdet.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->leftJoin('dbmkeputusan', 'dbttrsdet.keputusan', '=', 'dbmkeputusan.keputusanid')
                ->select(
                    'dbttrsdet.itemname',
                    'dbttrsdet.batchno',
                    'dbttrsdet.keputusan',
                    'dbmkeputusan.keputusandesc',
                    'dbttrsdet.onhand',
                    'dbttrsdet.nodoc',
                    DB::raw('dbttrsdet.cogs as hpp'),
                    DB::raw('dbttrsdet.cogs_manual as hpp_manual'),
                    'dbttrsdet.keterangan',
                    DB::raw('coalesce(dbttrsdet.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdet.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdet.deviasi,0) as deviasi')
                )
                ->where('dbttrsdet.trsid', '=', $request->trsidresume)
                ->whereRaw('not (coalesce(dbttrsdet.groupid,0) = 0)')
                ->whereRaw('coalesce(dbttrsdet.kesalahan_admin,0) = 0')
                ->where('dbtcsodet2.csocount', '=', function ($query) {
                    $query->from('dbtcsodet')
                        ->join('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                        ->whereColumn('dbtcsodet.itembatchid', 'dbttrsdet.itembatchid')
                        ->selectRaw('max(dbtcsodet2.csocount)');
                })
                ->groupBy('dbttrsdet.trsdetid')
                ->havingRaw("dbttrsdet.onhand = (SUM(COALESCE(dbtcsodet2.qty, 0)) + koreksi + deviasi)")
                ->get();

            $dataItemSelisih = DB::table('dbttrsdet')
                ->leftJoin('dbtcsodet', function ($join) {
                    $join->on('dbtcsodet.itembatchid', '=', 'dbttrsdet.itembatchid');
                })
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->leftJoin('dbmkeputusan', 'dbttrsdet.keputusan', '=', 'dbmkeputusan.keputusanid')
                ->select(
                    'dbttrsdet.itemid',
                    'dbttrsdet.itemname',
                    'dbttrsdet.itembatchid',
                    'dbttrsdet.batchno',
                    'dbttrsdet.keputusan',
                    'dbmkeputusan.keputusandesc',
                    'dbttrsdet.onhand',
                    'dbttrsdet.nodoc',
                    DB::raw('dbttrsdet.cogs as hpp'),
                    DB::raw('dbttrsdet.cogs_manual as hpp_manual'),
                    'dbttrsdet.keterangan',
                    DB::raw('coalesce(dbttrsdet.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdet.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdet.deviasi,0) as deviasi')
                )
                ->where('dbttrsdet.trsid', '=', $request->trsidresume)
                ->whereRaw('coalesce(dbttrsdet.groupid,0) = 0')
                ->whereRaw('coalesce(dbttrsdet.kesalahan_admin,0) = 0')
                ->where('dbtcsodet2.csocount', '=', function ($query) {
                    $query->from('dbtcsodet')
                        ->join('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                        ->whereColumn('dbtcsodet.itembatchid', 'dbttrsdet.itembatchid')
                        ->selectRaw('max(dbtcsodet2.csocount)');
                })
                ->groupBy('dbttrsdet.trsdetid')
                ->havingRaw("NOT dbttrsdet.onhand = (SUM(COALESCE(dbtcsodet2.qty, 0)) + koreksi + deviasi)")
                ->get();

            $endOfDatePreviousMonth = Carbon::parse($dataDbtTrsHed[0]->startcsodate)
                ->copy()
                ->subMonth()
                ->endOfMonth()
                ->toDateString();

            $startDatePreviou3sMonth = Carbon::parse($dataDbtTrsHed[0]->startcsodate)
                ->copy()
                ->subMonths(3)
                ->startOfMonth()
                ->toDateString();

            $item_ok = DB::table('dbttrshed')
                ->join('dbttrsdet', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdet.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(DB::raw("dbttrshed.trsid as trsid, COUNT(distinct dbttrsdet.trsdetid) as count, DATE_FORMAT(dbttrshed.startcsodate, '%m') as monthstart, dbttrshed.csomaterial"))
                ->where('dbttrshed.statusdoc', 'P')
                ->whereRaw('(coalesce(dbttrsdet.koreksi, 0) + coalesce(dbttrsdet.deviasi, 0) + coalesce(dbtcsodet2.qty, 0)) = dbttrsdet.onhand')
                ->whereBetween('dbttrshed.startcsodate', [$startDatePreviou3sMonth, $endOfDatePreviousMonth])
                ->orderBy('dbttrshed.startcsodate')
                ->groupBy('dbttrshed.trsid');

            $item_ada = DB::table('dbttrshed')
                ->join('dbttrsdet', 'dbttrshed.trsid', '=', 'dbttrsdet.trsid')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdet.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(DB::raw("dbttrshed.trsid as trsid, COUNT(distinct dbttrsdet.trsdetid) as count, DATE_FORMAT(dbttrshed.startcsodate, '%m') as monthstart, dbttrshed.csomaterial"))
                ->where('dbttrshed.statusdoc', 'P')
                ->whereRaw('coalesce(dbtcsodet2.qty, 0) > 0')
                ->whereBetween('dbttrshed.startcsodate', [$startDatePreviou3sMonth, $endOfDatePreviousMonth])
                ->orderBy('dbttrshed.startcsodate')
                ->groupBy('dbttrshed.trsid');


            $data3BulanTerakhir = DB::query()
                ->fromSub($item_ok, 'item_ok')
                ->joinSub($item_ada, 'item_ada', function ($join) {
                    $join->on('item_ok.trsid', '=', 'item_ada.trsid');
                })
                ->select('item_ok.monthstart', 'item_ok.csomaterial', 'item_ok.count as item_ok', 'item_ada.count as item_ada')
                ->get();

            $view = view("admin.report.preview-item.preview-resume", [
                "title" => "Preview Resume",
                "trsidresume" => $request->trsidresume,
                "data3BulanTerakhir" => $data3BulanTerakhir,
                "dataItemTertukar" => $dataItemSelisihTertukar,
                "dataItemKesalahanAdmin" => $dataItemKesalahanAdmin,
                "dataItemSelisih" => $dataItemSelisih,
                "dataCso" => $dataDbtTrsHed[0],
                "dataAnalisator" => $dataAnalisator,
                "dataPelaku" => $dataPelaku,
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
            
            $dataWrhQty = DB::table('dbttrsdet')
            ->join('dbttrsdet2', 'dbttrsdet.trsdetid', '=', 'dbttrsdet2.trsdetid')
            ->where('dbttrsdet.trsid', '=', $request->trsidlaporan)
            ->select('dbttrsdet2.wrh','dbttrsdet2.trsdetid', 'dbttrsdet2.qty')
            ->get();

            $view = view("admin.report.preview-item.preview-laporan-cso", [
                "title" => "Preview Laporan",
                "trsidlaporan" => $request->trsidlaporan,
                "dataCso" => $dataDbtTrsHed[0],
                "dataWrh" => $dataWrh,
                "dataWrhQty" => $dataWrhQty,
                "dataLaporan" => $dataLaporan,
            ]);
        }
        return $view;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
