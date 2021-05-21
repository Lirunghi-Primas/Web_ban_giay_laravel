<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'parent_id'
    ];

    public function parent()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public static function parents($except = null)
    {
        return self::where('parent_id', null)->where('id', '!=', $except)->get();
    }

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    public function siblings()
    {
        return $this->where('parent_id', $this->parent_id)->get();
    }
}
