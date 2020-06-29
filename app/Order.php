<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $fillable = [
        'name', 'contact_details'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps()->withPivot('product_price');
    }


}
