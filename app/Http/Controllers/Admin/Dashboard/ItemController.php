<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin\Dashboard\Item;
use App\Models\ViewDashboard;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use \NumberFormatter;
use Barryvdh\Snappy\Facades\SnappyPdf;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = ViewDashboard::all();
        $itemBlmProses = ViewDashboard::where('status', '=', '0')->get();
        $countItemBlmProses = count($itemBlmProses);
        $itemSdgProses = ViewDashboard::where('status', '!=', '0')->where('status', '!=', '3')->get();
        $countItemSdgProses = count($itemSdgProses);
        $itemOk = ViewDashboard::where('status', '=', '3')->get();
        $countItemOk = count($itemOk);
        $itemSelisih = ViewDashboard::where('selisih', '>', '0')->get();
        $countItemSelisih = count($itemSelisih);
        return view("admin.dashboard.item", [
            'item' => $item,
            "countItemBlmProses" => $countItemBlmProses, "itemBlmProses" => $itemBlmProses,
            "countItemSdgProses" => $countItemSdgProses, "itemSdgProses" => $itemSdgProses,
            "countItemOk" => $countItemOk, "itemSelesai" => $itemOk,
            "countItemSelisih" => $countItemSelisih, "itemSelisih" => $itemSelisih
        ]);
    }

    public function showBanner()
    {
        $itemBlmProses = ViewDashboard::where('status', '=', '0')->get();
        $countItemBlmProses = count($itemBlmProses);
        $itemSdgProses = ViewDashboard::where('status', '!=', '0')->where('status', '!=', '3')->get();
        $countItemSdgProses = count($itemSdgProses);
        $itemOk = ViewDashboard::where('status', '=', '3')->get();
        $countItemOk = count($itemOk);
        $itemSelisih = ViewDashboard::where('selisih', '>', '0')->get();
        $countItemSelisih = count($itemSelisih);
        return view("admin.dashboard.banner.banner-item", [
            "countItemBlmProses" => $countItemBlmProses,
            "countItemSdgProses" => $countItemSdgProses,
            "countItemOk" => $countItemOk,
            "countItemSelisih" => $countItemSelisih
        ]);
    }

    public function print(Request $request)
    {

        $pdf = App::make('dompdf.wrapper');
        $data = ViewDashboard::where('status', '=', '0')->get();
        // if($request =="1")
        $view = view("admin.dashboard.pdf", ["itemBlmProses" => $data, "type"=>"1"]);
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
        if ($request == "1") {
            $itemBlmProses = ViewDashboard::where('status', '=', '0')->get();
            return view("admin.dashboard.table.item.item-belum-proses", ["itemBlmProses" => $itemBlmProses]);
        } else if ($request == '2') {
            $itemSdgProses = ViewDashboard::where('status', '!=', '0')->where('status', '!=', '3')->get();
            return view("admin.dashboard.table.item.item-sedang-proses", ["itemSdgProses" => $itemSdgProses]);
        } else if ($request == '3') {
            $itemOk = ViewDashboard::where('status', '=', '3')->get();
            return view("admin.dashboard.table.item.item-ok", ["itemSelesai" => $itemOk]);
        } else {
            $itemSelisih = ViewDashboard::where('selisih', '>', '0')->get();
            return view("admin.dashboard.table.item.item-selisih", ["itemSelisih" => $itemSelisih]);
        }
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
