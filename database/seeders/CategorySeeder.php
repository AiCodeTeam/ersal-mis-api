<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Insert 50 product categories manually
        for ($i = 0; $i < 50; $i++) {
            Category::create([
                'name' => 'Category ' . ($i + 1),
            ]);
        }
    }
}
