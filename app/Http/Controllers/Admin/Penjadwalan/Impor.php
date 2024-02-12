<?php

namespace App\Http\Controllers\Admin\Penjadwalan;

use App\Http\Controllers\Controller;
use App\Models\Admin\Master\Company;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Impor extends Controller
{
    public function imporStok()
    {
        $itembatch = DB::table("dbximpordet")
            ->select("itembatchid as itembid", DB::raw('SUM(qty) as qty'))
            ->groupBy("itembid");

        $stok = DB::table('dbximpor')
            ->leftJoinSub($itembatch, 'itembatch', function (JoinClause $join) {
                $join->on('dbximpor.itembatchid', '=', 'itembatch.itembid');
            })->get();
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
        $companyID = 'SRM SBY';

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
            // "",
            "response_wrh" =>
            json_decode($responsewrh, true)
        ]);
    }

    public function addImportItem(Request $request)
    {
        DB::beginTransaction();

        $companyID = $request->coy;
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
                            return redirect()->route("import-stok")->with('error', "Item {$item['NamaItem']} sudah pernah diinput");
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
                                for ($i = 17; $i < $count; $i++) {
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
                                            return redirect()->route("import-stok")->with('error', "Penambahan data detail impor item gagal");
                                        }
                                    }
                                }
                            } else {
                                DB::rollBack();
                                return redirect()->route("import-stok")->with('error', "Penambahan data impor item gagal");
                            }
                        }
                    }
                }
            }
        }
        if ($noexist > 0) {
            DB::commit();
            return redirect()->route("import-stok")->with('status', 'Berhasil melakukan impor item');
        } else {
            DB::rollBack();
            return redirect()->route("import-stok")->with('error', "Terdapat duplikasi data item");
        }
    }

    public function showTableItem(Request $request)
    {
        $coy = DB::table('dbmcoy')->select('coycode')->where('coyid', '=', '1')->limit(1)->get();
        $companyID = $coy[0]->coycode;
        $gudang = $request->gudang;
        $filterViewNull = false;
        $gudangcode = implode(",", $gudang);
        $gudangname = '';
        $itemcode = $request->search;
        $itemname = $request->search;

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
    }

    public function addImportBatch(Request $request)
    {
        DB::beginTransaction();

        $companyID = $request->coy;
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
                            return redirect()->route("import-stok")->with('error', "Item dengan batch id {$item['itembatchid']} sudah pernah diinput");
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
                                            return redirect()->route("import-stok")->with('error', "Penambahan data detail impor batch gagal");
                                        }
                                    }
                                }
                            } else {
                                DB::rollBack();
                                return redirect()->route("import-stok")->with('error', "Penambahan data impor batch gagal");
                            }
                        }
                    }
                }
            }
        }
        if ($noexist > 0) {
            DB::commit();
            return redirect()->route("import-stok")->with('status', 'Berhasil melakukan impor batch data');
        } else {
            DB::rollBack();
            return redirect()->route("import-stok")->with('error', "Terdapat duplikasi data batch");
        }
    }

    public function showTableBatch(Request $request)
    {
        $coy = DB::table('dbmcoy')->select('coycode')->where('coyid', '=', '1')->limit(1)->get();
        $companyID = $coy[0]->coycode;
        $gudang = $request->gudang;
        $filterViewNull = false;
        $gudangcode = implode(",", $gudang);
        $gudangname = '';
        $heatno = $request->search;
        $itemname = $request->search;

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
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $token )); 
        $responsebatch = curl_exec($curl);

        curl_close($curl);
        $data = json_decode($responsebatch, true);
        // return response()->json(["importedBatch" => count($data['data']), "gudang" => $request->gudang, "responsebatch" => $data]);
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

    public function imporAvalan()
    {
        $avalanBatch = DB::table("dbximpordetavalan")
            ->select("itemid", "batchid as batchiddet", DB::raw('SUM(qty) as qty'))
            ->groupBy("itemid", "batchiddet");

        $avalan = DB::table('dbximporavalan')
            ->leftJoinSub($avalanBatch, 'avalanBatch', function (JoinClause $join) {
                $join->on('dbximporavalan.itemid', '=', 'avalanBatch.itemid')->on('dbximporavalan.batchid', '=', 'avalanBatch.batchiddet');
            })->get();

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
        $companyID = 'SRM SBY';

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

        return view("admin.penjadwalan.import-avalan", [
            "avalan" => $avalan,
            "response_wrh" => json_decode($responsewrh, true)
        ]);
    }

    public function showTableAvalan(Request $request)
    {
        $coy = DB::table('dbmcoy')->select('coycode')->where('coyid', '=', '1')->limit(1)->get();
        $companyID = $coy[0]->coycode;
        $gudang = $request->gudang;
        $filterViewNull = false;
        $gudangcode = implode(",", $gudang);
        $gudangname = '';
        $heatno = $request->search;
        $itemname = $request->search;

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
            CURLOPT_TIMEOUT => 0,
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
        // $gudangcode = 'SBY2TSA,SBY4TSA';
        // $gudangname = '';
        // $heatno = '';
        // $itemname = '';


        $data = [
            'companyID' => $companyID,
            'showoffstock' => $filterViewNull,
            'whsecode' => $gudangcode,
            'whsename' => $gudangname,
            'heatno' => $heatno,
            'itemname' => $itemname,
            'token' => $token
        ];


        $url = "http://erpapp.local.sutindo.net/APISutindo/Api/SOS/PosisiStock/getavalan";

        $curl = curl_init();
        $param = http_build_query($data);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS => $param,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST'
        ));
        $responseavalan = curl_exec($curl);

        curl_close($curl);
        
        $data = json_decode($responseavalan, true);
        // return response()->json(["importedBatch" => count($data['data']), "gudang" => $request->gudang, "responsebatch" => $data]);
        return view("admin.penjadwalan.avalan.table-pull-import-avalan", [
            "importedAvalan" => count($data['data']),
            "gudang" => $request->gudang,
            "responseavalan" => $data,
            "companyID" => $companyID,
            "filterViewNull" => $filterViewNull,
            "gudangcode" => $gudangcode,
            "itemname" => $itemname
        ]);
    }

    public function addImportAvalan(Request $request)
    {
        DB::beginTransaction();

        $companyID = $request->coy;
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
            CURLOPT_TIMEOUT => 0,
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
        // $gudangcode = 'SBY2TSA,SBY4TSA';
        // $gudangname = '';
        // $heatno = '';
        // $itemname = '';


        $data = [
            'companyID' => $companyID,
            'showoffstock' => $filterViewNull,
            'whsecode' => $gudangcode,
            'whsename' => $gudangname,
                'itemname' => $itemname,
            'token' => $token
        ];


        $url = "http://erpapp.local.sutindo.net/APISutindo/Api/SOS/PosisiStock/getavalan";

        $curl = curl_init();
        $param = http_build_query($data);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS => $param,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST'
        ));
        $responseavalan = curl_exec($curl);

        curl_close($curl);
        
        $data = json_decode($responseavalan, true);

        $noexist = 0;

        foreach ($request->checkboxImport as $valueCheckBox) {
            foreach ($data['data'] as $avalans) {
                foreach ($avalans as $avalan) {
                    if ($avalan['itembatchid'] == $valueCheckBox) {
                        $idItem = DB::table('dbximporavalan')->select('itemid')->where('itembatchid', '=', $avalan['itembatchid'])->get();
                        if (count($idItem) > 0) {
                            return redirect()->route("import-avalan")->with('error', "Avalan dengan batch id {$avalan['itembatchid']} sudah pernah diinput");
                        } else {
                            $noexist++;

                            $insertDbxImporAvalan = DB::table('dbximporavalan')->insert([
                                'itemid' => $avalan['ITEMID'],
                                'itembatchid' => $avalan['itembatchid'],
                                'itemcode' => $avalan['itemcode'],
                                'itemname' => $avalan['NamaItem'],
                                'batchid' => $avalan['batchid'],
                                'heatno' => $avalan['HeatNo'],
                                'dimension' => $avalan['Dimension'],
                                'tolerance' => $avalan['Tolerance'],
                                'kondisi' => $avalan['condition'],
                                'uom' => $avalan['UOM'],
                                'cogs' => $avalan['itemcost'],
                                'productid' => $avalan['ProductID'],
                                'productname' => $avalan['Product'],
                                'subproductid' => $avalan['subproductid'],
                                'subproductname' => $avalan['SubProduct'],
                                'statusitem' => 'R',
                                'isbatch' => '1'
                            ]);
                            

                            if ($insertDbxImporAvalan == true) {
                                $keys = array_keys($avalan);
                                $count = count($keys);
                                for ($i = 17; $i < $count; $i++) {
                                    $key = $keys[$i];
                                    if ($avalan[$key] != 0) {
                                        $insertDbxImporDet = DB::table('dbximpordetavalan')->insert([
                                            'itemid' => $avalan['ITEMID'],
                                            'itembatchid' => $avalan['itembatchid'],
                                            'batchid' => $avalan['batchid'],
                                            'wrh' => $key,
                                            'qty' => $avalan[$key]
                                        ]);
                                        

                                        if ($insertDbxImporDet == false) {
                                            DB::rollBack();
                                            return redirect()->route("import-stok")->with('error', "Penambahan data detail impor avalan gagal");
                                        }
                                    }
                                }
                            } else {
                                DB::rollBack();
                                return redirect()->route("import-stok")->with('error', "Penambahan data impor avalan gagal");
                            }
                        }
                    }
                }
            }
        }
        if ($noexist > 0) {
            DB::commit();
            return redirect()->route("import-avalan")->with('status', 'Berhasil melakukan impor avalan');
        } else {
            DB::rollBack();
            return redirect()->route("import-avalan")->with('error', "Terdapat duplikasi data avalan");
        }
    }
}
