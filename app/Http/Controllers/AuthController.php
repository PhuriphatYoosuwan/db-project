<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * แสดงหน้า Register
     * ถ้าล็อกอินอยู่แล้ว ให้พาไป /dashboard เพื่อกันลูป
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.register');
    }

    /**
     * สมัครสมาชิก + ล็อกอิน แล้วพาไป /dashboard
     */
    public function register(Request $r)
    {
        $data = $r->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $r->session()->regenerate();

        // ไปหน้า intended ถ้ามี (เช่น โดนกันด้วย auth middleware มาก่อน) มิฉะนั้นไป /dashboard
        return redirect()->intended('/dashboard');
    }

    /**
     * แสดงหน้า Login
     * ถ้าล็อกอินแล้ว พาไป /dashboard
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    /**
     * ล็อกอิน แล้วพาไป /dashboard
     */
    public function login(Request $r)
    {
        $cred = $r->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($cred, $r->boolean('remember'))) {
            $r->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()
            ->withErrors(['email' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง'])
            ->onlyInput('email');
    }

    /**
     * ออกจากระบบ แล้วพาไป /login
     */
    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect('/login');
    }
}
