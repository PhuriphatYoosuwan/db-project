@extends('layouts.app')

@section('title','My Information')

@section('content')
<div class="card mx-auto" style="max-width:900px;">
  <div class="card-body">
    <h3 class="mb-4">My Information</h3>

    @if (session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="row g-4">
      @csrf

      <div class="col-md-8">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',$user->name) }}" required>
          @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">E-mail</label>
          <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email',$user->email) }}" required>
          @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Number</label>
          <input class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone',$user->phone) }}">
          @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
          <label class="form-label d-block">Gender</label>
          @php $g = old('gender',$user->gender); @endphp
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" value="male"   id="g1" @checked($g==='male')>
            <label class="form-check-label" for="g1">male</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" value="female" id="g2" @checked($g==='female')>
            <label class="form-check-label" for="g2">female</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" value="others" id="g3" @checked($g==='others')>
            <label class="form-check-label" for="g3">Others</label>
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label">Date of Birth</label>
          <input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob', $user->dob ? $user->dob->toDateString() : '') }}">
          @error('dob') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-dark">save</button>
      </div>

      <div class="col-md-4 text-center">
        <img class="rounded-circle mb-3" style="width:160px;height:160px;object-fit:cover;border:2px solid #ddd;"
             src="{{ $user->avatar_url ?? ($user->avatar_path ? asset('storage/'.$user->avatar_path) : asset('images/default-avatar.png')) }}"
             alt="avatar">
        <div>
          <label class="form-label">Select Image</label>
          <input class="form-control" type="file" name="avatar" accept="image/*">
          @error('avatar') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
