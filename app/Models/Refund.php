<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Refund extends Model
{
    protected $fillable = [
        'reason',
        'refund_amount',
        'description',
        'user_id',
        'order_id',
        'product_id',
        'status',
        'photo'
    ];

    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
