<?php

namespace App\Models\Admin\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPorduk extends Model
{
    use HasFactory;
    public $table = "dbmcategory";

    protected $categorydesc = "categorydesc";
}
