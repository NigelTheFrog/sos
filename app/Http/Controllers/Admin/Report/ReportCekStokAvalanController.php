<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Admin\Resume\SusunanCso;
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
        $getdbttrsheda = DB::table('dbttrsheda')->whereNot('statusdoc', '=', 'A')->get();
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
        if ($request->type == 1 || $request->type == 2) {
            $datadbttrsheda = DB::table('dbttrsheda')->where('trsid', '=', $request->trsidresume)->get();

            $dataAnalisator = SusunanCso::where('trsid', '=', $request->trsidresume)->where('joBtypeid', '=', '2')->where('tipecso', '=', 'A')->get();

            $dataPelaku = SusunanCso::where('trsid', '=', $request->trsidresume)->where('joBtypeid', '=', '1')->where('tipecso', '=', 'A')->get();

            $dataRekapitulasi = DB::select('CALL RekapitulasiHasilCsoAvalan(?)', [$request->trsidresume]);

            $dataItemKesalahanAdmin = DB::table('dbttrsdeta')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdeta.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->leftJoin('dbmkeputusan', 'dbttrsdeta.keputusan', '=', 'dbmkeputusan.keputusanid')
                ->select(
                    'dbttrsdeta.itemname',
                    'dbttrsdeta.batchno',
                    'dbttrsdeta.keputusan',
                    'dbmkeputusan.keputusandesc',
                    'dbttrsdeta.onhand',
                    'dbttrsdeta.nodoc',
                    DB::raw('dbttrsdeta.cogs as hpp'),
                    DB::raw('dbttrsdeta.cogs_manual as hpp_manual'),
                    'dbttrsdeta.keterangan',
                    DB::raw('coalesce(dbttrsdeta.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdeta.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdeta.deviasi,0) as deviasi')
                )
                ->where('dbttrsdeta.trsid', '=', $request->trsidresume)
                ->whereRaw('coalesce(dbttrsdeta.kesalahan_admin,0) = 1')
                ->where('dbtcsodet2.csocount', '=', function ($query) {
                    $query->from('dbtcsodet')
                        ->join('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                        ->whereColumn('dbtcsodet.itembatchid', 'dbttrsdeta.itembatchid')
                        ->selectRaw('max(dbtcsodet2.csocount)');
                })
                ->groupBy('dbttrsdeta.trsdetid')
                ->havingRaw("dbttrsdet.onhand = (SUM(COALESCE(dbtcsodet2.qty, 0)) + koreksi + deviasi)")
                ->get();

            $dataItemSelisihTertukar = DB::table('dbttrsdeta')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdeta.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->leftJoin('dbmkeputusan', 'dbttrsdeta.keputusan', '=', 'dbmkeputusan.keputusanid')
                ->select(
                    'dbttrsdeta.itemname',
                    'dbttrsdeta.batchno',
                    'dbttrsdeta.keputusan',
                    'dbmkeputusan.keputusandesc',
                    'dbttrsdeta.onhand',
                    'dbttrsdeta.nodoc',
                    DB::raw('dbttrsdeta.cogs as hpp'),
                    DB::raw('dbttrsdeta.cogs_manual as hpp_manual'),
                    'dbttrsdeta.keterangan',
                    DB::raw('coalesce(dbttrsdeta.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdeta.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdeta.deviasi,0) as deviasi')
                )
                ->where('dbttrsdeta.trsid', '=', $request->trsidresume)
                ->whereRaw('not (coalesce(dbttrsdeta.groupid,0) = 0)')
                ->whereRaw('coalesce(dbttrsdeta.kesalahan_admin,0) = 0')
                ->where('dbtcsodet2.csocount', '=', function ($query) {
                    $query->from('dbtcsodet')
                        ->join('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                        ->whereColumn('dbtcsodet.itembatchid', 'dbttrsdeta.itembatchid')
                        ->selectRaw('max(dbtcsodet2.csocount)');
                })
                ->groupBy('dbttrsdeta.trsdetid')
                ->havingRaw("dbttrsdet.onhand = (SUM(COALESCE(dbtcsodet2.qty, 0)) + koreksi + deviasi)")
                ->get();

            $dataItemSelisih = DB::table('dbttrsdeta')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdeta.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->leftJoin('dbmkeputusan', 'dbttrsdeta.keputusan', '=', 'dbmkeputusan.keputusanid')
                ->select(
                    'dbttrsdeta.itemname',
                    'dbttrsdeta.batchno',
                    'dbttrsdeta.keputusan',
                    'dbmkeputusan.keputusandesc',
                    'dbttrsdeta.onhand',
                    'dbttrsdeta.nodoc',
                    DB::raw('dbttrsdeta.cogs as hpp'),
                    DB::raw('dbttrsdeta.cogs_manual as hpp_manual'),
                    'dbttrsdeta.keterangan',
                    DB::raw('coalesce(dbttrsdeta.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdeta.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdeta.deviasi,0) as deviasi')
                )
                ->where('dbttrsdeta.trsid', '=', $request->trsidresume)
                ->whereRaw('coalesce(dbttrsdeta.groupid,0) = 0')
                ->whereRaw('coalesce(dbttrsdeta.kesalahan_admin,0) = 0')
                ->where('dbtcsodet2.csocount', '=', function ($query) {
                    $query->from('dbtcsodet')
                        ->join('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                        ->whereColumn('dbtcsodet.itembatchid', 'dbttrsdeta.itembatchid')
                        ->selectRaw('max(dbtcsodet2.csocount)');
                })
                ->groupBy('dbttrsdeta.trsdetid')
                ->havingRaw("NOT dbttrsdet.onhand = (SUM(COALESCE(dbtcsodet2.qty, 0)) + koreksi + deviasi)")
                ->get();

            $endOfDatePreviousMonth = Carbon::parse($datadbttrsheda[0]->startcsodate)
                ->copy()
                ->subMonth()
                ->endOfMonth()
                ->toDateString();

            $startDatePreviou3sMonth = Carbon::parse($datadbttrsheda[0]->startcsodate)
                ->copy()
                ->subMonths(3)
                ->startOfMonth()
                ->toDateString();

            $item_ok = DB::table('dbttrsheda')
                ->join('dbttrsdeta', 'dbttrsheda.trsid', '=', 'dbttrsdeta.trsid')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdeta.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(DB::raw("dbttrsheda.trsid as trsid, COUNT(distinct dbttrsdeta.trsdetid) as count, DATE_FORMAT(dbttrsheda.startcsodate, '%m') as monthstart, dbttrsheda.csomaterial"))
                ->where('dbttrsheda.statusdoc', 'P')
                ->whereRaw('(coalesce(dbttrsdeta.koreksi, 0) + coalesce(dbttrsdeta.deviasi, 0) + coalesce(dbtcsodet2.qty, 0)) = dbttrsdeta.onhand')
                ->whereBetween('dbttrsheda.startcsodate', [$startDatePreviou3sMonth, $endOfDatePreviousMonth])
                ->orderBy('dbttrsheda.startcsodate')
                ->groupBy('dbttrsheda.trsid');

            $item_ada = DB::table('dbttrsheda')
                ->join('dbttrsdeta', 'dbttrsheda.trsid', '=', 'dbttrsdeta.trsid')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdeta.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(DB::raw("dbttrsheda.trsid as trsid, COUNT(distinct dbttrsdeta.trsdetid) as count, DATE_FORMAT(dbttrsheda.startcsodate, '%m') as monthstart, dbttrsheda.csomaterial"))
                ->where('dbttrsheda.statusdoc', 'P')
                ->whereRaw('coalesce(dbtcsodet2.qty, 0) > 0')
                ->whereBetween('dbttrsheda.startcsodate', [$startDatePreviou3sMonth, $endOfDatePreviousMonth])
                ->orderBy('dbttrsheda.startcsodate')
                ->groupBy('dbttrsheda.trsid');

            $data3BulanTerakhir = DB::query()
                ->fromSub($item_ok, 'item_ok')
                ->joinSub($item_ada, 'item_ada', function ($join) {
                    $join->on('item_ok.trsid', '=', 'item_ada.trsid');
                })
                ->select('item_ok.monthstart', 'item_ok.csomaterial', 'item_ok.count as item_ok', 'item_ada.count as item_ada')
                ->get();

            if ($request->orientation == 1) {
                $view = view("admin.report.stok-avalan.pdf-resume-potrait", [
                    "data3BulanTerakhir" => $data3BulanTerakhir,
                    "dataItemTertukar" => $dataItemSelisihTertukar,
                    "dataItemKesalahanAdmin" => $dataItemKesalahanAdmin,
                    "dataItemSelisih" => $dataItemSelisih,
                    "dataCso" => $datadbttrsheda[0],
                    "dataAnalisator" => $dataAnalisator,
                    "dataPelaku" => $dataPelaku,
                    "dataRekapitulasi" => $dataRekapitulasi[0],
                    "type" => $request->type
                ]);
                $pdf->loadHTML($view)->setPaper('a4');
            } else {
                $view = view("admin.report.stok-avalan.pdf-resume", [
                    "data3BulanTerakhir" => $data3BulanTerakhir,
                    "dataItemTertukar" => $dataItemSelisihTertukar,
                    "dataItemKesalahanAdmin" => $dataItemKesalahanAdmin,
                    "dataItemSelisih" => $dataItemSelisih,
                    "dataCso" => $datadbttrsheda[0],
                    "dataAnalisator" => $dataAnalisator,
                    "dataPelaku" => $dataPelaku,
                    "dataRekapitulasi" => $dataRekapitulasi[0],
                    "type" => $request->type
                ]);
                $pdf->loadHTML($view)->setPaper('a4', 'landscape');
            }
        } else {
            $dataDbtTrsHed = DB::table('dbttrsheda')->where('trsid', '=', $request->trsidlaporan)->get();
            $dataLaporan = DB::select('CALL GetDataLaporanAvalan(?)', [$request->trsidlaporan]);
            $dataWrh = DB::table('dbttrsdeta')
                ->join('dbttrsdet2a', 'dbttrsdeta.trsdetid', '=', 'dbttrsdet2a.trsdetid')
                ->where('dbttrsdeta.trsid', '=', $request->trsidlaporan)
                ->select('dbttrsdet2a.wrh')
                ->groupBy('dbttrsdet2a.wrh')
                ->get();
            $dataWrhQty = DB::table('dbttrsdeta')
                ->join('dbttrsdet2a', 'dbttrsdeta.trsdetid', '=', 'dbttrsdet2a.trsdetid')
                ->where('dbttrsdeta.trsid', '=', $request->trsidlaporan)
                ->select('dbttrsdet2a.wrh', 'dbttrsdet2a.trsdetid', 'dbttrsdet2a.qty')
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
        Carbon::setLocale('id');
        if ($request->type == 1) {
            $datadbttrsheda = DB::table('dbttrsheda')->where('trsid', '=', $request->trsidresume)->get();

            $dataAnalisator = SusunanCso::where('trsid', '=', $request->trsidresume)->where('joBtypeid', '=', '2')->where('tipecso', '=', 'A')->get();

            $dataPelaku = SusunanCso::where('trsid', '=', $request->trsidresume)->where('joBtypeid', '=', '1')->where('tipecso', '=', 'A')->get();

            $dataRekapitulasi = DB::select('CALL RekapitulasiHasilCsoAvalan(?)', [$request->trsidresume]);

            $dataItemKesalahanAdmin = DB::table('dbttrsdeta')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdeta.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->leftJoin('dbmkeputusan', 'dbttrsdeta.keputusan', '=', 'dbmkeputusan.keputusanid')
                ->select(
                    'dbttrsdeta.itemname',
                    'dbttrsdeta.batchno',
                    'dbttrsdeta.keputusan',
                    'dbmkeputusan.keputusandesc',
                    'dbttrsdeta.onhand',
                    'dbttrsdeta.nodoc',
                    DB::raw('dbttrsdeta.cogs as hpp'),
                    DB::raw('dbttrsdeta.cogs_manual as hpp_manual'),
                    'dbttrsdeta.keterangan',
                    DB::raw('coalesce(dbttrsdeta.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdeta.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdeta.deviasi,0) as deviasi')
                )
                ->where('dbttrsdeta.trsid', '=', $request->trsidresume)
                ->whereRaw('coalesce(dbttrsdeta.kesalahan_admin,0) = 1')
                ->where('dbtcsodet2.csocount', '=', function ($query) {
                    $query->from('dbtcsodet')
                        ->join('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                        ->whereColumn('dbtcsodet.itembatchid', 'dbttrsdeta.itembatchid')
                        ->selectRaw('max(dbtcsodet2.csocount)');
                })
                ->groupBy('dbttrsdeta.trsdetid')
                ->havingRaw("dbttrsdet.onhand = (SUM(COALESCE(dbtcsodet2.qty, 0)) + koreksi + deviasi)")
                ->get();

            $dataItemSelisihTertukar = DB::table('dbttrsdeta')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdeta.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->leftJoin('dbmkeputusan', 'dbttrsdeta.keputusan', '=', 'dbmkeputusan.keputusanid')
                ->select(
                    'dbttrsdeta.itemname',
                    'dbttrsdeta.batchno',
                    'dbttrsdeta.keputusan',
                    'dbmkeputusan.keputusandesc',
                    'dbttrsdeta.onhand',
                    'dbttrsdeta.nodoc',
                    DB::raw('dbttrsdeta.cogs as hpp'),
                    DB::raw('dbttrsdeta.cogs_manual as hpp_manual'),
                    'dbttrsdeta.keterangan',
                    DB::raw('coalesce(dbttrsdeta.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdeta.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdeta.deviasi,0) as deviasi')
                )
                ->where('dbttrsdeta.trsid', '=', $request->trsidresume)
                ->whereRaw('not (coalesce(dbttrsdeta.groupid,0) = 0)')
                ->whereRaw('coalesce(dbttrsdeta.kesalahan_admin,0) = 0')
                ->where('dbtcsodet2.csocount', '=', function ($query) {
                    $query->from('dbtcsodet')
                        ->join('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                        ->whereColumn('dbtcsodet.itembatchid', 'dbttrsdeta.itembatchid')
                        ->selectRaw('max(dbtcsodet2.csocount)');
                })
                ->groupBy('dbttrsdeta.trsdetid')
                ->havingRaw("dbttrsdet.onhand = (SUM(COALESCE(dbtcsodet2.qty, 0)) + koreksi + deviasi)")
                ->get();

            $dataItemSelisih = DB::table('dbttrsdeta')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdeta.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->leftJoin('dbmkeputusan', 'dbttrsdeta.keputusan', '=', 'dbmkeputusan.keputusanid')
                ->select(
                    'dbttrsdeta.itemname',
                    'dbttrsdeta.batchno',
                    'dbttrsdeta.keputusan',
                    'dbmkeputusan.keputusandesc',
                    'dbttrsdeta.onhand',
                    'dbttrsdeta.nodoc',
                    DB::raw('dbttrsdeta.cogs as hpp'),
                    DB::raw('dbttrsdeta.cogs_manual as hpp_manual'),
                    'dbttrsdeta.keterangan',
                    DB::raw('coalesce(dbttrsdeta.pembebanan,0) as pembebanan'),
                    DB::raw('sum(coalesce(dbtcsodet2.qty,0)) as hasilcso'),
                    DB::raw('coalesce(dbttrsdeta.koreksi,0) as koreksi'),
                    DB::raw('coalesce(dbttrsdeta.deviasi,0) as deviasi')
                )
                ->where('dbttrsdeta.trsid', '=', $request->trsidresume)
                ->whereRaw('coalesce(dbttrsdeta.groupid,0) = 0')
                ->whereRaw('coalesce(dbttrsdeta.kesalahan_admin,0) = 0')
                ->where('dbtcsodet2.csocount', '=', function ($query) {
                    $query->from('dbtcsodet')
                        ->join('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                        ->whereColumn('dbtcsodet.itembatchid', 'dbttrsdeta.itembatchid')
                        ->selectRaw('max(dbtcsodet2.csocount)');
                })
                ->groupBy('dbttrsdeta.trsdetid')
                ->havingRaw("NOT dbttrsdet.onhand = (SUM(COALESCE(dbtcsodet2.qty, 0)) + koreksi + deviasi)")
                ->get();

            $endOfDatePreviousMonth = Carbon::parse($datadbttrsheda[0]->startcsodate)
                ->copy()
                ->subMonth()
                ->endOfMonth()
                ->toDateString();

            $startDatePreviou3sMonth = Carbon::parse($datadbttrsheda[0]->startcsodate)
                ->copy()
                ->subMonths(3)
                ->startOfMonth()
                ->toDateString();

            $item_ok = DB::table('dbttrsheda')
                ->join('dbttrsdeta', 'dbttrsheda.trsid', '=', 'dbttrsdeta.trsid')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdeta.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(DB::raw("dbttrsheda.trsid as trsid, COUNT(distinct dbttrsdeta.trsdetid) as count, DATE_FORMAT(dbttrsheda.startcsodate, '%m') as monthstart, dbttrsheda.csomaterial"))
                ->where('dbttrsheda.statusdoc', 'P')
                ->whereRaw('(coalesce(dbttrsdeta.koreksi, 0) + coalesce(dbttrsdeta.deviasi, 0) + coalesce(dbtcsodet2.qty, 0)) = dbttrsdeta.onhand')
                ->whereBetween('dbttrsheda.startcsodate', [$startDatePreviou3sMonth, $endOfDatePreviousMonth])
                ->orderBy('dbttrsheda.startcsodate')
                ->groupBy('dbttrsheda.trsid');

            $item_ada = DB::table('dbttrsheda')
                ->join('dbttrsdeta', 'dbttrsheda.trsid', '=', 'dbttrsdeta.trsid')
                ->leftJoin('dbtcsodet', 'dbtcsodet.itemid', '=', 'dbttrsdeta.itemid')
                ->leftJoin('dbtcsodet2', 'dbtcsodet2.csodetid', '=', 'dbtcsodet.csodetid')
                ->select(DB::raw("dbttrsheda.trsid as trsid, COUNT(distinct dbttrsdeta.trsdetid) as count, DATE_FORMAT(dbttrsheda.startcsodate, '%m') as monthstart, dbttrsheda.csomaterial"))
                ->where('dbttrsheda.statusdoc', 'P')
                ->whereRaw('coalesce(dbtcsodet2.qty, 0) > 0')
                ->whereBetween('dbttrsheda.startcsodate', [$startDatePreviou3sMonth, $endOfDatePreviousMonth])
                ->orderBy('dbttrsheda.startcsodate')
                ->groupBy('dbttrsheda.trsid');

            $data3BulanTerakhir = DB::query()
                ->fromSub($item_ok, 'item_ok')
                ->joinSub($item_ada, 'item_ada', function ($join) {
                    $join->on('item_ok.trsid', '=', 'item_ada.trsid');
                })
                ->select('item_ok.monthstart', 'item_ok.csomaterial', 'item_ok.count as item_ok', 'item_ada.count as item_ada')
                ->get();


            $view = view("admin.report.preview-avalan.preview-resume", [
                "title" => "Preview Resume",
                "data3BulanTerakhir" => $data3BulanTerakhir,
                "trsidresume" => $request->trsidresume,
                "dataItemTertukar" => $dataItemSelisihTertukar,
                "dataItemKesalahanAdmin" => $dataItemKesalahanAdmin,
                "dataItemSelisih" => $dataItemSelisih,
                "dataCso" => $datadbttrsheda[0],
                "dataAnalisator" => $dataAnalisator,
                "dataPelaku" => $dataPelaku,
                "dataRekapitulasi" => $dataRekapitulasi[0],
                "type" => $request->type
            ]);
        } else {
            $dataDbtTrsHed = DB::table('dbttrsheda')->where('trsid', '=', $request->trsidlaporan)->get();
            $dataLaporan = DB::select('CALL GetDataLaporanAvalan(?)', [$request->trsidlaporan]);
            $dataWrh = DB::table('dbttrsdeta')
                ->join('dbttrsdet2a', 'dbttrsdeta.trsdetid', '=', 'dbttrsdet2a.trsdetid')
                ->where('dbttrsdeta.trsid', '=', $request->trsidlaporan)
                ->select('dbttrsdet2a.wrh')
                ->groupBy('dbttrsdet2a.wrh')
                ->get();
            $dataWrhQty = DB::table('dbttrsdeta')
                ->join('dbttrsdet2a', 'dbttrsdeta.trsdetid', '=', 'dbttrsdet2a.trsdetid')
                ->where('dbttrsdeta.trsid', '=', $request->trsidlaporan)
                ->select('dbttrsdet2a.wrh', 'dbttrsdet2a.trsdetid', 'dbttrsdet2a.qty')
                ->get();
            $view = view("admin.report.preview-avalan.preview-laporan-cso", [
                "title" => "Preview Laporan",
                "dataCso" => $dataDbtTrsHed[0],
                "trsidlaporan" => $request->trsidlaporan,
                "dataWrh" => $dataWrh,
                "dataWrhQty" => $dataWrhQty,
                "dataLaporan" => $dataLaporan
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
