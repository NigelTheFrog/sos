<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsoHed extends Model
{
    use HasFactory;

    public $table = "dbtcsohed";
    protected $fillable = [
        'csoid',
        'trsid',
        'docrefid',
        'pelakuid',
        'pelakuuname',
        'coyid',
        'status'
    ];

    protected $primaryKey = "csoid";
    protected $keyType = 'int';
    public $incrementing = false;
    protected $trsid = "trsid";
    protected $docrefid = "docrefid";
    protected $pelakuid = "pelakuid";
    protected $pelakuuname = "pelakuuname";
    protected $status = "status";
    protected $coyid = "coyid";

}
