<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;

// ✅ หน้าแรกให้พาไป Dashboard (หลัง Login)
Route::get('/', fn () => redirect()->route('dashboard'));

// 🔹 Guest Routes (สำหรับคนที่ยังไม่ได้ล็อกอิน)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// 🔹 Auth Routes (ต้องล็อกอินก่อนถึงจะเข้าได้)
Route::middleware('auth')->group(function () {

    // Dashboard หลัง Login
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // หน้าโปรไฟล์
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // ออกจากระบบ
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 🔹 หน้าร้านค้า / Categories / Products
    Route::get('/categories', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/category/{category:slug}', [ShopController::class, 'category'])->name('shop.category');
});
