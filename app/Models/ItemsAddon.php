<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemsAddon extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'items_addon';
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    protected $fillable = [
        'item_id',
        'description',
        'price_usd',
        'price_afg',
        'quantity',
        'date',
    ];
}
