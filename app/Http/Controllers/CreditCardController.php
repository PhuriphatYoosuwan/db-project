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
            'card_holder'   => ['nullable', 'string', 'max:100'],
            'card_number'   => ['nullable', 'digits_between:13,19'],
            'expiry_month'  => ['nullable', 'integer', 'min:1', 'max:12'],
            'expiry_year'   => ['nullable', 'integer', 'min:' . date('Y')],
            'cvv'           => ['nullable', 'digits_between:3,4'],
        ]);

        $user = Auth::user();

        // ✅ รวม month + year เป็น expiry_date
        $expiry_date = null;
        if ($request->filled(['expiry_month', 'expiry_year'])) {
            $expiry_date = sprintf('%04d-%02d', $request->expiry_year, $request->expiry_month);
        }

        try {
            dd($request->all());
            $user->creditCard()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'card_holder' => $request->card_holder,
                    'card_number' => $request->card_number,
                    'expiry_date' => $expiry_date,
                    'cvv'         => $request->cvv,
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
