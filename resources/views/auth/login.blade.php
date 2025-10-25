<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login • Shopping</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#d9d9db;}
    .topbar{background:#6f6f73;color:#fff;}
    .brand-hero{min-height:70vh; display:flex; flex-direction:column; justify-content:center;}
    .brand-title{font-size:72px; font-weight:900; letter-spacing:1px;}
    .brand-sub{font-size:20px; color:#333; opacity:.9;}
    .auth-card{background:#7f7f82; border:2px solid #4f4f52; border-radius:6px;}
    .auth-card h3{font-weight:800; color:#fff;}
    .divider{display:flex; align-items:center; gap:.75rem; color:#eaeaea;}
    .divider::before,.divider::after{content:""; height:1px; background:#eaeaea; flex:1;}
    .form-control{border-radius:12px;}
    a, a:visited{color:#eaf2ff;}
  </style>
</head>
<body>
  <div class="topbar py-3">
    <div class="container d-flex justify-content-between">
      <div class="fw-bold">Shopping</div>
      <div class="fw-bold">Login</div>
    </div>
  </div>

  <div class="container py-5">
    <div class="row justify-content-center align-items-center g-5">
      <!-- Left hero -->
      <div class="col-lg-6 brand-hero text-center text-lg-start">
        <div class="brand-title">Shopping</div>
        <div class="brand-sub">The best online marketplace</div>
      </div>

      <!-- Right form -->
      <div class="col-lg-4">
        <div class="auth-card p-4 shadow-sm">
          <h3 class="mb-4">Login</h3>
          <x-guest-layout>
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" class="text-black" :value="__('Email')" />
                        <x-text-input id="email" class="block text-white mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" class="text-black" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4 flex justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                            <span class="ms-2 text-sm text-black dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>
                        
                        <!-- @if (Route::has('password.request'))
                            <a class="flex justify-end underline text-sm text-black dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif   -->
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center">
                            <a class="text-sm text-black dark:text-gray-400"> 
                                Don't have an account? 
                            </a>
                            <a
                                href="{{ route('register') }}"
                                class="ms-1 underline text-sm text-black dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                Register
                            </a>
                        </div>
                        <x-primary-button class="flex jestify-end ms-3 bg-black">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form> 
            </x-guest-layout> 
        </div>
    </div>
</body>
</html>