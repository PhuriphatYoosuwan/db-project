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

          <form method="POST" action="{{ url('/register') }}">
            @csrf

            <div class="mb-3">
              <label class="form-label text-white-50">Name</label>
              <input
                type="text"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}"
                placeholder="ชื่อที่จะแสดง"
                required
              >
              @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label class="form-label text-white-50">Email/Number</label>
              <input
                type="text"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                placeholder="อีเมล หรือ เบอร์โทร"
                required
              >
              @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
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

            <div class="mb-4">
              <label class="form-label text-white-50">Confirm password</label>
              <input type="password" name="password_confirmation" class="form-control" placeholder="ยืนยันรหัสผ่าน" required>
            </div>

            <button type="submit" class="btn btn-light w-100">confirm</button>
          </form>

          <div class="text-center mt-3">
            <a href="{{ url('/login') }}" class="text-white-50">มีบัญชีแล้ว? ไปหน้า Login</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</body>
</html>
