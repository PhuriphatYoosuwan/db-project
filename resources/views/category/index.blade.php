<x-app-layout>
    <div class="bg-gray-200 min-h-screen">

        {{-- Main Content --}}
        <div class="flex">

            {{-- Sidebar Categories --}}
            <aside class="w-1/5 bg-gray-200 p-6 text-gray-700">
                <h2 class="text-lg font-semibold mb-4">Category</h2>
                <ul class="space-y-2">
                    @foreach ($categories as $category)
                        <li>
                            <a 
                                href="{{ url('/category/'.$category->id) }}"
                                class="block text-gray-600 hover:text-gray-900 transition"
                            >
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </aside>

            {{-- Products Grid --}}
            <main class="flex-1 p-8">
                {{-- 2 columns for all screen sizes --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    @foreach ($products as $product)
                        <div class="bg-white rounded-2xl shadow-md border border-gray-300 hover:shadow-xl transition overflow-hidden">
                            {{-- Product Image --}}
                            <div class="relative w-full h-72 bg-gray-100 flex items-center justify-center overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/images/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="object-cover w-full h-full">
                                @else
                                    <span class="text-gray-400 text-sm">No Image</span>
                                @endif
                            </div>

                            {{-- Product Info --}}
                            <div class="p-4 flex flex-col items-center text-center">
                                <h3 class="text-lg font-semibold text-gray-800 truncate w-full">{{ $product->name }}</h3>
                                <p class="text-red-600 text-lg font-bold mt-1">฿{{ number_format($product->price, 2) }}</p>
                                <button class="mt-3 bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
