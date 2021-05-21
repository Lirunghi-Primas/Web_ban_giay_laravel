<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 30; $i++) {
            Product::create([
                'title' => $faker->name(),
                'slug' => $faker->unique()->slug,
                'price' => $faker->numberBetween($min = 500000, $max = 5000000),
                'category_id' => Category::inRandomOrder()->first()->id,
                'description' => $faker->paragraph($nb = 3),
                'thumbnail_path' => null,
            ]);
        }

        Product::first()->update([
            'is_pinned' => 1
        ]);
    }
}
