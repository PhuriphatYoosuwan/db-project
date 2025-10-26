<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function showByCategory($id)
    {
        $categories = Category::all();
        $category = Category::findOrFail($id); // ดึงตาม id
        $products = $category->products()->get();

        return view('category.index', compact('categories','category', 'products'));
    }

    // public function showCategory() {
    //     $categories = Category::all(); // ดึงข้อมูลหมวดหมู่ทั้งหมด
    //     return view('category.index', compact('categories'));
    // }
}
