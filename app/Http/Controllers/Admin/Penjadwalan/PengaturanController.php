<?php

namespace App\Http\Controllers\Admin\Penjadwalan;

use App\Models\User as ModelsUser;
use App\Http\Controllers\Controller;
use App\Models\Admin\Penjadwalan\Pengaturan;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaturanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobtype = DB::table('dbxjob')->leftJoin('dbmjobtype', 'dbxjob.jobtypeid', '=', 'dbmjobtype.jobtypeid')->get();
        $category = DB::table('dbmcategory')->get();

        $job = DB::table("dbxjob")
            ->select("userid as useridjob");
        $user = DB::table('dbmuser')
            ->leftJoinSub($job, 'job', function (JoinClause $join) {
                $join->on('dbmuser.userid', '=', 'job.useridjob');
            })->whereNull('job.useridjob')->get();

        $fetchcsoitem = DB::table('dbxmaterial')->select('csomaterial')->limit(1)->get();

        $fetchcsotype = DB::table('dbxcsotype')->select('csotype')->limit(1)->get();

        if (count($fetchcsoitem) > 0) {
            $csoitem = $fetchcsoitem[0]->csomaterial;
        } else {
            $csoitem = "";
        }

        if (count($fetchcsotype) > 0) {
            $csotype = $fetchcsotype[0]->csotype;
        } else {
            $csotype = "";
        }

        return view("admin.penjadwalan.pengaturan", [
            "jobtype" => $jobtype,
            "category" => $category,
            "pelaku" => $user,
            "csotype" => $csotype,
            "csoitem" => $csoitem
        ]);
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
        // dd($request->type);
        if ($request->type == 1) {
            DB::table('dbxcsotype')->truncate();
            DB::table('dbxcsotype')->insert(['csotype' => $request->typestock]);
        } elseif ($request->type == 2) {
            $item = implode(",", $request->itemcso);
            DB::table('dbxmaterial')->truncate();
            DB::table('dbxmaterial')->insert(['csomaterial' => $item]);
        } elseif ($request->type == 3) {
            $datajob = DB::table('dbxjob')->pluck('userid');
            $datauser = ModelsUser::all();
            $pelaku = explode(",", $request->pelaku[0]);

            foreach ($pelaku as $p) {
                if ($datajob->contains($p)) {
                    continue;
                }
                $isDuplicatep = DB::table('dbxjob')->where('userid', $p)->exists();

                if (!$isDuplicatep) {
                    $user = $datauser->firstWhere('userid', $p);

                    if ($user) {
                        DB::table('dbxjob')->insert([
                            'userid' => $p,
                            'username' => $user->username,
                            'name' => $user->name,
                            'coyid' => 1,
                            'jobtypeid' => 1
                        ]);

                        DB::table('dbmuser')->where('userid', $p)->update(['level' => 4]);
                    }
                }
            }
        } else {
            $datajob = DB::table('dbxjob')->pluck('userid');
            $datauser = ModelsUser::all();
            $analisator = explode(",", $request->analisator[0]); 

            foreach ($analisator as $a) {
                if ($datajob->contains($a)) {
                    continue;
                }
                $isDuplicatep = DB::table('dbxjob')->where('userid', $a)->exists();

                if (!$isDuplicatep) {
                    $user = $datauser->firstWhere('userid', $a);

                    if ($user) {
                        DB::table('dbxjob')->insert([
                            'userid' => $a,
                            'username' => $user->username,
                            'name' => $user->name,
                            'coyid' => 1,
                            'jobtypeid' => 2
                        ]);

                        DB::table('dbmuser')->where('userid', $a)->update(['level' => 3]);
                    }
                }
            }
        }

        return redirect()->route("pengaturan.index")->with('status', 'Berhasil mengubah data pengaturan CSO');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengaturan $pengaturan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengaturan $pengaturan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengaturan $pengaturan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengaturan $pengaturan)
    {
        try {
            $pengaturan->delete();
            return redirect()->route("pengaturan.index")->with('status', 'Berhasil menghapus user dari pengaturan');
        } catch (\PDOException $e) {
            return redirect()->route("pengaturan.index")->with('error', "Gagal menghapus data");
        }
    }
}
