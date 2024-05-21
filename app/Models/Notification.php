<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable=['data','type','notifiable','read_at'];

    public function user()
    {
        return $this->belongsTo('App\User', 'notifiable_id');
    }
}
