<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = [
        'image', 'title', 'description', 'price'
    ];
}
