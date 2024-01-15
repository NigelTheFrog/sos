<?php

namespace App\Http\Controllers\Admin\Penjadwalan;

use App\Http\Controllers\Controller;
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
        
        return view("admin.penjadwalan.import-stok", ["stok" => $stok, "response_wrh" => json_decode($responsewrh, true)]);
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
        return view("admin.penjadwalan.import-avalan", ["avalan" => $avalan]);
    }
}
