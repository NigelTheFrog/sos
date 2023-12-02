<?php

namespace App\Models\Admin\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaLokasi extends Model
{
    use HasFactory;
    public $table = "dbmlocation";

    protected $locationcode = "locationcode";
    protected $locationname = "locationname";
}
