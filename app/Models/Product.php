<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function getThumbnail()
    {
        return asset($this->thumbnail_path ?? 'images/no-thumbnail.png');
    }

    public function order_items()
    {
        return $this->belongsTo('App\Models\OrderItem');
    }
}
