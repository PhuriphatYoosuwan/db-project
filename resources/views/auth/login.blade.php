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

          <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="mb-3">
              <label class="form-label text-white-50">Email/Number</label>
              <input
                type="text"
                name="email" {{-- ใช้ชื่อ email ให้เข้ากับ Auth::attempt เดิม --}}
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                placeholder="อีเมล หรือ เบอร์โทร"
                required
              >
              @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-2">
              <label class="form-label text-white-50">Password</label>
              <input
                type="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="รหัสผ่าน"
                required
              >
              @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label text-white-50" for="remember">จำฉันไว้</label>
              </div>
              <a href="{{ url('/password/reset') }}" class="small">Forgot password?</a>
            </div>

            <button type="submit" class="btn btn-light w-100">login</button>
          </form>

          <div class="my-3 divider"><span>or</span></div>

          <a href="{{ url('/register') }}" class="btn btn-outline-light w-100">Register</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
