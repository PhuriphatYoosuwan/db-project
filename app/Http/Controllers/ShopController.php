<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class ShopController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // ดึงข้อมูลหมวดหมู่ทั้งหมด
        return view('shop.index', compact('categories'));
    }
}
