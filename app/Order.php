<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $fillable = [
        'name', 'contactDetails', 'price'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
