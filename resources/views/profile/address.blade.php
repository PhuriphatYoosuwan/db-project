@extends('layouts.app')
@section('title', 'My Address')

@section('content')
<div class="py-10">
  <div class="max-w-3xl mx-auto bg-gray-800 shadow-lg rounded-2xl p-8 text-gray-200">
    
    <!-- Header -->
    <h2 class="text-2xl font-semibold mb-6 flex items-center gap-2">
      📍 My Address
    </h2>

    <!-- Success Message -->
    @if (session('status') === 'address-updated')
      <div class="mb-4 bg-green-700/40 text-green-100 border border-green-600 px-4 py-2 rounded-lg">
        ✅ Address updated successfully!
      </div>
    @endif

    <!-- Address Form -->
    <form method="POST" action="{{ route('address.update') }}" class="space-y-6">
      @csrf
      @method('PATCH')

      <!-- Grid: Province / District -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="province" class="block text-sm font-medium text-gray-400">Province</label>
          <input
            type="text"
            id="province"
            name="province"
            value="{{ old('province', $address->province ?? '') }}"
            class="mt-1 block w-full rounded-lg bg-gray-700 border border-gray-600 text-gray-100
                   focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
          >
        </div>

        <div>
          <label for="district" class="block text-sm font-medium text-gray-400">District</label>
          <input
            type="text"
            id="district"
            name="district"
            value="{{ old('district', $address->district ?? '') }}"
            class="mt-1 block w-full rounded-lg bg-gray-700 border border-gray-600 text-gray-100
                   focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
          >
        </div>
      </div>

      <!-- Grid: Sub District / Postal Code -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="sub_district" class="block text-sm font-medium text-gray-400">Sub District</label>
          <input
            type="text"
            id="sub_district"
            name="sub_district"
            value="{{ old('sub_district', $address->sub_district ?? '') }}"
            class="mt-1 block w-full rounded-lg bg-gray-700 border border-gray-600 text-gray-100
                   focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
          >
        </div>

        <div>
          <label for="postal_code" class="block text-sm font-medium text-gray-400">Postal Code</label>
          <input
            type="text"
            id="postal_code"
            name="postal_code"
            value="{{ old('postal_code', $address->postal_code ?? '') }}"
            class="mt-1 block w-full rounded-lg bg-gray-700 border border-gray-600 text-gray-100
                   focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
          >
        </div>
      </div>

      <!-- Detail -->
      <div>
        <label for="detail" class="block text-sm font-medium text-gray-400">Detail</label>
        <textarea
          id="detail"
          name="detail"
          rows="3"
          placeholder="รายละเอียดเพิ่มเติม (เช่น บ้านเลขที่, หมู่บ้าน, จุดสังเกต)"
          class="mt-1 block w-full rounded-lg bg-gray-700 border border-gray-600 text-gray-100
                 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 resize-none"
        >{{ old('detail', $address->detail ?? '') }}</textarea>
      </div>

      <!-- Save Button -->
      <div class="flex justify-end pt-4">
        <button
          type="submit"
          class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500
                 focus:ring-2 focus:ring-indigo-400 text-white rounded-lg font-medium
                 transition-all"
        >
          💾 Save Address
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
