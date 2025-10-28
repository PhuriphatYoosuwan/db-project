<x-app-layout>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4 text-white">Your Order</h1>

    {{-- ✅ Message --}}
    @if (session('checkout_success'))
      <div class="mb-4 bg-green-700/40 border border-green-600 text-green-100 px-4 py-3 rounded-lg">
        {{ session('checkout_success') }}
      </div>
    @endif

    {{-- ✅ Error --}}
    @if (session('error'))
      <div class="mb-4 bg-red-700/40 border border-red-600 text-red-100 px-4 py-3 rounded-lg">
        {{ session('error') }}
      </div>
    @endif

    @if(count($products) > 0)
      {{-- ✅ Shipping Address --}}
      @if($address)
        <div class="mb-6 p-4 bg-gray-800 rounded-lg text-white">
          <h2 class="text-lg font-semibold mb-2">📍 Shipping Address</h2>
          @if(!empty($address->detail))
            <p class="text-gray-300 mb-1">{{ $address->detail }}</p>
          @endif
          <p>{{ $address->sub_district }}, {{ $address->district }}, {{ $address->province }} {{ $address->postal_code }}</p>
        </div>
      @else
        <div class="mb-6 p-4 bg-gray-800 rounded-lg text-gray-300">
          <h2 class="text-lg font-semibold mb-2">📍 Shipping Address</h2>
          <p>No address found. <a href="{{ route('address.edit') }}" class="text-blue-400 underline">Add address</a></p>
        </div>
      @endif

      {{-- ✅ Credit Card --}}
      @if($creditCard)
        <div class="mb-6 p-4 bg-gray-800 rounded-lg text-white">
          <h2 class="text-lg font-semibold mb-2">💳 Credit Card Info</h2>
          <p>Card Holder: {{ $creditCard->card_holder }}</p>
          <p>Card Number: **** **** **** {{ substr($creditCard->card_number, -4) }}</p>
        </div>
      @else
        <div class="mb-6 p-4 bg-gray-800 rounded-lg text-gray-300">
          <h2 class="text-lg font-semibold mb-2">💳 Credit Card Info</h2>
          <p>No credit card found. <a href="{{ route('credit.edit') }}" class="text-blue-400 underline">Add card</a></p>
        </div>
      @endif

      {{-- ✅ Product List --}}
      <div class="space-y-4">
        @foreach($products as $product)
          <div class="flex items-center justify-between p-4 bg-gray-800 rounded text-white">
            <div class="flex items-center space-x-4">
              @if($product->image)
                <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}" width="80">
              @endif
              <div>
                <h2 class="font-semibold">{{ $product->name }}</h2>
                <p>Price: ${{ $product->price }}</p>
                <p>Quantity: {{ $cart[$product->id] }}</p>
              </div>
            </div>
            <form action="{{ route('cart.remove') }}" method="POST">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 rounded">Remove</button>
            </form>
          </div>
        @endforeach
      </div>

      {{-- ✅ Total --}}
      @php
        $total = 0;
        foreach($products as $product){
          $total += $product->price * $cart[$product->id];
        }
      @endphp
      <div class="mt-4 p-4 bg-gray-900 rounded text-white text-right font-bold">
        Total: ${{ number_format($total, 2) }}
      </div>

      {{-- ✅ Checkout Button --}}
      <form id="checkout-form" action="{{ route('cart.checkout') }}" method="POST" class="mt-4 text-right">
        @csrf
        <input type="hidden" name="total" value="{{ $total }}">
        <button type="button" id="confirm-checkout"
          class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded text-white transition">
          Checkout
        </button>
      </form>

      {{-- ✅ SweetAlert2 --}}
      
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        document.getElementById('confirm-checkout').addEventListener('click', function() {
            Swal.fire({
            title: 'ยืนยันการสั่งซื้อ?',
            text: 'ตรวจสอบที่อยู่และข้อมูลบัตรก่อนดำเนินการ',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '✅ ยืนยันสั่งซื้อ',
            cancelButtonText: 'ยกเลิก',
            background: '#1f2937',
            color: '#e5e7eb',
            }).then((result) => {
            if (result.isConfirmed) {
                // แสดง popup success
                Swal.fire({
                title: 'สั่งซื้อสำเร็จ!',
                text: 'ขอบคุณที่ใช้บริการ 🎉',
                icon: 'success',
                confirmButtonColor: '#10b981',
                background: '#1f2937',
                color: '#e5e7eb',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didClose: () => {
                    // ✅ Redirect ไปหน้าร้านหลังจาก popup ปิด
                    window.location.href = 'http://localhost/shop';
                }
                });
            }
            });
        });
        </script>
    @else
      <p class="text-white">Your cart is empty.</p>
    @endif
  </div>
</x-app-layout>
