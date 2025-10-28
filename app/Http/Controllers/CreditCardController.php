<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CreditCard;

class CreditCardController extends Controller
{
    /**
     * แสดงหน้าแก้ไขข้อมูลบัตร
     */
    public function edit()
    {
        $user = Auth::user();
        $creditCard = $user->creditCard; // ดึงข้อมูลบัตรจากความสัมพันธ์ 1:1

        return view('profile.credit-card', compact('user', 'creditCard'));
    }

    /**
     * อัปเดตหรือสร้างข้อมูลบัตรใหม่
     */
    public function update(Request $request)
    {
        $request->validate([
            'card_holder' => ['nullable', 'string', 'max:100'],
            'card_number' => ['nullable', 'string', 'max:20'],
            'expiry_date' => ['nullable', 'regex:/^\d{4}-(0[1-9]|1[0-2])$/'],
            'cvv'         => ['nullable', 'string', 'max:4'],
        ]);

        $user = Auth::user();

        try {
            // updateOrCreate() → ถ้ามีอยู่แล้วจะอัปเดต ถ้าไม่มีก็จะสร้างใหม่
            $user->creditCard()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'card_holder' => $request->card_holder,
                    'card_number' => $request->card_number,
                    // 'expiry_date' => $request->expiry_date,
                    'expiry_date' => $expiry_date,
                    'cvv'         => $request->cvv,
                ]
            );

            return redirect()->route('credit.edit')->with('status', 'credit-updated');

        } catch (\Exception $e) {
            // ป้องกันปัญหา decrypt ผิด format
            return back()->withErrors([
                'error' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูลบัตร: ' . $e->getMessage()
            ]);
        }
    }
}
