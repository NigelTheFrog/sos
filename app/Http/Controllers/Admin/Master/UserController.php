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

        return view("admin.master.user", ["user" => $user, "importedUser" => json_decode($responseuser)]);
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
            $user = new User;   
            $randomNumber = rand(100, 999); // Generate a random 3-digit number
            $generatedUserId = "99" . $randomNumber;         
            $user->userid = $generatedUserId;
            $user->name = $request->nama;
            $user->nik = $request->nik;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->level = $request->level;
            $user->created_by = Auth::user()->username;
            $user->coyid = 1;

            $user->save();

            DB::commit();
            return redirect()->route("user.index")->with('status', 'Berhasil menambahkan pengguna baru');
        } else {
            $noexist = 0;

            foreach ($request->checkboxImport as $checkbox_value) {
                
                $checkExistingUser = DB::table('dbmuser')->select('userid')->where('userid', '=', $checkbox_value)->get();
                if (count($checkExistingUser) > 0) {
                    $noexist++;
                    break;
                } else {
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

                    $importedUser = json_decode($responseuser, true);


                    foreach($importedUser['data']  as $index => $dataUser) {
                        $password = 'sos123';

                        if($dataUser[$index]['UserID'] == $checkbox_value) {
                            $user = new User;
                            $user->userid = $checkbox_value;
                            $user->name = $dataUser[$index]['FullName'];
                            $user->nik = $dataUser[$index]['NIK'];
                            $user->username = $dataUser[$index]['username'];
                            $user->password = bcrypt($password);
                            $user->created_by = Auth::user()->username;
                            $user->coyid = 1;
                
                            $user->save();
                        }
                    }
                }
            }

            if($noexist == 0) {
                DB::commit();
                return redirect()->route("user.index")->with('status', 'Penambahan data pengguna berhasil');
            } else {
                DB::rollBack();
                return redirect()->route("user.index")->with('error', 'Data yang dipilih sudah pernah diinput ke database');
            }
        }
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
    public function update(Request $request, User $user)
    {
        $user->name = $request->nama;
        $user->nik = $request->nik;
        $user->username = $request->username;
        if($request->level != null || $request->level != "") {
            $user->level = $request->level;
        }        
        $user->updated_by = Auth::user()->username;
        $user->save();
        return redirect()->route("user.index")->with('status', "Data pengguna $request->nama berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route("user.index")->with('status', 'Data user berhasil dihapus');
        } catch(\PDOException $e) {
            $msg = "Data gagal dihapus karena data ini merupakan data parent dari tabel lain";
            return redirect()->route("user.index")->with('error', $msg);
        }
    }
}
