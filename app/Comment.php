<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'message'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTimestamps();
    }
}
