<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CreditCard;
use App\Models\Order;

class CreditCardController extends Controller
{
    /**
     * แสดงหน้าแก้ไขข้อมูลบัตร
     */
    public function edit()
    {
        $user = Auth::user();
        $creditCard = $user->creditCard; // ดึงข้อมูลบัตรจากความสัมพันธ์ 1:1

        $orders = Order::with(['items.product'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();


        return view('profile.credit-card', compact('user', 'creditCard'),compact('user', 'orders'));
    }

    /**
     * อัปเดตหรือสร้างข้อมูลบัตรใหม่
     */
    public function update(Request $request)
    {
        $request->validate([
            'card_holder' => ['nullable', 'string', 'max:100'],
            'card_number' => ['nullable', 'string', 'max:20'],
            'expiry_month' => ['nullable', 'digits:2'],
            'expiry_year' => ['nullable', 'digits:4'],
            'cvv' => ['nullable', 'string', 'max:4'],
        ]);

        $user = Auth::user();

        // ✅ สร้าง expiry_date จาก month + year
        $expiry_date = null;
        if ($request->filled('expiry_month') && $request->filled('expiry_year')) {
            $expiry_date = $request->expiry_year . '-' . str_pad($request->expiry_month, 2, '0', STR_PAD_LEFT);
        }

        try {
            $user->creditCard()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'card_holder' => $request->card_holder,
                    'card_number' => $request->card_number,
                    'expiry_date' => $expiry_date,
                    'cvv' => $request->cvv,
                ]
            );

            return redirect()->route('credit.edit')->with('status', 'credit-updated');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูลบัตร: ' . $e->getMessage()
            ]);
        }
    }
}
