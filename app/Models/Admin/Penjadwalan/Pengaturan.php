<?php

namespace App\Models\Admin\Penjadwalan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    public $table = "dbxjob";
    // protected $fillable = [
    //     'colordesc',
    // ];
    protected $primaryKey = "jobid";

    protected $userid = "userid";
}
