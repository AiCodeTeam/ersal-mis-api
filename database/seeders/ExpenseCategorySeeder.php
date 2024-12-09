<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            ExpenseCategory::create([
                'name' => 'Category ' . $i,
                'description' => 'Description for category ' . $i,
            ]);
        }
    }
}
