<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            ['Cricket Bat', 'cricket', 49.99, 20],
            ['Cricket Ball', 'cricket', 9.99, 50],
            ['Hockey Stick', 'hockey', 39.99, 15],
            ['Hockey Puck', 'hockey', 5.99, 60],
            ['Carrom Board', 'carrom', 59.99, 10],
            ['Carrom Coins', 'carrom', 7.99, 80],
            ['Football', 'football', 19.99, 40],
            ['Football Shoes', 'football', 69.99, 25],
            ['Dumbbell Set', 'gym', 89.99, 12],
            ['Yoga Mat', 'gym', 14.99, 70],
            ['Water Bottle', 'accessories', 12.99, 100],
            ['Sports Bag', 'accessories', 29.99, 30],
        ];

        foreach ($samples as [$name, $catSlug, $price, $stock]) {
            $category = Category::where('slug', $catSlug)->first();
            if (!$category) {
                $category = Category::create(['name' => ucfirst($catSlug), 'slug' => $catSlug]);
            }
            Product::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'category_id' => $category->id,
                    'price' => $price,
                    'stock' => $stock,
                    'description' => $name . ' description',
                    'image' => '/demo-images/placeholder.svg',
                ]
            );
        }
    }
}
