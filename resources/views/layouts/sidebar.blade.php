{{-- resources/views/layouts/sidebar.blade.php --}}
<nav 
  class="sidebar bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 w-64 min-h-screen flex flex-col items-start p-6 space-y-4 border-r border-gray-700 font-sans text-gray-100"
  x-data="{ showAll: false }">

  {{-- ✅ Main Menu --}}
  <a href="{{ url('/profile') }}"
     class="w-full px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-gray-700 transition {{ request()->is('profile*') ? 'bg-gray-700 font-semibold text-white' : 'text-gray-300' }}">
     🏠 <span class="font-medium">Profile</span>
  </a>

  <a href="{{ url('/address') }}"
     class="w-full px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-gray-700 transition {{ request()->is('address*') ? 'bg-gray-700 font-semibold text-white' : 'text-gray-300' }}">
     📍 <span class="font-medium">Address</span>
  </a>

  <a href="{{ url('/credit-card') }}"
     class="w-full px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-gray-700 transition {{ request()->is('credit-card*') ? 'bg-gray-700 font-semibold text-white' : 'text-gray-300' }}">
     💳 <span class="font-medium">Credit Card</span>
  </a>

  {{-- ✅ Order History --}}
  <div class="mt-10 w-full">
    <h2 class="text-lg font-semibold mb-3 text-gray-200 border-b border-gray-600 pb-2 flex items-center gap-2">
      🛒 Order History
    </h2>

    @if($orders->isEmpty())
      <p class="text-gray-400 text-sm italic mt-2">No orders yet</p>
    @else
      {{-- ✅ Show only latest order or all if toggled --}}
      <div class="space-y-4">
        @foreach($orders as $index => $order)
          <div
            class="bg-gray-800 rounded-xl p-4 shadow-lg border border-gray-700 hover:border-indigo-400 transition-all duration-200"
            x-show="showAll || {{ $index < 1 ? 'true' : 'false' }}"
            x-transition.duration.300ms>
            
            <div class="flex justify-between mb-2">
              <span class="font-semibold text-indigo-300">Order #{{ $order->id }}</span>
              <span class="text-xs text-gray-400">{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>

            <table class="w-full text-sm text-left text-gray-300">
              <thead>
                <tr class="text-gray-400 border-b border-gray-700">
                  <th class="py-1">Product</th>
                  <th class="py-1 text-center">Quantity</th>
                  <th class="py-1 text-right">Price</th>
                </tr>
              </thead>
              <tbody>
                @foreach($order->items as $item)
                  <tr class="border-b border-gray-800 hover:bg-gray-700/50 transition">
                    <td class="py-1 text-gray-200">{{ $item->product->name ?? '-' }}</td>
                    <td class="py-1 text-center text-gray-300">{{ $item->quantity }}</td>
                    <td class="py-1 text-right text-indigo-300">{{ number_format($item->price, 2) }} ฿</td>
                  </tr>
                @endforeach
              </tbody>
            </table>

            <div class="text-right mt-2 text-gray-100 font-medium">
              Total: 
              <span class="text-indigo-300 font-semibold">
                {{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }} ฿
              </span>
            </div>
          </div>
        @endforeach
      </div>

      {{-- ✅ Show More / Show Less Button --}}
      @if($orders->count() > 1)
        <div class="mt-4 text-center">
          <button
            @click="showAll = !showAll"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 rounded-lg text-white text-sm shadow-md transition">
            <span x-show="!showAll" x-transition>🔽 Show More</span>
            <span x-show="showAll" x-transition>🔼 Show Less</span>
          </button>
        </div>
      @endif
    @endif
  </div>
</nav>
