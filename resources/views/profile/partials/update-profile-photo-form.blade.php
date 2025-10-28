<section>
  <style>
    .photo-card {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem;
      text-align: center;
    }

    .photo-card img {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #64748b;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
    }

    .photo-card input[type="file"] {
      text-align: center;
    }

    .photo-card .btn-save {
      background-color: #2563eb;
      color: white;
      border: none;
      padding: 6px 20px;
      border-radius: 6px;
      transition: background 0.2s ease-in-out;
    }

    .photo-card .btn-save:hover {
      background-color: #1d4ed8;
    }
  </style>

  <div class="photo-card">
    @if ($user->profile_photo)
      <div>
        <img src="{{ route('user.photo', ['filename' => $user->profile_photo]) }}" alt="Profile Photo">
      </div>
    @else
      <img src="{{ asset('images/default-avatar.png') }}" alt="No Photo">
    @endif

    <form method="post" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data">
      @csrf
      @method('PATCH')

      <div>
        <x-input-label for="profile_photo" :value="__('Profile Photo')" />
        <input type="file" name="profile_photo" id="profile_photo" class="block w-full text-center" />
        <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
      </div>

      <div class="mt-4">
        <button type="submit" class="btn-save">Save</button>
      </div>

      @if (session('status') === 'profile-photo-updated')
        <p class="text-sm text-green-500 mt-2">Saved ✅</p>
      @endif
    </form>
  </div>
</section>
