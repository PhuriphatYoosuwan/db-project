<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CreditCard;

class CreditCardController extends Controller
{
     public function edit()
    {
        $user = Auth::user();
        $creditCard = $user->creditCard;
        return view('profile.credit-card', compact('user', 'creditCard'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'card_number' => ['nullable', 'string', 'max:20'],
            'expiry_date' => ['nullable', 'date'],
        ]);

        $user = Auth::user();

        $user->creditCard()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'card_number' => $request->card_number,
                'expiry_date' => $request->expiry_date,
            ]
        );

        return redirect()->route('credit.edit')->with('status', 'credit-updated');
    }
}
