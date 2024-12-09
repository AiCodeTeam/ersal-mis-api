<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            CustomerSeeder::class,
            ItemSeeder::class,
            ExpenseCategorySeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ProductImageSeeder::class,
            ItemsAddonSeeder::class,
            ExpenseSeeder::class,
            OrderSeeder::class,
            ProductImageSeeder::class
        ]);
    }
}
