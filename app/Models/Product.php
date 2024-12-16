<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category_id', 'id');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class); // A product can have many images
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_product', 'product_id', 'item_id');
    }
    
    protected $guarded = [];

}

