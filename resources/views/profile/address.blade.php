@extends('layouts.app')
@section('title', 'My Address')

@section('content')
<div class="flex bg-gray-900 text-gray-100 min-h-screen">

  {{-- ✅ Sidebar --}}
  @include('layouts.sidebar')

  {{-- ✅ เนื้อหา Address --}}
  <div class="flex-1 py-10 px-8">
    <div class="max-w-3xl mx-auto bg-gray-800 shadow-lg rounded-2xl p-8 text-gray-200">
      <h2 class="text-2xl font-semibold mb-6 flex items-center gap-2">
        📍 My Address
      </h2>

      @if (session('status') === 'address-updated')
        <div class="mb-4 bg-green-700/40 text-green-100 border border-green-600 px-4 py-2 rounded-lg">
          ✅ Address updated successfully!
        </div>
      @endif

      <form method="POST" action="{{ route('address.update') }}" class="space-y-6">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm text-gray-400">Province</label>
            <input type="text" name="province" value="{{ old('province', $address->province ?? '') }}"
              class="w-full mt-1 p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring focus:ring-indigo-400/30">
          </div>
          <div>
            <label class="block text-sm text-gray-400">District</label>
            <input type="text" name="district" value="{{ old('district', $address->district ?? '') }}"
              class="w-full mt-1 p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring focus:ring-indigo-400/30">
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm text-gray-400">Sub District</label>
            <input type="text" name="sub_district" value="{{ old('sub_district', $address->sub_district ?? '') }}"
              class="w-full mt-1 p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring focus:ring-indigo-400/30">
          </div>
          <div>
            <label class="block text-sm text-gray-400">Postal Code</label>
            <input type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}"
              class="w-full mt-1 p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring focus:ring-indigo-400/30">
          </div>
        </div>

        <div>
          <label class="block text-sm text-gray-400">Detail</label>
          <textarea name="detail" rows="3"
            class="w-full mt-1 p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 resize-none focus:ring focus:ring-indigo-400/30"
            placeholder="รายละเอียดเพิ่มเติม (เช่น บ้านเลขที่, หมู่บ้าน, จุดสังเกต)">{{ old('detail', $address->detail ?? '') }}</textarea>
        </div>

        <div class="flex justify-end pt-4">
          <button type="submit"
            class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg font-medium transition-all">
            💾 Save Address
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
