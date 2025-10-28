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
        $product = Product::findOrFail($id); // ดึงตาม id

        return view('product.index', compact('categories','product'));
    }
}
