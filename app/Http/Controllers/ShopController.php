<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class ShopController extends Controller
{
    // /categories (แสดงหมวดทั้งหมด + สินค้าทั้งหมด หรือหมวดแรก)
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        $active = $categories->first(); // ยังไม่เลือก ก็โชว์หมวดแรก
        $products = $active
            ? $active->products()->latest('id')->paginate(12)
            : Product::latest('id')->paginate(12);

        return view('shop.index', compact('categories','active','products'));
    }

    // /category/{slug}
    public function category(Category $category)
    {
        $categories = Category::orderBy('name')->get();
        $active = $category;
        $products = $category->products()->latest('id')->paginate(12);

        return view('shop.index', compact('categories','active','products'));
    }
}
