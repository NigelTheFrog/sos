<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public $table = "dbmuser";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userid',
        'nik',
        'username',        
        'name',
        'coyid',
        'level',
        'password',
        'created_by',
        'updated_by',
    ];
    // protected $username = "usernme";
    // protected $name = "name";
    // protected $nik = "nik";
    // // protected $password = "password";
    // protected $level = "level";
    protected $created_by = "created_by";
    // protected $coyid = "coyid";
    protected $updated_by = "updated_by";

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
