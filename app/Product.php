<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [
        'id'
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withTimestamps()->withPivot('product_price');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->withTimestamps();
    }
}
