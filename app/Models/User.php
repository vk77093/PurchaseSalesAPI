<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use HasFactory, Notifiable,softDeletes;
    const VERIFIED_USER ='1';
    const UNVERIFIED_USER ='0';

    const ADMIN_USER ='true';
    const REGULAR_USER='false';
 protected $table='users';
 protected $dates=['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified','c','admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verificationToken'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // making function for checkin the user const values

    public function isVerified(){
        return $this->verified==User::VERIFIED_USER;
    }
    public function isAdmin(){
        return $this->admin==User::ADMIN_USER;
    }

    // now for generating Tokens for user

    public static function generateVerifiedToken(){
        return Str::random(40);
    }
    public function setNameAttribute($name){
         $this->attributes['name']=Str::lower($name);
    }
    public function getNameAttribute($name){
return ucwords($name);
    }
}
