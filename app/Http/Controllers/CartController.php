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
     * Checkout the cart
     */
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cart = session()->get('cart', []);

        // ✅ Check if cart is empty
        if (empty($cart)) {
            return redirect()->back()->with('error', '⚠️ Your cart is empty!');
        }

        // Fetch products in cart
        $products = Product::whereIn('id', array_keys($cart))->get();

        // ✅ Calculate total price
        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * $cart[$product->id];
        }

        // ✅ Create a new order
        $order = Order::create([
            'user_id' => $user->id,
            'total'   => $total,
        ]);

        // ✅ Add order items and reduce stock_quantity
        foreach ($products as $product) {
            $quantity = $cart[$product->id];

            // Create OrderItem
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'price'      => $product->price,
            ]);

            // Reduce stock_quantity
            $product->decrement('stock_quantity', $quantity);
        }

        // ✅ Clear the cart session
        session()->forget('cart');

        // ✅ Redirect to shop with success message
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
