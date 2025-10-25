<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register • Shopping</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#d9d9db;}
    .topbar{background:#6f6f73;color:#fff;}
    .brand-hero{min-height:70vh; display:flex; flex-direction:column; justify-content:center;}
    .brand-title{font-size:72px; font-weight:900; letter-spacing:1px;}
    .auth-card{background:#7f7f82; border:2px solid #4f4f52; border-radius:6px;}
    .auth-card h3{font-weight:800; color:#fff;}
    .form-control{border-radius:12px;}
  </style>
</head>
<body>
  <div class="topbar py-3">
    <div class="container d-flex justify-content-between">
      <div class="fw-bold">Shopping</div>
      <div class="fw-bold">Register</div>
    </div>
  </div>

  <div class="container py-5">
    <div class="row justify-content-center align-items-center g-5">
      <!-- Left hero -->
      <div class="col-lg-6 brand-hero text-center text-lg-start">
        <div class="brand-title">Shopping</div>
        <div class="text-muted">The best online marketplace</div>
      </div>

      <!-- Right form -->
      <div class="col-lg-4">
        <div class="auth-card p-4 shadow-sm">
          <h3 class="mb-4">Register</h3>

            <x-guest-layout>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" class="text-black" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" class="text-black" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" class="text-black" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" class="text-black" :value="__('Confirm Password')" />

                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mt-4">
                            <a class="text-sm underline text-black dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                                Already have an account?
                            </a>
                        <x-primary-button class="ms-4 bg-black">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </x-guest-layout>   
        </div>
      </div>

    </div>
  </div>
</body>
</html>