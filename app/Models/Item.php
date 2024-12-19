<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ItemsAddon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;
    Protected $appends = ['item_left','total_qty','total_value_in_usd','total_value_in_afg'];

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

    public function getTotalQtyAttribute()
    {
        return $this->itemAddons()->sum('quantity');
    }

    public function getTotalValueInUsdAttribute()
    {
        return $this->itemAddons()->sum('price_usd');
    }

    public function getTotalValueInAfgAttribute()
    {
        return $this->itemAddons()->sum('price_afg');
    }




    // protected $fillable = [
    //     'name',
    //     'description',
    //     'date',
    //     'item_image',
    // ];
    protected $guarded = [];
}
