<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'High Tech',
            'slug' => 'high-tech'
        ]);

        Category::create([
            'name' => 'Livres',
            'slug' => 'livres'
        ]);

        Category::create([
            'name' => 'Meubles',
            'slug' => 'meubles'
        ]);

        Category::create([
            'name' => 'Jeux',
            'slug' => 'jeux'
        ]);

        Category::create([
            'name' => 'Nourriture',
            'slug' => 'nourriture'
        ]);

    }
}
