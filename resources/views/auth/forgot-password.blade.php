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
      <div class="fw-bold">Forget Your Password</div>
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
            <x-guest-layout>
                <div class="mb-4 text-sm text-black dark:text-gray-400">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" class="text-black" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="bg-black">
                            {{ __('Email Password Reset Link') }}
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