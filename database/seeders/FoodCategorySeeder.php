<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FoodCategory;

class FoodCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Sarapan',    'description' => 'Menu untuk sarapan pagi'],
            ['name' => 'Makan Siang','description' => 'Menu untuk makan siang'],
            ['name' => 'Makan Malam','description' => 'Menu untuk makan malam'],
            ['name' => 'Snack',      'description' => 'Camilan sehat'],
        ];

        foreach ($categories as $category) {
            FoodCategory::create($category);
        }
    }
}