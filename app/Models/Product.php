<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'images',
        'price',
        'compare_price',
        'category_id',
        'sub_category_id',
        'brand_id',
        'is_feature',
        'sku',
        'barcode',
        'quantity',
        'track_quantity',
        'status'
    ];
}
