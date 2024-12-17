<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Insert 50 orders manually
        for ($i = 0; $i < 50; $i++) {
            Order::create([
                'customer_id' => $faker->randomElement([1, 2, 3, null]), // Adjust based on existing IDs
                'user_id' => $faker->randomElement([1, 2, 3, null]), // Adjust based on existing IDs
                'product_id' => $faker->randomElement([1, 2, 3, null]), // Adjust based on existing IDs
                'quantity' => $faker->numberBetween(1, 100),
                'date' => $faker->date(),
                'price_usa' => $faker->randomFloat(2, 10, 500),
                'price_afn' => $faker->randomFloat(2, 100, 50000),
                'item_id' => $faker->numberBetween(1, 50), // Adjust based on existing item IDs
                'ref_no' => $faker->numberBetween(1, 100)
            ]);
        }
    }
}
