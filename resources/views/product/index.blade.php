<x-app-layout>
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-md p-8 grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Left: Product Image --}}
            <div class="flex flex-col items-center">
                <div class="w-full h-[450px] bg-gray-100 flex items-center justify-center overflow-hidden rounded-lg border">
                    @if($product->image)
                        <img src="{{ asset('storage/images/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="object-contain w-full h-full">
                    @else
                        <span class="text-gray-400 text-sm">No Image</span>
                    @endif
                </div>

                {{-- Thumbnail previews (optional, if you have multiple images) --}}
                <div class="flex gap-2 mt-4">
                    <div class="w-20 h-20 bg-gray-200 rounded-lg"></div>
                    <div class="w-20 h-20 bg-gray-200 rounded-lg"></div>
                    <div class="w-20 h-20 bg-gray-200 rounded-lg"></div>
                </div>
            </div>

            {{-- Right: Product Info --}}
            <div class="flex flex-col justify-between">
                <div>
                    <h1 class="text-2xl font-semibold mb-2">{{ $product->name }}</h1>
                    <div class="flex items-center mb-3">
                        <span class="text-yellow-400 text-lg">★ ★ ★ ★ ☆</span>
                        <span class="text-gray-600 text-sm ml-2">4.5 | 3.2k รีวิว</span>
                    </div>

                    <div class="bg-gray-50 border border-gray-200 rounded-xl py-4 px-6 mb-4">
                        <p class="text-3xl text-red-600 font-bold">฿{{ number_format($product->price, 2) }}</p>
                        <p class="text-sm text-gray-500 mt-1 line-through">฿{{ number_format($product->price * 1.5, 2) }}</p>
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded ml-2">ลด 33%</span>
                    </div>

                    {{-- Options (color, size, etc.) --}}
                    <div class="mb-6">
                        <p class="text-gray-700 font-medium mb-2">สี:</p>
                        <div class="flex gap-3">
                            <button class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">ขาว</button>
                            <button class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">ดำ</button>
                        </div>
                    </div>

                    {{-- Quantity selector --}}
                    <div class="flex items-center mb-6">
                        <p class="text-gray-700 font-medium mr-4">จำนวน:</p>
                        <div class="flex items-center border border-gray-300 rounded-lg">
                            <button class="px-3 py-1 text-lg text-gray-600 hover:bg-gray-100">−</button>
                            <input type="text" value="1" class="w-12 text-center border-l border-r border-gray-300 focus:outline-none">
                            <button class="px-3 py-1 text-lg text-gray-600 hover:bg-gray-100">＋</button>
                        </div>
                    </div>
                </div>

                {{-- Add to cart buttons --}}
                <div class="flex gap-4">
                    <a href="#" class="flex-1 text-center bg-orange-500 text-white py-3 rounded-lg hover:bg-orange-600 transition">
                        เพิ่มไปยังรถเข็น
                    </a>
                    <a href="#" class="flex-1 text-center bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 transition">
                        ซื้อสินค้า
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
