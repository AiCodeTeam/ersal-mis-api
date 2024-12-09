<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            Expense::create([
                'details' => 'Expense Details ' . $i,
                'price' => rand(100, 5000),
                'date' => now()->subDays(rand(0, 365))->format('Y-m-d'),
                'expense_categories_id' => rand(1, 10),
                'user_id' => rand(1, 10),
                'purchased_by' => 'User ' . rand(1, 10),
            ]);
        }
    }
   
}
