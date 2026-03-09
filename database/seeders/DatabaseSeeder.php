<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        // Create Admin
        Admin::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'nattawutkongyod@hotmail.com',
            'password' => Hash::make('password'),
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Head Sculpt', 'description' => 'Custom head sculpt models and figures'],
            ['name' => 'Part Kit', 'description' => 'Model part kits and components'],
            ['name' => 'Arttoy', 'description' => 'Designer art toys and collectibles'],
            ['name' => '3D Print', 'description' => '3D printed custom models and parts'],
            ['name' => 'Dot3dprinting', 'description' => 'Dot3dprinting collaboration products'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'],
                'is_active' => true,
            ]);
        }

        // Create Sample Products
        $products = [
            [
                'category_id' => 1,
                'name' => 'Garage Diorama Set',
                'description' => 'Complete garage diorama set in 1:64 scale. Includes detailed floor, walls, and tool accessories. Perfect for displaying your die-cast car collection.',
                'price' => 89.99,
                'stock' => 15,
                'is_featured' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Gas Station Diorama',
                'description' => 'Vintage style gas station diorama in 1:64 scale. Features fuel pumps, signage, and LED lighting option.',
                'price' => 129.99,
                'stock' => 10,
                'is_featured' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Car Showroom Diorama',
                'description' => 'Modern car showroom display in 1:64 scale. Glass panel design with display stands included.',
                'price' => 149.99,
                'stock' => 8,
                'is_featured' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Mini Parking Lot',
                'description' => 'Compact parking lot mini diorama. Fits 2-3 cars in 1:64 scale.',
                'price' => 39.99,
                'stock' => 25,
                'is_featured' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Mini Car Lift Set',
                'description' => 'Miniature car lift for your tiny garage scene. Realistic working mechanism.',
                'price' => 29.99,
                'stock' => 30,
                'is_featured' => false,
            ],
            [
                'category_id' => 3,
                'name' => 'Tool Cabinet Set',
                'description' => 'Detailed tool cabinets and work bench accessories. Set of 5 pieces.',
                'price' => 19.99,
                'stock' => 50,
                'is_featured' => false,
            ],
            [
                'category_id' => 3,
                'name' => 'Traffic Signs Pack',
                'description' => 'Pack of 10 miniature traffic signs and road accessories.',
                'price' => 14.99,
                'stock' => 40,
                'is_featured' => false,
            ],
            [
                'category_id' => 3,
                'name' => 'LED Light Kit',
                'description' => 'USB powered LED light kit for illuminating your dioramas.',
                'price' => 24.99,
                'stock' => 35,
                'is_featured' => true,
            ],
            [
                'category_id' => 4,
                'name' => 'Mechanic Figure Set',
                'description' => 'Set of 4 mechanic figures in various poses. Hand-painted details.',
                'price' => 34.99,
                'stock' => 20,
                'is_featured' => true,
            ],
            [
                'category_id' => 4,
                'name' => 'Car Enthusiasts Pack',
                'description' => 'Pack of 6 car enthusiast figures. Perfect for car meet scenes.',
                'price' => 44.99,
                'stock' => 18,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $prod) {
            Product::create([
                'category_id' => $prod['category_id'],
                'name' => $prod['name'],
                'slug' => Str::slug($prod['name']) . '-' . uniqid(),
                'description' => $prod['description'],
                'price' => $prod['price'],
                'stock' => $prod['stock'],
                'images' => [],
                'is_active' => true,
                'is_featured' => $prod['is_featured'],
            ]);
        }
    }
}
