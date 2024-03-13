<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Admin\Master\TipeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TipeUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipe = TipeUser::all();
        return view("admin.master.tipe-user",["tipeUser"=> $tipe]);
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
        $data = new TipeUser;
        $data->jobtypecode = $request->usertype;
        $data->jobtypename = $request->deskripsi;
        $data->created_by = Auth::user()->username;
        $data->save();
        return redirect()->route("tipe-user.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(TipeUser $tipeUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipeUser $tipeUser)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipeUser $tipeUser)
    {
        $tipeUser->jobtypecode = $request->usertype;
        $tipeUser->jobtypename = $request->deskripsi;
        $tipeUser->updated_by = Auth::user()->username;

        $tipeUser->save();
        return redirect()->route("tipe-user.index")->with('status', 'Data tipe-user berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipeUser $tipeUser)
    {
        try {
            $tipeUser->delete();
            return redirect()->route("tipe-user.index")->with('status', 'Data tipe-user berhasil dihapus');
        } catch(\PDOException $e) {
            $msg = "Data gagal dihapus karena data ini merupakan data parent dari tabel lain";
            return redirect()->route("tipe-user.index")->with('error', $msg);
        }
    }
}
