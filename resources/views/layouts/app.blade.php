<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Shopping')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#e3e3e5;}
    .topbar{background:#5f5f63;color:#fff;}
    .avatar {width:32px;height:32px;border-radius:50%;object-fit:cover;border:1px solid #ddd;}
    .brand{font-weight:800; font-size:20px;}
    .search-box input{border-radius:999px; padding-left:42px;}
    .search-box .icon{position:absolute; left:12px; top:50%; transform:translateY(-50%); opacity:.6;}
  </style>
</head>
<body>
  <div class="topbar py-3">
    <div class="container d-flex align-items-center justify-content-between gap-3">
      <a href="{{ route('dashboard') }}" class="brand text-white text-decoration-none">Shopping</a>


      {{-- Search (ยังไม่ทำงาน) --}}
      <div class="search-box position-relative flex-grow-1" style="max-width:640px;">
        <svg class="icon" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M21 20.3L16.8 16a7.5 7.5 0 10-1 1L20.3 21zM10.5 17a6.5 6.5 0 110-13 6.5 6.5 0 010 13z"/></svg>
        <input class="form-control" type="search" placeholder="Search products" aria-label="Search">
      </div>

      {{-- Right: Login / Profile + Logout --}}
      <div class="d-flex align-items-center gap-3">
        @guest
          <a class="btn btn-light btn-sm" href="{{ route('login') }}">Login</a>
        @else
          <a href="{{ route('profile.edit') }}" class="d-flex align-items-center text-white text-decoration-none">
            <img class="avatar me-2" src="{{ auth()->user()->avatar_url ?? asset('images/default-avatar.png') }}" alt="avatar">
            <span class="fw-semibold">{{ auth()->user()->name }}</span>
          </a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-light btn-sm" type="submit">Logout</button>
          </form>
        @endguest
      </div>
    </div>
  </div>

  <div class="container py-4">
    @yield('content')
  </div>
</body>
</html>
