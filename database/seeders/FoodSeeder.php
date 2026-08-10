<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $foods = [
            // Sarapan
            ['food_category_id' => 1, 'name' => 'Oatmeal',       'calories' => 150, 'description' => 'Oatmeal dengan susu rendah lemak',    'image' => 'oatmeal.jpg'],
            ['food_category_id' => 1, 'name' => 'Roti Gandum',   'calories' => 120, 'description' => 'Roti gandum dengan selai kacang',     'image' => 'Roti gandum.jpg'],
            ['food_category_id' => 1, 'name' => 'Telur Rebus',   'calories' => 80,  'description' => 'Telur rebus 2 butir',                 'image' => 'telurrebus.jpg'],
            ['food_category_id' => 1, 'name' => 'Smoothie Buah', 'calories' => 130, 'description' => 'Smoothie campuran buah segar',        'image' => 'smoothie.jpg'],

            // Makan Siang
            ['food_category_id' => 2, 'name' => 'Nasi + Ayam Panggang', 'calories' => 450, 'description' => 'Nasi putih dengan ayam panggang',  'image' => 'ayampanggang.jpg'],
            ['food_category_id' => 2, 'name' => 'Nasi + Ikan Bakar',    'calories' => 400, 'description' => 'Nasi dengan ikan bakar bumbu',      'image' => 'Ikan Bakar.jpg'],
            ['food_category_id' => 2, 'name' => 'Salad Ayam',           'calories' => 300, 'description' => 'Salad sayur dengan potongan ayam',  'image' => 'salad ayam.jpg'],
            ['food_category_id' => 2, 'name' => 'Nasi + Tempe',         'calories' => 380, 'description' => 'Nasi dengan tempe goreng',           'image' => 'Tempe goreng.jpg'],

            // Makan Malam
            ['food_category_id' => 3, 'name' => 'Salad Sayur',    'calories' => 150, 'description' => 'Salad sayuran segar',         'image' => 'salad sayur.jpg'],
            ['food_category_id' => 3, 'name' => 'Sup Ayam',       'calories' => 200, 'description' => 'Sup ayam dengan sayuran',     'image' => 'sayur sop.jpg'],
            ['food_category_id' => 3, 'name' => 'Tumis Kangkung', 'calories' => 120, 'description' => 'Kangkung tumis bawang putih', 'image' => 'kangkung.jpg'],
            ['food_category_id' => 3, 'name' => 'Nasi + Kentang', 'calories' => 420, 'description' => 'Nasi dengan kentang rebus'],

            // Snack
            ['food_category_id' => 4, 'name' => 'Pisang',        'calories' => 90,  'description' => 'Pisang segar'],
            ['food_category_id' => 4, 'name' => 'Yogurt',        'calories' => 100, 'description' => 'Yogurt plain rendah lemak'],
            ['food_category_id' => 4, 'name' => 'Kacang Almond', 'calories' => 160, 'description' => 'Kacang almond panggang'],
        ];

        foreach ($foods as $food) {
            Food::create($food);
        }
    }
}