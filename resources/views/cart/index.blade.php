<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4 text-white">Your Cart</h1>

        {{-- ✅ ที่อยู่จัดส่ง --}}
        @if($address)
            <div class="mb-6 p-4 bg-gray-800 rounded text-gray-200 shadow-md transition-transform hover:scale-[1.01]">
                <h2 class="text-lg font-semibold mb-2">📍 Shipping Address</h2>
                <p>{{ $address->detail ?? '' }}</p>
                <p>{{ $address->sub_district ?? '' }}, {{ $address->district ?? '' }}</p>
                <p>{{ $address->province ?? '' }} {{ $address->postal_code ?? '' }}</p>
            </div>
        @else
            <div class="mb-6 p-4 bg-gray-800 rounded text-gray-400 italic">
                ⚠️ No address on file.
            </div>
        @endif

        {{-- ✅ ข้อมูลบัตรเครดิต --}}
        @if($creditCard)
            <div class="mb-6 p-4 bg-gray-800 rounded text-gray-200 shadow-md transition-transform hover:scale-[1.01]">
                <h2 class="text-lg font-semibold mb-2">💳 Credit Card</h2>
                <p><strong>Name:</strong> {{ $creditCard->card_holder }}</p>
                <p><strong>Number:</strong> {{ $creditCard->masked_card_number ?? '**** **** **** ' . substr($creditCard->card_number, -4) }}</p>
            </div>
        @else
            <div class="mb-6 p-4 bg-gray-800 rounded text-gray-400 italic">
                ⚠️ No credit card info on file.
            </div>
        @endif

        {{-- ✅ สินค้าในตะกร้า --}}
        @if(count($products) > 0)
            <div class="space-y-4">
                @foreach($products as $product)
                    <div class="flex items-center justify-between p-4 bg-gray-800 rounded text-white shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:scale-[1.01]">
                        <div class="flex items-center space-x-4">
                            @if($product->image)
                                <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}" width="80" class="rounded-lg shadow">
                            @endif
                            <div>
                                <h2 class="font-semibold text-lg">{{ $product->name }}</h2>
                                <p class="text-gray-300">Price: ${{ $product->price }}</p>
                                <p class="text-gray-400 text-sm">Quantity: {{ $cart[$product->id] }}</p>
                                 {{-- Quantity Controls --}}
                                <div class="flex items-center space-x-2 mt-1">
                                    {{-- Decrease --}}
                                    <form action="{{ route('cart.updateQuantity') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="action" value="decrease">
                                        <button type="submit" class="px-2 py-1 bg-gray-700 hover:bg-gray-600 rounded text-white font-bold">-</button>
                                    </form>

                                    {{-- Current Quantity --}}
                                    <span class="px-2 py-1 bg-gray-800 rounded text-white">{{ $cart[$product->id] }}</span>

                                    {{-- Increase --}}
                                    <form action="{{ route('cart.updateQuantity') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="action" value="increase">
                                        <button type="submit" class="px-2 py-1 bg-gray-700 hover:bg-gray-600 rounded text-white font-bold">+</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 rounded shadow-md transition duration-200">
                                Remove
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            {{-- ✅ Checkout พร้อม SweetAlert --}}
            <form id="checkoutForm" action="{{ route('cart.checkout') }}" method="POST" class="mt-6 text-right">
                @csrf
                <button type="button"
                    onclick="confirmCheckout()"
                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg font-medium shadow-md transition-all duration-200 hover:scale-[1.02] active:scale-95">
                    🛍️ Checkout
                </button>
            </form>

            {{-- ✅ รวมราคาทั้งหมด --}}
            @php
                $total = 0;
                foreach($products as $product){
                    $total += $product->price * $cart[$product->id];
                }
            @endphp

            <div class="mt-6 p-4 bg-gray-900 rounded text-white text-right font-bold shadow-inner border-t border-gray-700">
                Total: ${{ number_format($total, 2) }}
            </div>
        @else
            <p class="text-white italic mt-4">Your cart is empty.</p>
        @endif
    </div>

    {{-- ✅ SweetAlert2 Popup --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmCheckout() {
            Swal.fire({
                title: '🛒 ยืนยันการสั่งซื้อสินค้าหรือไม่?',
                text: "โปรดยืนยันว่าต้องการ Checkout สินค้าทั้งหมด",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'ยืนยันการสั่งซื้อ',
                cancelButtonText: 'ยกเลิก',
                background: '#1f2937',
                color: '#f9fafb',
                customClass: {
                    popup: 'rounded-2xl shadow-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: '🎉 Checkout สำเร็จ!',
                        text: 'ระบบจะพาคุณกลับไปยังหน้าร้านค้า',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        background: '#111827',
                        color: '#f9fafb'
                    });
                    setTimeout(() => {
                        document.getElementById('checkoutForm').submit();
                    }, 1800);
                }
            });
        }
    </script>
</x-app-layout>
