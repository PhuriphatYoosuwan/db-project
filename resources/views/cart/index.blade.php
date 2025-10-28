<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4 text-white">Your Cart</h1>

        @if(count($products) > 0)
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

            {{-- รวมราคาทั้งหมด --}}
            @php
                $total = 0;
                foreach($products as $product){
                    $total += $product->price * $cart[$product->id];
                }
            @endphp

            <div class="mt-4 p-4 bg-gray-900 rounded text-white text-right font-bold">
                Total: ${{ number_format($total, 2) }}
            </div>

        @else
            <p class="text-white">Your cart is empty.</p>
        @endif
    </div>
</x-app-layout>
