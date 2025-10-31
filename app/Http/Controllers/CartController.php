<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        return view('cart.index', compact('products', 'cart'));
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

        // ✅ Check stock availability before proceeding
        foreach ($products as $product) {
            $quantity = $cart[$product->id];

            if ($product->stock_quantity < $quantity) {
                return redirect()->back()->with('error', "⚠️ Product '{$product->name}' has insufficient stock ({$product->stock_quantity} left).");
            }
        }

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

            // Reduce stock_quantity safely
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

    public function createOrder(array $cart)
    {
        $user = Auth::user();

        if (empty($cart)) {
            throw new \Exception('Cart is empty.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get();

        foreach ($products as $product) {
            if ($product->stock_quantity < $cart[$product->id]) {
                throw new \Exception("Product '{$product->name}' has insufficient stock.");
            }
        }

        return DB::transaction(function () use ($user, $products, $cart) {
            $total = 0;
            foreach ($products as $product) {
                $total += $product->price * $cart[$product->id];
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total'   => $total,
            ]);

            foreach ($products as $product) {
                $quantity = $cart[$product->id];

                // สร้าง order item แต่ยังไม่ลด stock
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $quantity,
                    'price'      => $product->price,
                ]);
            }

            return $order;
        });
    }
    public function order(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', '⚠️ Your cart is empty!');
        }

        try {
            $order = DB::transaction(function () use ($cart) {
                return $this->createOrder($cart);
            });

            // ล้าง cart หลังสร้าง order เสร็จ
            // session()->forget('cart');

            // ✅ เปลี่ยน redirect ไปหน้า checkout.index
            return redirect()->route('checkout.index')->with('checkout_success', '✅ Order completed successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '⚠️ ' . $e->getMessage());
        }
    }

}
