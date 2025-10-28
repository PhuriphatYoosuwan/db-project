{{-- resources/views/layouts/sidebar.blade.php --}}
<nav class="sidebar bg-gray-900 w-56 min-h-[500px] flex flex-col items-start p-6 space-y-4 border-r border-gray-700">
  <a href="http://localhost/profile"
     class="w-full px-3 py-2 rounded-lg flex items-center gap-2 hover:bg-gray-700 transition {{ request()->is('profile*') ? 'bg-gray-700 font-semibold' : '' }}">
     🏠 <span>Profile</span>
  </a>

  <a href="http://localhost/address"
     class="w-full px-3 py-2 rounded-lg flex items-center gap-2 hover:bg-gray-700 transition {{ request()->is('address*') ? 'bg-gray-700 font-semibold' : '' }}">
     📍 <span>Address</span>
  </a>

  <a href="http://localhost/credit-card"
     class="w-full px-3 py-2 rounded-lg flex items-center gap-2 hover:bg-gray-700 transition {{ request()->is('credit-card*') ? 'bg-gray-700 font-semibold' : '' }}">
     💳 <span>Credit Card</span>
  </a>
</nav>
