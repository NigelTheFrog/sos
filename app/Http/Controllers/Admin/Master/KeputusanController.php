<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Admin\Master\Keputusan;
use Illuminate\Http\Request;

class KeputusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keputusan = Keputusan::all();
        return view("admin.master.keputusan",["keputusan"=> $keputusan]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Keputusan $keputusan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keputusan $keputusan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keputusan $keputusan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keputusan $keputusan)
    {
        //
    }
}
