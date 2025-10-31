@extends('layouts.app')
@section('title', 'Order History')

@section('content')
<div class="flex bg-gray-900 text-gray-100 min-h-screen">

  {{-- ✅ Sidebar --}}
  @include('layouts.sidebar')

  {{-- ✅ เนื้อหาหลัก --}}
  <div class="flex-1 py-10 px-8">
    <div class="max-w-5xl mx-auto bg-gray-800 shadow-lg rounded-2xl p-8">
      <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
        🛒 Order History
      </h1>

      @if($orders->isEmpty())
        <p class="text-gray-400 italic">No orders yet</p>
      @else
        @foreach($orders as $order)
          <div class="bg-gray-900/60 rounded-xl p-4 mb-6 border border-gray-700 hover:border-indigo-400 transition">
            <div class="flex justify-between mb-2">
              <span class="font-semibold text-indigo-300">Order #{{ $order->id }}</span>
              <span class="text-xs text-gray-400">{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>

            <table class="w-full text-sm text-left text-gray-300">
              <thead>
                <tr class="text-gray-400 border-b border-gray-700">
                  <th class="py-2">Product</th>
                  <th class="py-2 text-center">Quantity</th>
                  <th class="py-2 text-right">Price</th>
                </tr>
              </thead>
              <tbody>
                @foreach($order->items as $item)
                  <tr class="border-b border-gray-800 hover:bg-gray-700/50 transition">
                    <td class="py-2 flex items-center gap-3">
                      {{-- ✅ รูปสินค้า --}}
                     @if($item->product->image)
                                <img src="{{ asset('storage/images/' . $item->product->image) }}" alt="{{ $item->product->name }}" width="50" class="rounded shadow">
                            @endif

                      {{-- ✅ ชื่อสินค้า --}}
                      <span class="text-gray-200 font-medium">
                        {{ $item->product->name ?? '-' }}
                      </span>
                    </td>

                    <td class="py-2 text-center">{{ $item->quantity }}</td>

                    <td class="py-2 text-right text-indigo-300">
                      {{ number_format($item->price, 2) }} ฿
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>

            {{-- ✅ Total --}}
            <div class="text-right mt-2 text-gray-100 font-medium">
              Total: 
              <span class="text-indigo-300 font-semibold">
                {{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }} ฿
              </span>
            </div>
          </div>
        @endforeach
      @endif
    </div>
  </div>
</div>
@endsection
