<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [
        'id', 'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTimestamps();
    }
}
