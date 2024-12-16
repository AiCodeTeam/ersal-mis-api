<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
  use HasFactory, SoftDeletes;
  public function user()
    {
        return $this->belongsTo(User::class); // A customer belongs to a user
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }
    
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];
}
