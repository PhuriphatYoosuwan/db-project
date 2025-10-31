<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6 text-white">🛒 Checkout</h1>

        @if(session('checkout_success'))
            <div class="mb-4 p-4 bg-green-600 text-white rounded shadow">
                {{ session('checkout_success') }}
            </div>
        @endif

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

        @if($latestOrder)
        <div class="mb-6 p-4 bg-gray-800 rounded text-white shadow-md">
            <h2 class="font-semibold text-lg mb-2">Total: ${{ number_format($latestOrder->total, 2) }}</h2>
            <div class="space-y-2">
                @foreach($latestOrder->items as $item)
                    <div class="flex justify-between items-center bg-gray-700 p-2 rounded">
                        <div class="flex items-center space-x-2">
                            @if($item->product->image)
                                <img src="{{ asset('storage/images/' . $item->product->image) }}" alt="{{ $item->product->name }}" width="50" class="rounded shadow">
                            @endif
                            <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                        </div>
                        <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                    </div>
                @endforeach

            </div>

            @if($latestOrder->status !== 'completed')
                <form id="checkoutForm" action="{{ route('checkout.process', $latestOrder->id) }}" method="POST" class="mt-4 text-right">
                    @csrf
                    <button 
                        type="button"
                        onclick="confirmCheckout()"
                        class="px-6 py-2 bg-indigo-600 hover:bg-indigo-500 rounded text-white font-medium shadow-md transition hover:scale-[1.02]">
                        ✅ Checkout
                    </button>
                </form>
            @endif
        </div>

        <div class="mb-4 p-4 bg-gray-700 rounded shadow-md">
        <label class="font-semibold mb-2 block text-white">💰 Payment Method:</label>
        <div class="flex space-x-6">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="radio" name="payment_method" value="credit_card" checked
                    class="form-radio text-indigo-500 focus:ring-indigo-400" 
                    onchange="togglePaymentMethod()">
                <span class="text-gray-200">Credit Card</span>
            </label>
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="radio" name="payment_method" value="cod" 
                    class="form-radio text-green-500 focus:ring-green-400"
                    onchange="togglePaymentMethod()">
                <span class="text-gray-200">Cash on Delivery</span>
            </label>
        </div>

        {{-- 🚨 Notice for Credit Card --}}
        <p id="creditCardNotice" class="mt-2 text-yellow-400 font-medium hidden">
            ⚠️ This system does not support credit card payments. Please choose Cash on Delivery for now.
        </p>
    </div>

        {{-- 🚨 Notice for Credit Card --}}
        <p id="creditCardNotice" class="mt-2 text-yellow-400 font-medium hidden">
            ⚠️ This system does not support credit card payments. Please choose Cash on Delivery for now.
        </p>
    </div>

    </div>
    @else
        <p class="text-gray-300">You have no orders to checkout.</p>
    @endif
    </div>

    <script>
    function togglePaymentMethod() {
        const creditCardInput = document.querySelector('input[name="payment_method"][value="credit_card"]');
        const notice = document.getElementById('creditCardNotice');
        const confirmButton = document.querySelector('#checkoutForm button');

        if (creditCardInput.checked) {
            notice.classList.remove('hidden');
            confirmButton.disabled = true; // ปิดการกด
            confirmButton.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            notice.classList.add('hidden');
            confirmButton.disabled = false; // เปิดการกด
            confirmButton.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    // เรียกครั้งแรกเพื่อแสดงสถานะตาม default
    togglePaymentMethod();
    </script>

    {{-- ✅ SweetAlert2 Popup --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmCheckout() {
        Swal.fire({
            title: '🛒 Confirm your purchase?',
            text: "Please confirm that you want to checkout all items in your cart.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Confirm Purchase',
            cancelButtonText: 'Cancel',
            background: '#1f2937',
            color: '#f9fafb',
            customClass: {
                popup: 'rounded-2xl shadow-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: '🎉 Checkout Successful!',
                    text: 'You will be redirected back to the store.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                    background: '#111827',
                    color: '#f9fafb'
                });

                // submit the form after a short delay
                setTimeout(() => {
                    document.getElementById('checkoutForm').submit();
                }, 1800);
            }
        });
    }
</script>


</x-app-layout>
