<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Profile') }}
    </h2>
  </x-slot>

  <style>
    .profile-wrapper {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: flex-start;
      gap: 3rem;
      flex-wrap: wrap;
    }

    .profile-form {
      flex: 1 1 60%;
      min-width: 320px;
    }

    .profile-photo {
      flex: 1 1 35%;
      min-width: 250px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    @media (max-width: 768px) {
      .profile-wrapper {
        flex-direction: column;
        align-items: center;
      }
      .profile-photo {
        margin-top: 2rem;
      }
    }
  </style>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <div class="p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="profile-wrapper">
          <div class="profile-form">
            @include('profile.partials.update-profile-information-form')
          </div>

          <div class="profile-photo">
            @include('profile.partials.update-profile-photo-form')
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
