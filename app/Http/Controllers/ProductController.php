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

    public function show($id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);
        $reviews = $product->reviews()->with('user')->latest()->get();

        // คำนวณคะแนนเฉลี่ย
        $averageRating = $reviews->avg('rating'); // จะได้ค่า 1-5 หรือ null ถ้าไม่มีรีวิว

        return view('product.index', compact('categories','product','reviews','averageRating'));
    }
}
