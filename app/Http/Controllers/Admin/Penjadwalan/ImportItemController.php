<?php

namespace App\Http\Controllers\Admin\Penjadwalan;

use App\Http\Controllers\Controller;
use App\Models\Admin\Penjadwalan\ImportItem;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itembatch = DB::table("dbximpordet")
            ->select("itembatchid as itembid", DB::raw('SUM(qty) as qty'))
            ->groupBy("itembid");

        $stok = DB::table('dbximpor')
            ->leftJoinSub($itembatch, 'itembatch', function (JoinClause $join) {
                $join->on('dbximpor.itembatchid', '=', 'itembatch.itembid');
            })->get();

        $startDate = DB::table('dbttrshed')->select('startcsodate')->where('statusdoc','!=','P')->get();

        error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_DEPRECATED);
        $companyID = config('values.companyId');

        //GET TOKEN
        $url = "http://erpapp.local.sutindo.net/APISutindo/Api/SOS/PosisiStock/getToken";

        $curl = curl_init();
        $data = array();
        $param = http_build_query($data);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS => $param,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST'
        ));

        $token = curl_exec($curl);
        $token = json_decode($token);
        $token = $token->data->token;

        curl_close($curl);


        //GET POSISI STOCK

        $data = [
            'companyID' => $companyID,
            // 'viewNull' => $filterViewNull,
            // 'search' => $search,
            // 'wrh' => $gudang,
            'token' => $token
        ];


        $url = "http://erpapp.local.sutindo.net/APISutindo/Api/SOS/Warehouse/getWarehouse";

        $curl = curl_init();
        $param = http_build_query($data);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS => $param,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST'
        ));
        $responsewrh = curl_exec($curl);
        curl_close($curl);

        return view("admin.penjadwalan.import-stok", [
            "importedBatch" => 0,
            "importedItem" => 0,
            "stok" => $stok,
            "response_wrh" =>
            json_decode($responsewrh, true),
            "csoActive" => count($startDate)
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

        if ($request->type == 1) {

            $companyID = config('values.companyId');
            $filterViewNull = $request->filternull;
            $gudangcode = $request->whs;
            $gudangname = '';
            $itemname = $request->itemname;

            error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_DEPRECATED);

            //GET TOKEN
            $url = "http://erpapp.local.sutindo.net/APISutindo/Api/SOS/PosisiStock/getToken";

            $curl = curl_init();
            $data = array();
            $param = http_build_query($data);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_POSTFIELDS => $param,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST'
            ));

            $token = curl_exec($curl);
            $token = json_decode($token);
            $token = $token->data->token;

            curl_close($curl);

            //GET POSISI STOCK
            $data = [
                'companyID' => $companyID,
                'showoffstock' => $filterViewNull,
                'whsecode' => $gudangcode,
                'whsename' => $gudangname,
                'itemname' => $itemname,
                'token' => $token
            ];


            $url = "http://erpapp.local.sutindo.net/APISutindo/Api/SOS/PosisiStock/getPosisiStock";

            $curl = curl_init();
            $param = http_build_query($data);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_POSTFIELDS => $param,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 20,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST'
            ));
            $responseitem = curl_exec($curl);
            curl_close($curl);
            $data = json_decode($responseitem, true);

            $noexist = 0;

            foreach ($request->checkboxImport as $valueCheckBox) {
                foreach ($data['data'] as $items) {
                    foreach ($items as $item) {
                        if ($item['ITEMID'] == $valueCheckBox) {
                            $idItem = DB::table('dbximpor')->select('itemid')->where('itemid', '=', $item['ITEMID'])->get();
                            if (count($idItem) > 0) {
                                return redirect()->route("import-stok.index")->with('error', "Item {$item['NamaItem']} sudah pernah diinput");
                            } else {
                                $noexist++;

                                $insertDbxImpor = DB::table('dbximpor')->insert([
                                    'itemid' => $item['ITEMID'],
                                    'itembatchid' => $item['ITEMID'],
                                    'itemcode' => $item['itemcode'],
                                    'itemname' => $item['NamaItem'],
                                    'uom' => $item['UOM'],
                                    'cogs' => $item['itemcost'],
                                    'productid' => $item['ProductID'],
                                    'productname' => $item['Product'],
                                    'subproductid' => $item['subproductid'],
                                    'subproductname' => $item['SubProduct'],
                                    'statusitem' => 'R',
                                    'isbatch' => '1'
                                ]);

                                if ($insertDbxImpor == true) {
                                    $keys = array_keys($item);
                                    $count = count($keys);
                                    for ($i = 10; $i < $count; $i++) {
                                        $key = $keys[$i];
                                        if ($item[$key] != 0) {
                                            $insertDbxImporDet = DB::table('dbximpordet')->insert([
                                                'itemid' => $valueCheckBox,
                                                'itembatchid' => $valueCheckBox,
                                                'wrh' => $key,
                                                'qty' => $item[$key]
                                            ]);

                                            if ($insertDbxImporDet == false) {
                                                DB::rollBack();
                                                return redirect()->route("import-stok.index")->with('error', "Penambahan data detail impor item gagal");
                                            }
                                        }
                                    }
                                } else {
                                    DB::rollBack();
                                    return redirect()->route("import-stok.index")->with('error', "Penambahan data impor item gagal");
                                }
                            }
                        }
                    }
                }
            }
            if ($noexist > 0) {
                DB::commit();
                return redirect()->route("import-stok.index")->with('status', 'Berhasil melakukan impor item');
            } else {
                DB::rollBack();
                return redirect()->route("import-stok.index")->with('error', "Terdapat duplikasi data item");
            }
        } else if ($request->type == 2) {
            $companyID = config('values.companyId');
            $filterViewNull = $request->filternull;
            $gudangcode = $request->whs;
            $gudangname = '';
            $itemname = $request->itemname;

            error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_DEPRECATED);

            //GET TOKEN
            $url = "http://erpapp.local.sutindo.net/APISutindo/Api/SOS/PosisiStock/getToken";

            $curl = curl_init();
            $data = array();
            $param = http_build_query($data);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_POSTFIELDS => $param,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST'
            ));

            $token = curl_exec($curl);
            $token = json_decode($token);
            $token = $token->data->token;

            curl_close($curl);

            // GET BATCH

            $data = [
                'companyID' => $companyID,
                'showoffstock' => $filterViewNull,
                'whsecode' => $gudangcode,
                'whsename' => $gudangname,
                'itemname' => $itemname,
                'token' => $token
            ];

            $url = "http://erpapp.local.sutindo.net/APISutindo/Api/SOS/PosisiStock/getBatch";

            $curl = curl_init();
            $param = http_build_query($data);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_POSTFIELDS => $param,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 20,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST'
            ));
            $responsebatch = curl_exec($curl);

            curl_close($curl);
            $data = json_decode($responsebatch, true);

            $noexist = 0;

            foreach ($request->checkboxImport as $valueCheckBox) {
                foreach ($data['data'] as $items) {
                    foreach ($items as $item) {
                        if ($item['itembatchid'] == $valueCheckBox) {
                            $idItem = DB::table('dbximpor')->select('itemid')->where('itembatchid', '=', $item['itembatchid'])->get();
                            if (count($idItem) > 0) {
                                return redirect()->route("import-stok.index")->with('error', "Item dengan batch id {$item['itembatchid']} sudah pernah diinput");
                            } else {
                                $noexist++;

                                $insertDbxImpor = DB::table('dbximpor')->insert([
                                    'itemid' => $item['ITEMID'],
                                    'itembatchid' => $item['itembatchid'],
                                    'itemcode' => $item['itemcode'],
                                    'itemname' => $item['NamaItem'],
                                    'batchid' => $item['batchid'],
                                    'heatno' => $item['HeatNo'],
                                    'dimension' => $item['Dimension'],
                                    'tolerance' => $item['Tolerance'],
                                    'kondisi' => $item['condition'],
                                    'uom' => $item['UOM'],
                                    'cogs' => $item['itemcost'],
                                    'productid' => $item['ProductID'],
                                    'productname' => $item['Product'],
                                    'subproductid' => $item['subproductid'],
                                    'subproductname' => $item['SubProduct'],
                                    'statusitem' => 'R',
                                    'isbatch' => '1'
                                ]);

                                if ($insertDbxImpor == true) {
                                    $keys = array_keys($item);
                                    $count = count($keys);
                                    for ($i = 17; $i < $count; $i++) {
                                        $key = $keys[$i];
                                        if ($item[$key] != 0) {
                                            $insertDbxImporDet = DB::table('dbximpordet')->insert([
                                                'itemid' => $item['ITEMID'],
                                                'itembatchid' => $item['itembatchid'],
                                                'batchid' => $item['batchid'],
                                                'wrh' => $key,
                                                'qty' => $item[$key]
                                            ]);

                                            if ($insertDbxImporDet == false) {
                                                DB::rollBack();
                                                return redirect()->route("import-stok.index")->with('error', "Penambahan data detail impor batch gagal");
                                            }
                                        }
                                    }
                                } else {
                                    DB::rollBack();
                                    return redirect()->route("import-stok.index")->with('error', "Penambahan data impor batch gagal");
                                }
                            }
                        }
                    }
                }
            }
            if ($noexist > 0) {
                DB::commit();
                return redirect()->route("import-stok.index")->with('status', 'Berhasil melakukan impor batch data');
            } else {
                DB::rollBack();
                return redirect()->route("import-stok.index")->with('error', "Terdapat duplikasi data batch");
            }
        } else {
            $itemId = DB::table('dbximpor')->select('itemid')->where('statusitem', '=', 'T')->orderByDesc('createddate')->limit(1)->get();
            if (count($itemId) > 0) $itemId = $itemId[0]->itemid + 1;
            else $itemId = 9999001;

            $insertDbxImpor = DB::table('dbximpor')->insert([
                'itemid' => $itemId,
                'itembatchid' => $itemId,
                'itemname' => trim(ucwords($request->temuanname)),
                'batchid' => '0',
                'heatno' => trim(ucwords($request->temuanheatno)),
                'dimension' => trim(ucwords($request->temuandimension)),
                'kondisi' => trim(ucwords($request->temuancondition)),
                'uom' => strtoupper($request->satuan),
                'statusitem' => 'T'
            ]);

            if($insertDbxImpor == true) {
                DB::table('dbximpordet')->insert([
                    'itemid' => $itemId,
                    'itembatchid' => $itemId,
                    'batchid' => '0',
                    'qty' => $request->temuanstok
                ]);
                DB::commit();
                return redirect()->route("import-stok.index")->with('status', 'Berhasil menambahkan data temuan');
            } else {
                DB::rollBack();
                return redirect()->route("import-stok.index")->with('error', "Gagal input data temuan");
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
    }

    public function showTable(Request $request)
    {
        $coy = DB::table('dbmcoy')->select('coycode')->where('coyid', '=', '1')->limit(1)->get();
        $companyID = config('values.companyId');
        $gudang = $request->gudang;
        $filterViewNull = false;
        $gudangcode = implode(",", $gudang);
        $gudangname = '';

        $itemname = $request->search;

        error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_DEPRECATED);

        if ($request->type == 1) {
            $itemcode = $request->search;
            //GET TOKEN
            $url = "http://erpapp.local.sutindo.net/APISutindo/Api/SOS/PosisiStock/getToken";

            $curl = curl_init();
            $data = array();
            $param = http_build_query($data);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_POSTFIELDS => $param,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST'
            ));

            $token = curl_exec($curl);
            $token = json_decode($token);
            $token = $token->data->token;

            curl_close($curl);

            //GET POSISI STOCK
            $data = [
                'companyID' => $companyID,
                'showoffstock' => $filterViewNull,
                'whsecode' => $gudangcode,
                'whsename' => $gudangname,
                'itemcode' => $itemcode,
                'itemname' => $itemname,
                'token' => $token
            ];


            $url = "http://erpapp.local.sutindo.net/APISutindo/Api/SOS/PosisiStock/getPosisiStock";

            $curl = curl_init();
            $param = http_build_query($data);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_POSTFIELDS => $param,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 20,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST'
            ));
            $responseitem = curl_exec($curl);
            curl_close($curl);
            $data = json_decode($responseitem, true);
            return view("admin.penjadwalan.item.table-pull-import", [
                "importedItem" => count($data['data']),
                "gudang" => $request->gudang,
                "responseitem" => $data,
                "companyID" => $companyID,
                "filterViewNull" => $filterViewNull,
                "gudangcode" => $gudangcode,
                "itemname" => $itemname
            ]);
        } else {
            $heatno = $request->search;
            $url = "http://erpapp.local.sutindo.net/APISutindo/Api/SOS/PosisiStock/getToken";

            $curl = curl_init();
            $data = array();
            $param = http_build_query($data);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_POSTFIELDS => $param,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST'
            ));

            $token = curl_exec($curl);
            $token = json_decode($token);
            $token = $token->data->token;

            curl_close($curl);


            // $companyID = 'SRM SBY';
            // $filterViewNull = false;
            // $gudangcode = 'SBY1TSA,SBY2TSA';
            // $gudangname = '';
            // $heatno = '';
            // $itemname = '';


            // GET BATCH

            $data = [
                'companyID' => $companyID,
                'showoffstock' => $filterViewNull,
                'whsecode' => $gudangcode,
                'whsename' => $gudangname,
                'heatno' => $heatno,
                'itemname' => $itemname,
                'token' => $token
            ];


            $url = "http://erpapp.local.sutindo.net/APISutindo/Api/SOS/PosisiStock/getBatch";

            $curl = curl_init();
            $param = http_build_query($data);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_POSTFIELDS => $param,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 20,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST'
            ));
            $responsebatch = curl_exec($curl);

            curl_close($curl);
            $data = json_decode($responsebatch, true);
            return view("admin.penjadwalan.item.table-pull-import-batch", [
                "importedBatch" => count($data['data']),
                "gudang" => $request->gudang,
                "responsebatch" => $data,
                "companyID" => $companyID,
                "filterViewNull" => $filterViewNull,
                "gudangcode" => $gudangcode,
                "itemname" => $itemname
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImportItem $importItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ImportItem $importItem)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        $successDelete = 0;
        $idItem = "";
        if($request->checkboxDelete != null) {
            foreach ($request->checkboxDelete as $itemBatchId) {
                $deleteDbxImport = DB::table('dbximpor')->where('itembatchid', '=', $itemBatchId)->delete();
                if ($deleteDbxImport == true) {
                    DB::table('dbximpordet')->where('itembatchid', '=', $itemBatchId)->delete();
                    $successDelete++;
                } else {
                    $idItem = $itemBatchId;
                    break;
                }
            }
    
            if ($successDelete > 0) {
                DB::commit();
                return redirect()->route("import-stok.index")->with('status', 'Berhasil menghapus data item');
            } else {
                DB::rollBack();
                return redirect()->route("import-stok.index")->with('error', "Terdapat kegagalan dalam menghapus data dengan itembatchid $idItem");
            }
        } else {
            DB::rollBack();
                return redirect()->route("import-stok.index")->with('error', "Harap pilih item yang hendak dihapus terlebih dahulu");
            
        }
        
    }
}
