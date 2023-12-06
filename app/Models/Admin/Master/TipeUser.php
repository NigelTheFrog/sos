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
        'created_by',
        'updated_by',
        'jobtypeid',
    ];
    protected $primaryKey = "jobtypeid";
    protected $jobtypecode = "jobtypecode";
    protected $jobtypename = "jobtypename";
    protected $created_by = "created_by";
    protected $updated_by = "updated_by";
}
