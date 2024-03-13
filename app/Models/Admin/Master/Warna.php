<?php

namespace App\Models\Admin\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warna extends Model
{
    use HasFactory;

    public $table = "dbmcolor";
    protected $fillable = [
        'colordesc',
    ];
    protected $primaryKey = "colorid";

    protected $colordesc = "colordesc";
}
