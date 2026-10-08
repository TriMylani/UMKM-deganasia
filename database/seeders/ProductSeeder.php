<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        $products = [
            [
                'category_id' => $categories['Puding'],
                'name' => 'Kelapa Puding',
                'description' => 'Puding kelapa segar dengan tekstur lembut dan rasa yang menyegarkan.',
                'price' => 10000,
                'stock' => 60,
                'image' => 'kelapa_puding.png',
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'Kecil',
                        'price' => 10000,
                        'stock' => 20,
                    ],
                    [
                        'name' => 'Sedang',
                        'price' => 13000,
                        'stock' => 20,
                    ],
                    [
                        'name' => 'Besar',
                        'price' => 15000,
                        'stock' => 20,
                    ],
                ],
            ],

            [
                'category_id' => $categories['Minuman'],
                'name' => 'Infused Water',
                'description' => 'Minuman segar dengan perpaduan buah pilihan yang menyegarkan.',
                'price' => 10000,
                'stock' => 100,
                'image' => 'infused_water.png',
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'Strawberry',
                        'price' => 10000,
                        'stock' => 25,
                    ],
                    [
                        'name' => 'Jeruk Sunkis',
                        'price' => 10000,
                        'stock' => 25,
                    ],
                    [
                        'name' => 'Lemon',
                        'price' => 10000,
                        'stock' => 25,
                    ],
                    [
                        'name' => 'Jeruk Nipis',
                        'price' => 10000,
                        'stock' => 25,
                    ],
                ],
            ],

            [
                'category_id' => $categories['Salad'],
                'name' => 'Salad Buah',
                'description' => 'Salad buah segar dengan berbagai pilihan buah berkualitas.',
                'price' => 10000,
                'stock' => 20,
                'image' => 'salad.png',
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'Regular',
                        'price' => 10000,
                        'stock' => 20,
                    ],
                ],
            ],

            [
                'category_id' => $categories['Buah Potong'],
                'name' => 'Buah Potong',
                'description' => 'Potongan buah segar dan praktis untuk dinikmati kapan saja.',
                'price' => 5000,
                'stock' => 20,
                'image' => 'buah_potong.png',
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'Regular',
                        'price' => 5000,
                        'stock' => 20,
                    ],
                ],
            ],

            [
                'category_id' => $categories['Makanan'],
                'name' => 'Bakso',
                'description' => 'Bakso lezat yang tersedia melalui sistem preorder.',
                'price' => 17000,
                'stock' => 80,
                'image' => 'bakso.png',
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'Sapi Biasa',
                        'price' => 18000,
                        'stock' => 20,
                    ],
                    [
                        'name' => 'Sapi Urat',
                        'price' => 20000,
                        'stock' => 20,
                    ],
                    [
                        'name' => 'Ayam Biasa',
                        'price' => 17000,
                        'stock' => 20,
                    ],
                    [
                        'name' => 'Ayam Urat',
                        'price' => 19000,
                        'stock' => 20,
                    ],
                ],
            ],

            [
                'category_id' => $categories['Minuman'],
                'name' => 'Kelapa Biasa',
                'description' => 'Kelapa segar yang praktis dan menyegarkan.',
                'price' => 5000,
                'stock' => 20,
                'image' => 'kelapa_biasa.png',
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'Regular',
                        'price' => 5000,
                        'stock' => 20,
                    ],
                ],
            ],
        ];

        foreach ($products as $productData) {
            $variants = $productData['variants'];

            unset($productData['variants']);

            $product = Product::create($productData);

            foreach ($variants as $variant) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => $variant['name'],
                    'price' => $variant['price'],
                    'stock' => $variant['stock'],
                    'is_available' => $variant['stock'] > 0,
                ]);
            }
        }
    }
}
