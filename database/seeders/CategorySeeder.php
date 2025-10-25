<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['name'=>'Bags','slug'=>'bags'],
            ['name'=>'Pets','slug'=>'pets'],
            ['name'=>'Shoes','slug'=>'shoes'],
            ['name'=>'Gaming gear','slug'=>'gaming-gear'],
            ['name'=>'Phone','slug'=>'phone'],
            ['name'=>'Tools','slug'=>'tools'],
            ['name'=>'Medicines','slug'=>'medicines'],
            ['name'=>'Shirts','slug'=>'shirts'],
            ['name'=>'Accessories','slug'=>'accessories'],
            ['name'=>'Furniture','slug'=>'furniture'],
            ['name'=>'Food & Drink','slug'=>'food-and-drink'],
            ['name'=>'Sports','slug'=>'sports'],
            ['name'=>'Camping','slug'=>'camping'],
            ['name'=>'Computer','slug'=>'computer'],
        ];

        foreach ($rows as $r) {
            Category::firstOrCreate(['slug'=>$r['slug']], $r);
        }
    }
}
