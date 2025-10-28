<nav x-data="{ open: false }" class="bg-[#6f6f73] border-b border-[#4f4f52] text-white shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6">
        <div class="flex justify-between items-center h-20">
            
            {{-- 🔷 Left Section --}}
            <div class="flex items-center w-full gap-8 ml-[-12px]">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('shop') }}" class="flex items-center gap-2">
                        <h1 class="text-white font-bold text-4xl tracking-wide">Shopping</h1>
                    </a>
                </div>

                <!-- 🧭 Full-width Search bar (เหมือนเดิมแต่บาลานซ์กับแถบใหม่) -->
                <div class="flex items-center w-full">
                    <form method="GET" class="flex items-center w-full">
                        <input 
                            type="text" 
                            name="q" 
                            placeholder="Search products..."
                            value="{{ request('q') }}"
                            class="flex-1 border border-[#4f4f52] rounded-l-lg px-4 py-3 
                                   text-[16px] focus:outline-none focus:ring-2 focus:ring-[#eaeaea] text-black"
                        >
                        <button 
                            type="submit"
                            class="bg-black text-white px-5 py-3 rounded-r-lg font-semibold hover:bg-[#4f4f52] transition"
                        >
                            🔍
                        </button>
                        <button 
                            type="button"
                            class="ml-3 text-white text-3xl hover:scale-110 transition flex items-center justify-center"
                        >
                            🛒
                        </button>
                    </form>
                </div>
            </div>

            {{-- 🔸 Right Section (User Menu) --}}
            <div class="hidden sm:flex items-center ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-[#6f6f73] hover:bg-[#4f4f52] focus:outline-none transition">
                            <div class="text-base font-semibold">{{ Auth::user()->name }}</div>
                            <div class="ml-2">
                                <svg class="fill-current h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- 🍔 Hamburger (Mobile) --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 rounded-md text-white hover:bg-[#4f4f52] focus:outline-none transition">
                    <svg class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- 📱 Responsive Navigation --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-[#6f6f73] text-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-[#4f4f52]">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-300">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
