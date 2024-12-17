<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ItemsAddon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'item_product', 'item_id', 'product_id');
    }

    public function itemAddons()
    {
        return $this->hasMany(ItemsAddon::class, 'item_id', 'id');
    }
    public function getItemLeftAttribute()
    {
        $totalAddonQuantity = $this->itemAddons()->sum('quantity');
        $totalProductCount = $this->products()->count();
        return $totalAddonQuantity - $totalProductCount;
    }



    protected $fillable = [
        'name',
        'description',
        'date',
        'item_image',
        'bill_image'
    ];
}
