<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        User::firstOrCreate(
            ['email' => 'testuser@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create sample products
        $products = [
            [
                'name' => 'Laptop Gaming ASUS ROG',
                'description' => 'Laptop gaming powerful dengan RTX 4060, RAM 16GB, dan layar 144Hz untuk pengalaman gaming terbaik.',
                'price' => 15000000,
                'stock' => 10,
            ],
            [
                'name' => 'Smartphone Samsung Galaxy S24',
                'description' => 'Smartphone flagship dengan kamera 200MP, layar AMOLED 120Hz, dan prosesor Snapdragon terbaru.',
                'price' => 12000000,
                'stock' => 25,
            ],
            [
                'name' => 'Headphone Sony WH-1000XM5',
                'description' => 'Headphone wireless dengan noise cancellation terbaik di kelasnya dan kualitas audio premium.',
                'price' => 4500000,
                'stock' => 15,
            ],
            [
                'name' => 'Keyboard Mechanical Logitech',
                'description' => 'Keyboard mechanical RGB dengan switch tactile untuk typing dan gaming yang nyaman.',
                'price' => 1200000,
                'stock' => 30,
            ],
            [
                'name' => 'Mouse Gaming Razer',
                'description' => 'Mouse gaming wireless dengan sensor 30000 DPI dan battery life hingga 100 jam.',
                'price' => 850000,
                'stock' => 20,
            ],
            [
                'name' => 'Monitor LG UltraWide 34"',
                'description' => 'Monitor ultrawide 34 inch dengan resolusi QHD dan refresh rate 144Hz untuk produktivitas maksimal.',
                'price' => 6500000,
                'stock' => 8,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
