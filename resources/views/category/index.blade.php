<x-app-layout>
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

    <div class="card my-10 text-white">
        <div class="card-body">
            <h5 class="mb-3">Categories</h5>
            <div class="d-flex flex-row-reverse flex-wrap gap-2">
                @foreach ($categories as $categories)
                    <a href="{{ url('/category/'.$categories->id) }}">{{ $categories->name }}</a>
                @endforeach

            </div>
        </div>
    </div>

</x-app-layout>