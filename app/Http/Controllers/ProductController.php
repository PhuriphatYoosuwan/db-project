<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * แสดงสินค้าทั้งหมด
     * GET /products
     */
    public function index()
    {
        // ดึงข้อมูลสินค้าทั้งหมด พร้อมชื่อหมวดหมู่
        $products = Product::with('category')->latest()->get();

        return view('products.index', compact('products'));
    }

    /**
     * แสดงฟอร์มเพิ่มสินค้าใหม่ (เฉพาะ Admin)
     * GET /products/create
     */
    public function create()
    {
        // ดึงรายชื่อหมวดหมู่ทั้งหมดเพื่อใช้ใน dropdown
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    /**
     * บันทึกสินค้าใหม่ลงฐานข้อมูล
     * POST /products
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'price_cents' => 'required|numeric|min:1',
        'description' => 'nullable|string',
        'stock' => 'nullable|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        // จะเก็บไว้ใน storage/app/public/products
        $imagePath = $request->file('image')->store('products', 'public');
    }

    Product::create([
        'category_id' => $validated['category_id'],
        'name' => $validated['name'],
        'price_cents' => $validated['price_cents'],
        'description' => $validated['description'] ?? null,
        'stock' => $validated['stock'] ?? 0,
        'image_path' => $imagePath,
    ]);

    return redirect()->route('products.index')->with('success', 'เพิ่มสินค้าเรียบร้อยแล้ว!');
}

}
