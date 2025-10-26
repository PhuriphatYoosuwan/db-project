<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

{{-- 🔷 Promotion Section --}}
<div class="bg-white border border-gray-300 rounded-lg shadow-sm mb-8">
    <div class="p-6">
        <h5 class="mb-6 text-xl font-semibold text-gray-800 text-center">Promotion</h5>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            {{-- 💸 Card 1 --}}
            <div class="p-5 border border-gray-200 rounded-xl 
                        bg-gradient-to-b from-gray-50 to-white text-center 
                        shadow-sm hover:shadow-md hover:scale-[1.02] 
                        transition duration-300 ease-in-out w-full">
                <div class="text-4xl mb-2">💸</div>
                <h6 class="text-lg font-semibold text-gray-700 mb-1">Spend Over 5000฿</h6>
                <p class="text-sm text-gray-500">Receive 10% Discount Instantly</p>
            </div>

            {{-- 🏷️ Card 2 --}}
            <div class="p-5 border border-gray-200 rounded-xl 
                        bg-gradient-to-b from-gray-50 to-white text-center 
                        shadow-sm hover:shadow-md hover:scale-[1.02] 
                        transition duration-300 ease-in-out w-full">
                <div class="text-4xl mb-2">🏷️</div>
                <h6 class="text-lg font-semibold text-gray-700 mb-1">Spend 1000฿</h6>
                <p class="text-sm text-gray-500">Get 100฿ Off Your Purchase</p>
            </div>
        </div>
    </div>
</div>

                {{-- 🟢 Categories Section --}}
<div class="bg-white border border-gray-300 rounded-lg shadow-sm mt-8">
    <div class="p-6">
        <h5 class="mb-6 text-xl font-semibold text-gray-800 text-center">Categories</h5>

        @php
            // 🔹 Map ไอคอนตามชื่อหมวดหมู่
            $icons = [
                'Bags' => '👜',
                'Pets' => '🐶',
                'Shoes' => '👟',
                'Gaming Gears' => '🎮',
                'Phone' => '📱',
                'Medicines' => '💊',
                'Shirts' => '👕',
                'Accessories' => '💍',
                'Furnitures' => '🪑',
                'Foods and Drinks' => '🍔',
                'Sports' => '⚽',
                'Campings' => '🏕️',
                'Computer' => '💻',
                'Phones' => '📱',
            ];
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 justify-items-center">
            @foreach ($categories as $category)
                <a href="{{ url('/category/'.$category->id) }}"
                   class="w-32 h-28 flex flex-col items-center justify-center border border-gray-300 
                          rounded-xl bg-gray-50 hover:bg-gray-200 text-gray-800 text-sm font-medium 
                          shadow-sm hover:shadow-md transition duration-200 ease-in-out cursor-pointer">
                    {{-- ไอคอน --}}
                    <div class="text-3xl mb-2">
                        {{ $icons[$category->name] ?? '🛍️' }}
                    </div>

                    {{-- ชื่อหมวดหมู่ --}}
                    <span class="truncate text-center">{{ $category->name }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

        </div>
    </div>
</x-app-layout>
