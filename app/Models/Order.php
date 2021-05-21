<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'fullname',
        'phone_number',
        'email',
        'address',
        'bill',
        'user_id',
    ];

    public function items()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
