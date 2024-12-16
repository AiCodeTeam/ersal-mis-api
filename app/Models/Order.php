<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // 'user_id' is the foreign key in the orders table
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    
    protected $fillable = [
        'customer_id',
        'user_id',
        'product_id',
        'quantity',
        'date',
        'price_usa',
        'price_afn',
        'item_id'
    ];
}
