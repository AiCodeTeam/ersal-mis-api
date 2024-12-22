<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseCategory extends Model
{
    use HasFactory, SoftDeletes;

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_categories_id', 'id');
    }
    
    protected $fillable = [
        'name',
        'description',
    ];
}
