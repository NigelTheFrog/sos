<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = DB::table('dbmuser')->leftJoin('dbmlevel', 'dbmuser.level', '=', 'dbmlevel.levelid')->get();
        return view("admin.master.user", ["user" => $user]);
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
        $user = new ModelsUser;
        $user->userid =rand ( 991000 , 999999 );
        $user->name = $request->nama;
        $user->nik = $request->nik;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->level = $request->level;
        $user->created_by = Auth::user()->username;
        $user->coyid = 1;

        $user->save();
        return redirect()->route("user.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = DB::table('dbmuser')->leftJoin('dbmlevel', 'dbmuser.level', '=', 'dbmlevel.levelid')->get();
        $userDetail = DB::table('dbmuser')->leftJoin('dbmlevel', 'dbmuser.level', '=', 'dbmlevel.levelid')->where("id", "=", $id)->get();
        //dd($user);
        return view("admin.master.user", ["user" => $user, "userDetail" => $userDetail]);
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
    public function update(Request $request, ModelsUser $user)
    {
        $user->name = $request->nama;
        $user->nik = $request->nik;
        $user->username = $request->username;
        if ($request->level != "")
            $user->level = $request->level;

        $user->updated_by = Auth::user()->username;

        $user->save();
        return redirect()->route("user.index")->with('status', 'Data user berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelsUser $user)
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
