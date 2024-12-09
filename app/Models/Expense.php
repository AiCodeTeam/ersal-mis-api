<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'details',
        'price',
        'date',
        'expense_categories_id',
        'user_id',
        'purchased_by',
    ];
}
