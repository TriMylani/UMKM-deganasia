<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Puding',
                'description' => 'Produk puding berbahan kelapa dengan rasa segar.',
                'is_active' => true,
            ],
            [
                'name' => 'Minuman',
                'description' => 'Minuman segar untuk menemani aktivitas sehari-hari.',
                'is_active' => true,
            ],
            [
                'name' => 'Salad',
                'description' => 'Salad buah segar dengan pilihan buah berkualitas.',
                'is_active' => true,
            ],
            [
                'name' => 'Buah Potong',
                'description' => 'Potongan buah segar dan siap dinikmati.',
                'is_active' => true,
            ],
            [
                'name' => 'Makanan',
                'description' => 'Produk makanan siap santap dari Deganasia.',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}