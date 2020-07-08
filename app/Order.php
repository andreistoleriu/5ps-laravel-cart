<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [
        'id'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps()->withPivot('product_price');
    }


}
