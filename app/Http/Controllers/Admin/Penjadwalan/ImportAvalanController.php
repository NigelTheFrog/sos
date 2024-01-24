<?php

namespace App\Http\Controllers\Admin\Penjadwalan;

use App\Http\Controllers\Controller;
use App\Models\Admin\Penjadwalan\ImportAvalan;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportAvalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $avalanBatch = DB::table("dbximpordetavalan")
            ->select("itemid", "batchid as batchiddet", DB::raw('SUM(qty) as qty'))
            ->groupBy("itemid", "batchiddet");

        $avalan = DB::table('dbximporavalan')
            ->leftJoinSub($avalanBatch, 'avalanBatch', function (JoinClause $join) {
                $join->on('dbximporavalan.itemid', '=', 'avalanBatch.itemid')->on('dbximporavalan.batchid', '=', 'avalanBatch.batchiddet');
            })->get();

        $startDate = DB::table('dbttrsheda')->select('startcsodate')->where('statusdoc','!=','P')->get();


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
            "response_wrh" => json_decode($responsewrh, true),
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
                                return redirect()->route("import-avalan.index")->with('error', "Avalan dengan batch id {$avalan['itembatchid']} sudah pernah diinput");
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
                                                return redirect()->route("import-avalan.index")->with('error', "Penambahan data detail impor avalan gagal");
                                            }
                                        }
                                    }
                                } else {
                                    DB::rollBack();
                                    return redirect()->route("import-avalan.index")->with('error', "Penambahan data impor avalan gagal");
                                }
                            }
                        }
                    }
                }
            }
            if ($noexist > 0) {
                DB::commit();
                return redirect()->route("import-avalan.index")->with('status', 'Berhasil melakukan impor avalan');
            } else {
                DB::rollBack();
                return redirect()->route("import-avalan.index")->with('error', "Terdapat duplikasi data avalan");
            }
        } else {
            $itemId = DB::table('dbximporavalan')->select('itemid')->where('statusitem', '=', 'T')->orderByDesc('createddate')->limit(1)->get();
            if (count($itemId) > 0) $itemId = $itemId[0]->itemid + 1;
            else $itemId = 9999001;

            $insertDbxImporAvalan = DB::table('dbximporavalan')->insert([
                'itemid' => $itemId,
                'itemname' => trim(ucwords($request->temuanname)),
                'batchid' => '0',
                'heatno' => trim(ucwords($request->temuanheatno)),
                'dimension' => trim(ucwords($request->temuandimension)),
                'kondisi' => trim(ucwords($request->temuancondition)),
                'uom' => strtoupper($request->satuan),
                'statusitem' => 'T'
            ]);

            if ($insertDbxImporAvalan == true) {
                DB::table('dbximpordetavalan')->insert([
                    'itemid' => $itemId,
                    'batchid' => '0',
                    'qty' => $request->temuanstok
                ]);
                DB::commit();
                return redirect()->route("import-avalan.index")->with('status', 'Berhasil menambahkan data temuan');
            } else {
                DB::rollBack();
                return redirect()->route("import-avalan.index")->with('error', "Gagal input data temuan");
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ImportAvalan $importAvalan)
    {
        //
    }

    public function showTable(Request $request)
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImportAvalan $importAvalan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ImportAvalan $importAvalan)
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

        // return redirect()->route("import-avalan.index")->with('status', json_encode($request->checkboxDelete));
        foreach ($request->checkboxDelete as $itemBatchId) {
            $deleteDbxImportAvalan = DB::table('dbximporavalan')->where('itembatchid', '=', $itemBatchId)->delete();
            if ($deleteDbxImportAvalan == true) {
                $deleteDbxImportAvalanDet = DB::table('dbximpordetavalan')->where('itembatchid', '=', $itemBatchId)->delete();
                if ($deleteDbxImportAvalanDet == true) $successDelete++;
            } else {
                $idItem = $itemBatchId;
                break;
            }
        }

        if ($successDelete > 0) {
            DB::commit();
            return redirect()->route("import-avalan.index")->with('status', 'Berhasil menghapus data item');
        } else {
            DB::rollBack();
            return redirect()->route("import-avalan.index")->with('error', "Terdapat kegagalan dalam menghapus data dengan itembatchid $idItem");
        }
    }
}
