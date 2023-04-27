<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_brand',
        'product_price',
        'product_description',
        'product_image'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'product_brand');
    }
}
