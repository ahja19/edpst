<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@parfum.com'],
            [
                'name' => 'Admin Sara',
                'email' => 'admin@parfum.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Pembeli',
                'email' => 'user@example.com',
                'password' => Hash::make('user1234'),
                'role' => 'user',
            ]
        );

        $this->seedProducts();
    }

    private function seedProducts(): void
    {
        $products = [
            [
                'name' => 'Noir Élixir',
                'brand' => 'Sara Maison',
                'size' => '100 ml',
                'price' => 1850000,
                'stock' => 12,
                'description' => 'Aroma oriental yang dalam dan hangat dengan sentuhan kayu agarwood, amber, dan vanilla. Cocok untuk acara malam yang elegan.',
            ],
            [
                'name' => 'Blanc Lumière',
                'brand' => 'Sara Maison',
                'size' => '100 ml',
                'price' => 1750000,
                'stock' => 15,
                'description' => 'Parfum segar yang bersih dengan jeruk bergamot, accord laut, dan musk. Kesegaran yang menenangkan untuk aktivitas harian.',
            ],
            [
                'name' => 'Rose de Minuit',
                'brand' => 'Sara Maison',
                'size' => '50 ml',
                'price' => 1420000,
                'stock' => 10,
                'description' => 'Mawar damask yang diracik elegan dengan peony dan vanilla. Feminin, klasik, dan menggoda.',
            ],
            [
                'name' => 'Oud Royal',
                'brand' => 'Sara Maison',
                'size' => '100 ml',
                'price' => 2350000,
                'stock' => 8,
                'description' => 'Oud berkualitas tinggi yang dipadukan dengan rose Taif dan saffron. Keharuman yang mewah dan mendominasi.',
            ],
            [
                'name' => 'Aurora Mist',
                'brand' => 'Sara Maison',
                'size' => '75 ml',
                'price' => 1290000,
                'stock' => 20,
                'description' => 'Kesegaran air yang diremukkan dengan blue fog, lemon, dan musk ringan. Segar dan modern.',
            ],
            [
                'name' => 'Velvet Amber',
                'brand' => 'Maison Noir',
                'size' => '100 ml',
                'price' => 1550000,
                'stock' => 9,
                'description' => 'Amber hangat berlapis vanilla dan tonka bean. Wewangian yang nyaman dan membungkus.',
            ],
            [
                'name' => 'Solar Citrus',
                'brand' => 'Maison Noir',
                'size' => '50 ml',
                'price' => 980000,
                'stock' => 18,
                'description' => 'Jeruk sunny dan neroli yang cerah. Energi yang menyegarkan dan penuh optimisme.',
            ],
            [
                'name' => 'Midnight Noir',
                'brand' => 'Maison Noir',
                'size' => '100 ml',
                'price' => 2100000,
                'stock' => 7,
                'description' => 'Cendana dan leather yang gelap. Aroma yang berani, misterius, untuk malam yang tak terlupakan.',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($product['name'])],
                $product
            );
        }
    }
}