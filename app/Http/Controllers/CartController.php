<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * แสดงสินค้าทั้งหมดในตะกร้า
     */
    public function index()
    {
        $user = Auth::user();
        $cart = session()->get('cart', []); // [product_id => quantity]

        // ดึงข้อมูลสินค้าในตะกร้า
        $products = Product::whereIn('id', array_keys($cart))->get();

        // ดึงข้อมูล address และ credit card ของผู้ใช้
        $address = $user->address;
        $creditCard = $user->creditCard;

        return view('cart.index', compact('products', 'cart', 'address', 'creditCard'));
    }

    /**
     * เพิ่มสินค้าในตะกร้า
     */
    public function add(Request $request)
    {
        $productId = $request->product_id;
        $cart = session()->get('cart', []);
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

        return redirect()->back()->with('success', '🗑️ Product removed from cart!');
    }

    /**
     * ทำการ Checkout
     */
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cart = session()->get('cart', []);

        // ✅ ตรวจสอบว่าตะกร้าว่างไหม
        if (empty($cart)) {
            return redirect()->back()->with('error', '⚠️ Your cart is empty!');
        }

        // ดึงสินค้าทั้งหมดจากตะกร้า
        $products = Product::whereIn('id', array_keys($cart))->get();

        // ✅ คำนวณราคารวม
        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * $cart[$product->id];
        }

        // ✅ สร้าง Order ใหม่
        $order = Order::create([
            'user_id' => $user->id,
            'total'   => $total,
        ]);

        // ✅ เพิ่มรายการสินค้าใน OrderItem
        foreach ($products as $product) {
            OrderItem::create([
                'order_id'  => $order->id,
                'product_id'=> $product->id,
                'quantity'  => $cart[$product->id],
                'price'     => $product->price,
            ]);
        }

        // ✅ ล้าง session cart หลัง checkout เสร็จ
        session()->forget('cart');

        // ✅ เด้งกลับไปหน้า shop พร้อมข้อความสำเร็จ
        return redirect()->route('shop')->with('checkout_success', '✅ Checkout completed successfully!');
    }

    public function updateQuantity(Request $request)
    {
        $productId = $request->input('product_id');
        $action = $request->input('action');

        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return redirect()->back();
        }

        if ($action === 'increase') {
            $cart[$productId]++;
        } elseif ($action === 'decrease' && $cart[$productId] > 1) {
            $cart[$productId]--;
        }

        session(['cart' => $cart]);

        return redirect()->back();
    }

}
