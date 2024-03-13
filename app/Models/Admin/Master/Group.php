<?php

namespace App\Models\Admin\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public $table = "dbmgroup";
    protected $primaryKey = "groupid";
    protected $groupdesc = "groupdesc";
}
