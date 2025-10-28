<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

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

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        $products = Product::whereIn('id', array_keys($cart))->get();

        // คำนวณรวม
        $total = 0;
        foreach($products as $product){
            $total += $product->price * $cart[$product->id];
        }

        // สร้าง order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
        ]);

        // สร้าง order items
        foreach($products as $product){
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $cart[$product->id],
                'price' => $product->price,
            ]);
        }

        // ล้าง cart
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Checkout completed!');
    }
}
