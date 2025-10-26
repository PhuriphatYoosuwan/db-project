<x-app-layout>
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

    <h1 class="text-white">{{ $category->name }}</h1>

    <div class="text-white products">
        @foreach ($products as $product)
            <div class="product-card">
                <h2>{{ $product->name }}</h2>
                <p>Price: {{ $product->price }}</p>
                @if($product->image)
                <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}" width="150">
                @endif
            </div>
        @endforeach
    </div>
</x-app-layout>