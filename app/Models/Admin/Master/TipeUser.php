<?php

namespace App\Models\Admin\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeUser extends Model
{
    use HasFactory;

    public $table = "dbmjobtype";

    protected $fillable = [
        'jobtypecode',
        'jobtypename',
    ];
    protected $jobtypecode = "jobtypecode";
    protected $jobtypename = "jobtypename";
}
