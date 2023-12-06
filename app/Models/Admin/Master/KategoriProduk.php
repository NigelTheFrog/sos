<?php

namespace App\Models\Admin\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'categorydesc',
    ];

    public $table = "dbmcategory";
    protected $primaryKey = "categoryid";
    protected $categorydesc = "categorydesc";
}
