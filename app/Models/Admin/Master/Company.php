<?php

namespace App\Models\Admin\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    public $table = "dbmcoy";

    protected $fillable = [
        'coycode',
        'description',
    ];
    protected $primaryKey = "coyid";
    protected $coycode = "coycode";
    protected $description = "description";
}
