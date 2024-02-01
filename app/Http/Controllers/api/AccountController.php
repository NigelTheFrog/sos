<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\api\CsoHed;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function login(Request $request) {
        $loginCredentials = $request->only("username","password");
        if(Auth::attempt($loginCredentials)) {
            $getCSOIDUser = DB::table('dbtcsohed')
            ->join('dbmuser','dbtcsohed.pelakuid', '=', 'dbmuser.userid')
            ->select('csoid')
            ->where('dbtcsohed.pelakuid','=',Auth::user()->userid)
            ->where('dbtcsohed.status','=','A')
            ->orderByDesc('csoid')
            ->limit(1)
            ->get();
            if($getCSOIDUser->count() > 0) {
                return response()->json(['result'=>1,'message'=>'login sucess', 'userid' => Auth::user()->userid,
                'username'=>Auth::user()->username, 'name'=>Auth::user()->name, 'level'=>Auth::user()->level, 
                'csoid' => $getCSOIDUser[0]->csoid]);
            } else {
                return response()->json(['result'=>1,'message'=>'login sucess', 'userid' => Auth::user()->userid,
                'username'=>Auth::user()->username, 'name'=>Auth::user()->name, 'level'=>Auth::user()->level, 
                'csoid' => 0]);
            }            
        } else {
            return response()->json(['result'=>0,'message'=>'Username / Password salah']);
        }
    }

    public function mulaiCSO(Request $request) {
        DB::beginTransaction();
        $getUserData = DB::table('dbmuser')
        ->leftJoin('dbmcoy','dbmuser.coyid', '=', 'dbmcoy.coyid')
        ->select(["dbmcoy.coycode AS coycode","dbmuser.userid AS userid","dbmuser.coyid AS coyid"])
        ->where('username','=',$request->username)->get();

        $generateNewCSOID=DB::table('dbtcsohed')
        ->select(DB::raw('csoID + 1 AS nextCsoId'))
        ->orderBy('csoid', 'desc')
        ->limit(1)
        ->get();

        $getNewCSOID=$generateNewCSOID??1;
        $docRefId="CS{$getUserData[0]->coycode}-$request->username". '-' . Carbon::now()->format('Ym') . '-' . str_pad($getNewCSOID,2,'0', STR_PAD_LEFT);

        $getTrsID = DB::table('dbttrshed')
        ->select('trsid')
        ->where('statusdoc','=','A')
        ->whereNull('endcsodate')
        ->orderBy('trsid', 'desc')
        ->limit(1)
        ->get();

        $insertValues = [
            'csoid' => $getNewCSOID[0]->nextCsoId,
            'trsid' => $getTrsID[0]->trsid,
            'docrefid' => $docRefId,
            'pelakuid' => $getUserData[0]->userid,
            'pelakuuname' => $request->username,
            'coyid' => $getUserData[0]->coyid,
            'status' => 'A',
            'tipecso'=>$request->tipecso
        ];        

        $insertHed = DB::table('dbtcsohed')->insert($insertValues);

        if($insertHed == true) {
            DB::commit();
            return response()->json(['result' => 1, 'csoid' => $getNewCSOID[0]->nextCsoId]);
        } else {
            DB::rollBack();
            return response()->json(['result' => 0, 'message' => 'Start CSO Gagal']);
        }
    }
}
