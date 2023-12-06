<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Admin\Master\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $group = Group::all();
        return view("admin.master.group",["group"=> $group]);
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
        $data = new Group;
        $data->groupdesc = $request->deskripsi;        
        $data->created_by = Auth::user()->username;
        $data->save();
        return redirect()->route("group.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $group->groupdesc = $request->deskripsi;
        $group->updated_by = Auth::user()->username;
        $group->save();
        return redirect()->route("group.index")->with('status', 'Data group berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        try {
            $group->delete();
            return redirect()->route("group.index")->with('status', 'Data group berhasil dihapus');
        } catch(\PDOException $e) {
            $msg = "Data gagal dihapus karena data ini merupakan data parent dari tabel lain";
            return redirect()->route("group.index")->with('error', $msg);
        }
    }
}
