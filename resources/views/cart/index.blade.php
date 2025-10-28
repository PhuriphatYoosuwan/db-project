<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold mb-6 text-white">Your Cart</h1>

        @if(count($products) > 0)
            {{-- รายการสินค้าในตะกร้า --}}
            <div class="space-y-6">
                @foreach($products as $product)
                    <div class="flex flex-col md:flex-row items-center justify-between bg-gray-900/80 border border-gray-800 rounded-2xl shadow-md p-5">
                        {{-- ส่วนซ้าย: รูป + ชื่อสินค้า --}}
                        <div class="flex items-center space-x-5 w-full md:w-auto">
                            @if($product->image)
                                <img src="{{ asset('storage/images/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-20 h-20 object-cover rounded-lg shadow">
                            @endif
                            <div>
                                <h2 class="text-lg font-semibold text-white">{{ $product->name }}</h2>
                                <p class="text-gray-400 text-sm">Unit Price: ฿{{ number_format($product->price, 2) }}</p>
                                <p class="text-gray-400 text-sm">Quantity: {{ $cart[$product->id] }}</p>
                            </div>
                        </div>

                        {{-- ส่วนขวา: ราคารวม + ปุ่มลบ --}}
                        <div class="flex items-center justify-end gap-4 mt-4 md:mt-0 w-full md:w-auto">
                            <div class="text-xl font-bold text-orange-400">
                                ฿{{ number_format($product->price * $cart[$product->id], 2) }}
                            </div>
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 rounded-lg text-white shadow transition">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- รวมราคาทั้งหมด --}}
            @php
                $total = 0;
                foreach($products as $product){
                    $total += $product->price * $cart[$product->id];
                }
            @endphp

            <div class="mt-8 p-5 bg-gray-800 border border-gray-700 rounded-2xl flex justify-between items-center text-white">
                <span class="text-lg font-semibold">Total:</span>
                <span class="text-2xl font-bold text-orange-400">฿{{ number_format($total, 2) }}</span>
            </div>

            {{-- ปุ่ม Checkout --}}
            <form action="{{ route('cart.checkout') }}" method="POST" class="mt-6 text-right">
                @csrf
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 rounded-lg text-white font-semibold shadow transition">
                    Proceed to Checkout →
                </button>
            </form>
        @else
            <p class="text-gray-400 text-center mt-6 text-lg">Your cart is empty 🛒</p>
        @endif
    </div>
</x-app-layout>
