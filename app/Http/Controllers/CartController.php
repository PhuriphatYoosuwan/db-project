<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // แสดงสินค้าทั้งหมดใน cart
    public function index()
    {
        $cart = session()->get('cart', []); // [product_id => quantity]

        // ดึงข้อมูล product จาก DB
        $products = Product::whereIn('id', array_keys($cart))->get();

        return view('cart.index', compact('products', 'cart'));
    }

    // เพิ่มสินค้า
    public function add(Request $request)
    {
        $productId = $request->product_id;
        $cart = session()->get('cart', []);
        $cart[$productId] = ($cart[$productId] ?? 0) + 1;
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    // ลบสินค้า
    public function remove(Request $request)
    {
        $productId = $request->product_id;
        $cart = session()->get('cart', []);
        if(isset($cart[$productId])){
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Product removed from cart!');
    }
}
