<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Смартфоны', 'slug' => 'smartphones', 'icon' => '📱', 'description' => 'Современные смартфоны от ведущих производителей'],
            ['name' => 'Планшеты', 'slug' => 'tablets', 'icon' => '📋', 'description' => 'Планшеты для работы и развлечений'],
            ['name' => 'Наушники', 'slug' => 'headphones', 'icon' => '🎧', 'description' => 'Наушники и гарнитуры для музыки и звонков'],
            ['name' => 'Ноутбуки', 'slug' => 'laptops', 'icon' => '💻', 'description' => 'Ноутбуки для работы и игр'],
            ['name' => 'Колонки', 'slug' => 'speakers', 'icon' => '🔊', 'description' => 'Портативные и стационарные колонки'],
            ['name' => 'Аксессуары', 'slug' => 'accessories', 'icon' => '🔌', 'description' => 'Кабели, зарядки, чехлы и другие аксессуары'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}