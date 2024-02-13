<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = DB::table('dbmuser')->leftJoin('dbmlevel', 'dbmuser.level', '=', 'dbmlevel.levelid')->get();
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


        $companyID = 'SRM SBY';

        $data = [
            'companyID' => $companyID,
            // 'type'=>$type,
            // 'search'=>$search,
            'token' => $token
        ];

        //GET USER
        $urlu = "http://erpapp.local.sutindo.net/APISutindo/Api/SOS/User/getUser";

        $curlu = curl_init();
        $param = http_build_query($data);
        curl_setopt_array($curlu, array(
            CURLOPT_URL => $urlu,
            CURLOPT_POSTFIELDS => $param,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST'
        ));
        $responseuser = curl_exec($curlu);

        curl_close($curlu);

        return view("admin.master.user", ["user" => $user, "importedUser" => $responseuser]);
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
        $user = new User;
        $user->name = $request->nama;
        $user->nik = $request->nik;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->level = $request->level;
        $user->createdby = Auth::user()->username;
        $user->coyid = 1;

        $user->save();
        return redirect()->route("user.index");
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
