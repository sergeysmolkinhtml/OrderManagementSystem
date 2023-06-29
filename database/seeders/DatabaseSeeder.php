<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*User::factory(10)->create();

        $this->call([
            CountriesSeeder::class,
        ]);*/

        Product::factory(10)->create()->each(function ($product) {
            $product->categories()
                ->saveMany(Category::factory(mt_rand(1, 2))->make());
        });
    }
}
