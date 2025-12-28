<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $names = ['cricket', 'hockey', 'carrom', 'football', 'gym', 'accessories'];
        foreach ($names as $name) {
            Category::firstOrCreate(
                ['name' => ucfirst($name)],
                ['slug' => Str::slug($name)]
            );
        }
    }
}
