<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * แสดงหน้าตรวจสอบ Order ล่าสุด
     */
    public function index()
    {
        $user = Auth::user();
        $address = $user->address;
        $creditCard = $user->creditCard;
        // ดึง Order ล่าสุดของผู้ใช้
        $latestOrder = Order::where('user_id', $user->id)
            ->latest()
            ->with('items.product') // โหลด relation order items + product
            ->first();

        if ($latestOrder) {
            $latestOrder->items = $latestOrder->items
                ->groupBy('product_id')
                ->map(function($items) {
                    $first = $items->first();
                    $first->quantity = $items->sum('quantity');
                    return $first;
                })->values();
        }

        return view('checkout.index', compact('latestOrder', 'address', 'creditCard'));
    }

    /**
     * ยืนยัน Checkout: ลด stock และ update status
     */
    public function checkout(Request $request, $orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);

        DB::transaction(function() use ($order) {
            foreach ($order->items as $item) {
                $item->product->decrement('stock_quantity', $item->quantity);
            }

            // เพิ่ม field status ใน table orders เช่น pending/completed
            $order->update(['status' => 'completed']);
        });

        session()->forget('cart');        

        return redirect()->route('shop')->with('checkout_success', '✅ Checkout completed and stock updated!');
    }
}
