<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for($i=0; $i<30; $i++)
        {
            Product::create([
                'titre' => $faker->sentence(5),
                'slug' => $faker->slug,
                'sousTitre' => $faker->sentence(5),
                'description' => $faker->text,
                'prix' => $faker->numberBetween(15, 300) * 100,
                'image' => 'https://via.placeholder.com/200x250'
            ])->categories()->attach([
                rand(1, 4),
                rand(1, 4)
            ]);
        }
    }
}
