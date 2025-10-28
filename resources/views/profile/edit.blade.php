<x-app-layout>
  <style>
    @media (max-width: 768px) {
      .profile-layout {
        flex-direction: column;
      }
      .sidebar {
        width: 100%;
        flex-direction: row;
        justify-content: space-around;
        border-right: none;
        border-bottom: 1px solid #444;
      }
    }
  </style>

  <div class="flex bg-gray-900 text-gray-100 min-h-screen">
    {{-- ✅ Sidebar --}}
    @include('layouts.sidebar')

    {{-- ✅ เนื้อหา Profile --}}
    <div class="flex-1 py-10 px-8">
      <div class="max-w-5xl mx-auto bg-gray-800 shadow-lg rounded-2xl p-8">
        <div class="flex flex-col md:flex-row gap-8">
          {{-- ข้อมูลโปรไฟล์ --}}
          <div class="flex-1">
            @include('profile.partials.update-profile-information-form')
          </div>

          {{-- รูปโปรไฟล์ --}}
          <div class="w-full md:w-1/3 flex justify-center">
            @include('profile.partials.update-profile-photo-form')
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
