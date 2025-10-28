<x-app-layout>
    <div class="text-white products">
        <div class="product-card">
            <h2>{{ $product->name }}</h2>
            <p>Price: {{ $product->price }}</p>
            @if($product->image)
                <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}" width="150">
            @endif
        </div>
        <a href="">add to cart</a>
    </div>
    
</x-app-layout>
