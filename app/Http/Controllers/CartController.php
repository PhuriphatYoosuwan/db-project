<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address; // ✅ เพิ่มเพื่อดึงที่อยู่ผู้ใช้
use App\Models\CreditCard;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * แสดงสินค้าทั้งหมดในตะกร้า
     */
    public function index()
    {
        $cart = session()->get('cart', []); // [product_id => quantity]
        $products = Product::whereIn('id', array_keys($cart))->get();

        // ✅ ดึงที่อยู่ของผู้ใช้ (ถ้ามี)
        $address = null;
        if (Auth::check()) {
            $address = Address::where('user_id', Auth::id())->first();
        }

        $creditCard = CreditCard::where('user_id', Auth::id())->first();

        return view('cart.index', compact('products', 'cart', 'address','creditCard'));
    }

    /**
     * เพิ่มสินค้าในตะกร้า
     */
    public function add(Request $request)
    {
        $productId = $request->product_id;
        $cart = session()->get('cart', []);

        // ถ้ามีอยู่แล้วให้ +1
        $cart[$productId] = ($cart[$productId] ?? 0) + 1;
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', '✅ Product added to cart!');
    }

    /**
     * ลบสินค้าออกจากตะกร้า
     */
    public function remove(Request $request)
    {
        $productId = $request->product_id;
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', '🗑 Product removed from cart!');
    }

    /**
     * Checkout - สร้าง Order และ OrderItem
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', '⚠️ Your cart is empty!');
        }

        $products = Product::whereIn('id', array_keys($cart))->get();

        // ✅ คำนวณราคารวม
        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * $cart[$product->id];
        }

        // ✅ สร้าง Order ใหม่
        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'subtotal' => $total,
            'shipping' => 50,
            'total' => $total + 50,
            'payment_method' => 'cod',
            'address' => optional(Address::where('user_id', Auth::id())->first())->full_address ?? 'No address provided',
        ]);

        // ✅ สร้าง OrderItem สำหรับแต่ละสินค้า
        foreach ($products as $product) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $cart[$product->id],
                'price' => $product->price,
            ]);
        }

        // ✅ ล้าง cart หลัง checkout เสร็จ
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', '🎉 Checkout completed successfully!');
    }
}
