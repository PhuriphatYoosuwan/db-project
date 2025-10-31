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
   <a href="{{ url('/order-history') }}"
      class="mt-10 w-full px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-gray-700 transition text-gray-300 {{ request()->is('order-history*') ? 'bg-gray-700 font-semibold text-white' : 'text-gray-300' }}">
      🛒 <span class="font-medium">Order History</span>
   </a>
</nav>
