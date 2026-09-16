<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Classic Burger',
            'sku' => 'TT-001',
            'description' => 'Classic Tasty Table burger',
            'category' => 'Food',
            'quantity' => 26,
            'reorder_level' => 5,
            'unit_price' => 250,
            'supplier' => 'Tasty Table Kitchen',
        ]);

        Product::create([
            'name' => 'Cheese Pizza',
            'sku' => 'TT-002',
            'description' => 'Pizza with cheese topping',
            'category' => 'Food',
            'quantity' => 8,
            'reorder_level' => 10,
            'unit_price' => 450,
            'supplier' => 'Tasty Table Kitchen',
        ]);

        Product::create([
            'name' => 'Italian Pasta',
            'sku' => 'TT-003',
            'description' => 'Italian-style pasta',
            'category' => 'Food',
            'quantity' => 18,
            'reorder_level' => 5,
            'unit_price' => 320,
            'supplier' => 'Tasty Table Kitchen',
        ]);

        Product::create([
            'name' => 'Chicken Meal',
            'sku' => 'TT-004',
            'description' => 'Complete chicken meal',
            'category' => 'Food',
            'quantity' => 5,
            'reorder_level' => 10,
            'unit_price' => 280,
            'supplier' => 'Tasty Table Kitchen',
        ]);

        Product::create([
            'name' => 'Iced Tea',
            'sku' => 'TT-005',
            'description' => 'Cold iced tea',
            'category' => 'Beverage',
            'quantity' => 41,
            'reorder_level' => 5,
            'unit_price' => 80,
            'supplier' => 'Tasty Table Drinks',
        ]);

        Product::create([
            'name' => 'Coffee',
            'sku' => 'TT-006',
            'description' => 'Hot brewed coffee',
            'category' => 'Beverage',
            'quantity' => 30,
            'reorder_level' => 5,
            'unit_price' => 120,
            'supplier' => 'Tasty Table Drinks',
        ]);

        Product::create([
            'name' => 'Soft Drink',
            'sku' => 'TT-007',
            'description' => 'Cold soft drink',
            'category' => 'Beverage',
            'quantity' => 12,
            'reorder_level' => 15,
            'unit_price' => 70,
            'supplier' => 'Tasty Table Drinks',
        ]);

        Product::create([
            'name' => 'French Fries',
            'sku' => 'TT-008',
            'description' => 'Crispy French fries',
            'category' => 'Side Dish',
            'quantity' => 20,
            'reorder_level' => 5,
            'unit_price' => 150,
            'supplier' => 'Tasty Table Kitchen',
        ]);

        Product::create([
            'name' => 'Chocolate Cake',
            'sku' => 'TT-009',
            'description' => 'Chocolate cake dessert',
            'category' => 'Dessert',
            'quantity' => 7,
            'reorder_level' => 10,
            'unit_price' => 180,
            'supplier' => 'Tasty Table Bakery',
        ]);

        Product::create([
            'name' => 'Ice Cream',
            'sku' => 'TT-010',
            'description' => 'Cold ice cream dessert',
            'category' => 'Dessert',
            'quantity' => 22,
            'reorder_level' => 5,
            'unit_price' => 130,
            'supplier' => 'Tasty Table Bakery',
        ]);
    }
}