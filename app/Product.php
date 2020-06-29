<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = [
        'image', 'title', 'description', 'price'
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withTimestamps()->withPivot('product_price');
    }
}
