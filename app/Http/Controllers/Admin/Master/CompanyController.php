<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Admin\Master\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company = Company::all();
        
        return view("admin.master.company",["company"=> $company]);
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
        $data = new Company;
        $data->coycode = $request->coycode;
        $data->description = $request->deskripsi;        
        $data->created_by = Auth::user()->username;
        $data->save();
        return redirect()->route("company.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $company->coycode = $request->coycode;
        $company->description = $request->deskripsi;
        $company->updated_by = Auth::user()->username;
        $company->save();
        return redirect()->route("company.index")->with('status', 'Data company berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        try {
            $company->delete();
            return redirect()->route("company.index")->with('status', 'Data company berhasil dihapus');
        } catch(\PDOException $e) {
            $msg = "Data gagal dihapus karena data ini merupakan data parent dari tabel lain";
            return redirect()->route("company.index")->with('error', $msg);
        }
    }
}
