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
            // ssh-ed25519 255 SHA256:MXxecc+xkd1ri1J8dH0XTP+Ye6neLbNbY4e6ERFdbko
    public function login(Request $request) {
        $loginCredentials = $request->only("username","password");
        if(Auth::attempt($loginCredentials)) {
            $getCSOIDItemUser = DB::table('dbtcsohed')
            ->join('dbmuser','dbtcsohed.pelakuid', '=', 'dbmuser.userid')
            ->select('trsid','csoid')
            ->where('dbtcsohed.pelakuid','=',Auth::user()->userid)
            ->where('dbtcsohed.status','=','A')
            ->where('dbtcsohed.tipecso','=','R')
            ->orderByDesc('csoid')
            ->limit(1)
            ->get();

            $getCSOIDAvalanUser = DB::table('dbtcsohed')
            ->join('dbmuser','dbtcsohed.pelakuid', '=', 'dbmuser.userid')
            ->select('trsid','csoid')
            ->where('dbtcsohed.pelakuid','=',Auth::user()->userid)
            ->where('dbtcsohed.status','=','A')
            ->where('dbtcsohed.tipecso','=','A')
            ->orderByDesc('csoid')
            ->limit(1)
            ->get();

            $csoIdItem = "";
            $csoIdAvalan = "";
            $trsIdItem = "";
            $trsIdAvalan = "";
            if($getCSOIDItemUser->count() > 0) {
                $csoIdItem = $getCSOIDItemUser[0]->csoid;
                $trsIdItem = $getCSOIDItemUser[0]->trsid;
            } 

            if($getCSOIDAvalanUser->count() > 0) {
                $csoIdAvalan = $getCSOIDAvalanUser[0]->csoid;
                $trsIdAvalan = $getCSOIDAvalanUser[0]->trsid;
            }            
            return response()->json(['result'=>1,'message'=>'login sucess', 'userid' => Auth::user()->userid,
                'username'=>Auth::user()->username, 'name'=>Auth::user()->name, 'level'=>Auth::user()->level, 
                'csoiditem' => $csoIdItem, 'csoidavalan' => $csoIdAvalan, 'trsiditem' => $trsIdItem, 'trsidavalan' => $trsIdAvalan]);
        } else {
            return response()->json(['result'=>0,'message'=>'Username / Password salah']);
        }
    }

    public function mulaiCSOItem(Request $request) {
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
        ->orderByDesc('trsid')
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
            'tipecso'=> 'R'
        ];        

        $insertHed = DB::table('dbtcsohed')->insert($insertValues);

        if($insertHed == true) {
            DB::commit();
            return response()->json(['result' => 1, 'csoid' => $getNewCSOID[0]->nextCsoId, 'trsid' => $getTrsID[0]->trsid]);
        } else {
            DB::rollBack();
            return response()->json(['result' => 0, 'message' => 'Start CSO Gagal']);
        }
    }

    public function mulaiCSOAvalan(Request $request) {
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

        $getTrsID = DB::table('dbttrsheda')
        ->select('trsid')
        ->where('statusdoc','=','A')
        ->whereNull('endcsodate')
        ->orderByDesc('trsid')
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
            'tipecso'=> 'A'
        ];        

        $insertHed = DB::table('dbtcsohed')->insert($insertValues);

        if($insertHed == true) {
            DB::commit();
            return response()->json(['result' => 1, 'csoid' => $getNewCSOID[0]->nextCsoId, 'trsid' => $getTrsID[0]->trsid]);
        } else {
            DB::rollBack();
            return response()->json(['result' => 0, 'message' => 'Start CSO Gagal']);
        }
    }
}
