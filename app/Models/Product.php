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
        return $this->belongsTo(Category::class, 'product_category_id '); // A product belongs to a product category
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class); // A product can have many images
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_product');
    }
    
    protected $fillable = [
        'name', 'price', 'product_category_id', 'quantity', 'description'
    ];

}

