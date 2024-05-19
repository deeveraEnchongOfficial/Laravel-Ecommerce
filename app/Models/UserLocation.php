<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    protected $fillable = [
        'user_id',
        'origin',
        'latitude',
        'longitude',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
