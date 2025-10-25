<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

   public function update(Request $request)
{
    $user = $request->user();

    $data = $request->validate([
        'name'   => ['required','string','max:255'],
        'email'  => ['required','email', Rule::unique('users','email')->ignore($user->id)],
        'phone'  => ['nullable','string','max:30'],
        'gender' => ['nullable','in:male,female,others'],
        'dob'    => ['nullable','date'],
        'avatar' => ['nullable','image','max:2048'],
    ]);

    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('avatars','public');
        $data['avatar_path'] = $path;
    }

    $user->update($data);

    // 👇 รีเฟรชอินสแตนซ์ใน session ให้ Navbar เห็นค่าล่าสุดทันที
    Auth::setUser($user->fresh());

    return back()->with('status','Profile updated.');
}
}