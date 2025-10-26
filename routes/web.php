<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/photo/update', [UserController::class, 'updateProfilePhoto'])->name('profile.photo.update');
    Route::get('/profile/photo/{filename}', [UserController::class, 'showProfilePhoto'])
        ->where('filename', '.*')
        ->name('user.photo');
    Route::get('/address', [AddressController::class, 'edit'])->name('address.edit');
    Route::patch('/address', [AddressController::class, 'update'])->name('address.update');
    Route::get('/credit-card', [App\Http\Controllers\CreditCardController::class, 'edit'])->name('credit.edit');
    Route::patch('/credit-card', [App\Http\Controllers\CreditCardController::class, 'update'])->name('credit.update');
});

require __DIR__.'/auth.php';
