<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 20; $i++) {
            $name = $faker->words(2, true); 
            
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'image' => "hykyukyk.jpg", // يولد صورة وهمية ويحفظها
            ]);
        }
    }
}
