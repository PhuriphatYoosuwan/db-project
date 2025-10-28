<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * แสดงหน้า Address ของผู้ใช้
     */
    public function edit()
    {
        $user = Auth::user();
        $address = $user->address; // ดึงที่อยู่ของ user ถ้ามี

        return view('profile.address', compact('user', 'address'));
    }

    /**
     * อัปเดตหรือสร้างที่อยู่ใหม่
     */
    public function update(Request $request)
    {
        $request->validate([
            'province' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'sub_district' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'detail' => ['nullable', 'string', 'max:500'],
        ]);

        $user = Auth::user();

        // ถ้ามี address อยู่แล้ว → update
        // ถ้ายังไม่มี → create ใหม่
        $user->address()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'province' => $request->province,
                'district' => $request->district,
                'sub_district' => $request->sub_district,
                'postal_code' => $request->postal_code,
                'detail' => $request->detail,
            ]
        );

        return redirect()->route('address.edit')->with('status', 'address-updated');
    }
}
