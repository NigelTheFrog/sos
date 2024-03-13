<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // protected $table = "viewdashboard";

    
    protected $fillable = [
    'itemid', 
    'itemcode', 
    'itemname', 
    'batchno', 
    'heatno', 
    'dimension', 
    'tolerance', 
    'kondisi', 
    'onhand', 
    'selisih', 
    'totalcso', 
    'status', 
    'statusname', 
    'koreksi', 
    'deviasi', 
    'statuscso', 
    'groupid', 
    'groupdesc', 
    'analisator', 
    'analisatorid',
    'keterangan'];

}
