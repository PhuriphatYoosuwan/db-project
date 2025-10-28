@extends('layouts.app')
@section('title', 'My Credit Card')

@section('content')
<div class="flex bg-gray-900 text-gray-100 min-h-screen">

  {{-- ✅ Sidebar --}}
  @include('layouts.sidebar')

  {{-- ✅ เนื้อหา Credit Card --}}
  <div class="flex-1 py-10 px-8">
    <div class="max-w-md mx-auto bg-gray-800 shadow-lg rounded-2xl p-8 text-gray-200">
      <h2 class="text-2xl font-semibold mb-6 flex items-center gap-2">
        💳 My Credit Card
      </h2>

      @if (session('status') === 'credit-updated')
        <div class="mb-4 bg-green-700/40 text-green-100 border border-green-600 px-4 py-2 rounded-lg">
          ✅ Credit card info updated successfully!
        </div>
      @endif

      <form method="POST" action="{{ route('credit.update') }}" class="space-y-4">
        @csrf
        @method('PATCH')

        <div>
          <label class="block text-sm text-gray-400">Name on Card</label>
          <input type="text" name="card_holder"
            value="{{ old('card_holder', $creditCard->card_holder ?? '') }}"
            class="w-full mt-1 p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring focus:ring-indigo-400/30">
        </div>

        <div>
          <label class="block text-sm text-gray-400">Card Number</label>
          <input type="text" name="card_number"
            value="{{ old('card_number', $creditCard->card_number ?? '') }}"
            class="w-full mt-1 p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring focus:ring-indigo-400/30">
        </div>

        <div>
          <label class="block text-sm text-gray-400 mb-1">Expiry Date</label>
          <div class="flex gap-2">
            <div class="w-1/2">
              <select name="expiry_month"
                class="w-full p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring focus:ring-indigo-400/30">
                <option value="">Month</option>
                @for ($m = 1; $m <= 12; $m++)
                  <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                    {{ (old('expiry_month', $creditCard->expiry_month ?? '') == str_pad($m, 2, '0', STR_PAD_LEFT)) ? 'selected' : '' }}>
                    {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                  </option>
                @endfor
              </select>
            </div>
            <div class="w-1/2">
              <select name="expiry_year"
                class="w-full p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring focus:ring-indigo-400/30">
                <option value="">Year</option>
                @for ($y = date('Y'); $y <= date('Y') + 10; $y++)
                  <option value="{{ $y }}"
                    {{ (old('expiry_year', $creditCard->expiry_year ?? '') == $y) ? 'selected' : '' }}>
                    {{ $y }}
                  </option>
                @endfor
              </select>
            </div>
          </div>
        </div>

        <div>
          <label class="block text-sm text-gray-400">CVV</label>
          <input type="password" name="cvv"
            value="{{ old('cvv', $creditCard->cvv ?? '') }}"
            class="w-full mt-1 p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring focus:ring-indigo-400/30">
        </div>

        <div class="flex justify-end pt-4">
          <button type="submit"
            class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg font-medium transition-all">
            💾 Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
