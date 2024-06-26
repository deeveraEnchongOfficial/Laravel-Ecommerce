<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'address',
        'password',
        'role',
        'photo',
        'status',
        'provider',
        'provider_id',
        'municipality_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    public function deliver(){
        return $this->hasMany('App\Models\Order');
    }

    public function notification(){
        return $this->hasMany('App\Models\Notification', 'notifiable_id');
    }

    public function userLocation(){
        return $this->hasMany('App\Models\UserLocation');
    }
}
