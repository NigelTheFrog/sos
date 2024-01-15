<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin\Dashboard\Item;
use App\Models\Admin\Master\Group;
use App\Models\ViewDashboard;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use \NumberFormatter;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = ViewDashboard::all();
        $checkCsoActive = DB::table('dbtcsohed')
            ->join('dbttrshed', 'dbttrshed.trsid', '=', 'dbtcsohed.trsid')
            ->where('dbtcsohed.status', '=', 'A')
            ->where('dbttrshed.statusdoc', '=', 'A')
            // ->whereNot('dbttrshed.statusdoc','=','P')
            ->get();

        $checkCsoEnd = DB::table('dbtcsohed')
            ->join('dbttrshed', 'dbttrshed.trsid', '=', 'dbtcsohed.trsid')
            ->where('dbtcsohed.status', '=', 'P')
            ->where('dbttrshed.statusdoc', '=', 'E')
            // ->whereNot('dbttrshed.statusdoc','=','P')
            ->get();

        $checkCsoFinal = DB::table('dbttrshed')->where('statusdoc', '=', 'P')->get();

        $itemBlmProses = ViewDashboard::where('status', '=', '0')->get();
        $itemSdgProses = ViewDashboard::where('status', '!=', '0')->where('status', '!=', '3')->get();
        $itemOk = ViewDashboard::where('status', '=', '3')->get();
        $itemSelisihPlus = ViewDashboard::where('selisih', '>', '0')->get();
        $itemSelisihMinus = ViewDashboard::where('selisih', '<', '0')->get();
        $dbxjob = DB::table('dbxjob')->where('jobtypeid', '=', 2)->get();
        $group = Group::all();
        return view("admin.dashboard.item", [
            'countCsoActive' => count($checkCsoActive), 'countCsoEnd' => count($checkCsoEnd), 'countCsoFinal' => count($checkCsoFinal), 'item' => $item,
            "countItemBlmProses" => count($itemBlmProses), "itemBlmProses" => $itemBlmProses,
            "countItemSdgProses" => count($itemSdgProses), "itemSdgProses" => $itemSdgProses,
            "countItemOk" => count($itemOk), "itemSelesai" => $itemOk,
            "countItemSelisih" => (count($itemSelisihPlus) + count($itemSelisihMinus)), "itemSelisihPlus" => $itemSelisihPlus, "itemSelisihMinus" => $itemSelisihMinus,
            "dbxjob" => $dbxjob, "dbmgroup" => $group
        ]);
    }

    public function showBanner()
    {
        $itemBlmProses = ViewDashboard::where('status', '=', '0')->get();
        $itemSdgProses = ViewDashboard::where('status', '!=', '0')->where('status', '!=', '3')->get();
        $itemOk = ViewDashboard::where('status', '=', '3')->get();
        $itemSelisih = ViewDashboard::where('selisih', '>', '0')->get();
        return view("admin.dashboard.banner.banner-item", [
            "countItemBlmProses" => count($itemBlmProses),
            "countItemSdgProses" => count($itemSdgProses),
            "countItemOk" => count($itemOk),
            "countItemSelisih" => count($itemSelisih)
        ]);
    }

    public function print(String $request)
    {

        $pdf = App::make('dompdf.wrapper');

        if ($request == "1") {
            $data = ViewDashboard::where('status', '=', '0')->get();
            $view = view("admin.dashboard.pdf-item", ["itemBlmProses" => $data, "type" => 1]);
        } elseif ($request == "2") {
            $data = ViewDashboard::where('status', '!=', '0')->where('status', '!=', '3')->get();
            $view = view("admin.dashboard.pdf-item", ["itemSdgProses" => $data, "type" => 2]);
        } elseif ($request == "3") {
            $data =  ViewDashboard::where('status', '=', '3')->get();
            $view = view("admin.dashboard.pdf-item", ["itemSelesai" => $data, "type" => 3]);
        } else {
            $dataPlus = ViewDashboard::where('selisih', '>', '0')->get();
            $dataMinus = ViewDashboard::where('selisih', '<', '0')->get();
            $view = view("admin.dashboard.pdf-item", ["itemSelisihPlus" => $dataPlus, "itemSelisihMinus" => $dataMinus, "type" => 4]);
        }
        $pdf->loadHTML($view);
        return $pdf->stream();
    }

    public function showMainTable()
    {
        $item = ViewDashboard::all();
        return view("admin.dashboard.table.item.main-table-item", ["item" => $item]);
    }

    public function showBannerTable(String $request)
    {
        $dbxjob = DB::table('dbxjob')->where('jobtypeid', '=', 2)->get();
        $group = Group::all();
        if ($request == "1") {
            $itemBlmProses = ViewDashboard::where('status', '=', '0')->get();
            $view = view("admin.dashboard.table.item.item-belum-proses", [
                "itemBlmProses" => $itemBlmProses,
                "dbxjob" => $dbxjob, "dbmgroup" => $group
            ]);
        } else if ($request == '2') {
            $itemSdgProses = ViewDashboard::where('status', '!=', '0')->where('status', '!=', '3')->get();
            $view = view("admin.dashboard.table.item.item-sedang-proses", [
                "itemSdgProses" => $itemSdgProses,
                "dbxjob" => $dbxjob, "dbmgroup" => $group
            ]);
        } else if ($request == '3') {
            $itemOk = ViewDashboard::where('status', '=', '3')->get();
            $view = view("admin.dashboard.table.item.item-ok", [
                "itemSelesai" => $itemOk,
                "dbxjob" => $dbxjob, "dbmgroup" => $group
            ]);
        } else {
            $itemSelisihPlus = ViewDashboard::where('selisih', '>', '0')->get();
            $itemSelisihMinus = ViewDashboard::where('selisih', '<', '0')->get();
            $view = view("admin.dashboard.table.item.item-selisih", [
                "itemSelisihPlus" => $itemSelisihPlus, "itemSelisihMinus" => $itemSelisihMinus,
                "dbxjob" => $dbxjob, "dbmgroup" => $group
            ]);
        }
        return $view;
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
    public function show(Item $item)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    public function stopCSOItem()
    {
        DB::beginTransaction();

        $updateDbtTrsHed = DB::table('dbttrshed')
            ->where('statusdoc', '=', 'A')
            ->update(['endcsodate' => Carbon::now(), 'statusdoc' => 'E']);

        $updateDbtCsoHed = DB::table('dbtcsohed')
            ->where('status', '=', 'A')
            ->update(['status' => 'P',]);

        $subquery = DB::table('dbttrshed')
            ->select('trsid')
            ->where('statusdoc', 'statusdoc', 'P')
            ->orderByDesc('trsid')
            ->limit(1);

        $selectDbtCsoHed = DB::table('dbxjob')        
        ->join('dbtcsohed', 'dbxjob.userid', '=', 'dbtcsohed.pelakuid')
        ->selectRaw('DISTINCT dbtcsohed.trsid,userid,username,name,dbxjob.coyid,jobtypeid,"D" as status')
        ->where('dbtcsohed.trsid', '=', $subquery);

        $selectDbtTrsDet = DB::table('dbxjob')        
        ->join('dbttrsdet', 'dbttrsdet.analisatorid', '=', 'dbxjob.userid')
        ->selectRaw('DISTINCT dbttrsdet.trsid,userid,username,name,dbxjob.coyid,jobtypeid,"D" as status')
        ->where('dbttrsdet.trsid', '=', $subquery);

        $unionQuery = $selectDbtCsoHed->union($selectDbtTrsDet);

        $inserDbtCsoPrsn = DB::table('dbtcsoprsn')->insertUsing(['trsid', 'userid', 'username', 'name', 'coyid', 'jobtypeid', 'status'],$unionQuery);

        dd($updateDbtTrsHed);

        // if ($updateDbtTrsHed == true && $updateDbtCsoHed == true && $inserDbtCsoPrsn == true) {
        //     DB::commit();
        //     return redirect()->route("item.index")->with('status', 'CSO berhasil diberhentikan');
        // } else {
            DB::rollBack();
        //     return redirect()->route("item.index")->with('error', 'Gagal memberhentikan CSO');
        // }
    }

    public function endCSOItem()
    {
        DB::beginTransaction();

        $updateDbtTrsHed = DB::table('dbttrshed')
            ->where('statusdoc', '=', 'E')
            ->update(['statusdoc' => 'P']);

        DB::table('dbximpor')->truncate();
        DB::table('dbximpordet')->truncate();

        // $deleteDbxSetDate = DB::

        DB::table('dbxmaterial')->truncate();

        $updateDbtCsoPrsn = DB::table('dbtcsoprsn')
            ->update(['status' => 'P']);

        DB::table('dbxjob')->truncate();
        DB::table('dbxcsotype')->truncate();
    }

    public function startCSOItem()
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {

        // $keputusan->keputusandesc = $request->deskripsi;
        // $keputusan->updated_by = Auth::user()->username;
        // $keputusan->save();
        // return redirect()->route("keputusan.index")->with('status', 'Data keputusan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
