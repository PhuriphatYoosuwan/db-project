@extends('layouts.app')
@section('title', 'My Credit Card')

@section('content')
<div class="py-10">
    <div class="max-w-md mx-auto bg-gray-800 shadow-lg rounded-2xl p-8 text-gray-200">
        <h2 class="text-2xl font-semibold mb-6 flex items-center gap-2">
            💳 My Credit Card
        </h2>

        @if (session('status') === 'credit-updated')
            <div class="mb-4 bg-green-700/40 text-green-100 border border-green-600 px-4 py-2 rounded-lg">
                ✅ Credit card info updated successfully!
            </div>
        @endif

        <form method="POST" action="{{ route('credit.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm text-gray-400">Card Number</label>
                <input type="text" name="card_number" placeholder="XXXX-XXXX-XXXX-XXXX"
                    value="{{ old('card_number', $creditCard->card_number ?? '') }}"
                    class="w-full mt-1 p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
            </div>

            <div>
                <label class="block text-sm text-gray-400">Expiry Date</label>
                <input type="date" name="expiry_date"
                    value="{{ old('expiry_date', $creditCard->expiry_date ?? '') }}"
                    class="w-full mt-1 p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit"
                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 focus:ring-2 focus:ring-indigo-400 text-white rounded-lg font-medium transition-all">
                    💾 Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
