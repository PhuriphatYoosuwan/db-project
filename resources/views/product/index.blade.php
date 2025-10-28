<x-app-layout>
    <div class="text-white products">
        <div class="product-card">
            <h2>{{ $product->name }}</h2>
            <p>Price: {{ $product->price }}</p>
            @if($product->image)
                <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}" width="150">
            @endif

            {{-- ปุ่ม Add Review --}}
            <a href="#" id="add-review-btn" class="inline-block mt-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded text-white">
                Add Review
            </a>

            {{-- ปุ่ม Add to Cart --}}
            <form action="{{ route('cart.add') }}" method="POST" class="inline-block ml-2">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button 
                    type="submit"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded text-white">
                    🛒 Add to Cart
                </button>
            </form>
        </div>
    </div>

    {{-- คะแนนเฉลี่ย --}}
    <div class="mt-4 mb-4 text-white flex items-center space-x-2">
        <div class="flex">
            @php
                $fullStars = floor($averageRating);
                $halfStar = ($averageRating - $fullStars) >= 0.5;
                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
            @endphp

            {{-- ดาวเต็ม --}}
            @for ($i = 0; $i < $fullStars; $i++)
                <span class="text-yellow-400 text-xl">★</span>
            @endfor

            {{-- ดาวครึ่ง --}}
            @if($halfStar)
                <span class="text-yellow-400 text-xl">☆</span>
            @endif

            {{-- ดาวว่าง --}}
            @for ($i = 0; $i < $emptyStars; $i++)
                <span class="text-gray-400 text-xl">★</span>
            @endfor
        </div>

        {{-- คะแนนตัวเลข --}}
        <div>
            @if($averageRating)
                {{ number_format($averageRating, 1) }} / 5
            @else
                No reviews yet
            @endif
        </div>
    </div>

    {{-- ฟอร์มรีวิว --}}
    <div id="review-form" class="hidden mb-6">
        <form action="{{ route('reviews.store') }}" method="POST" class="space-y-2">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            
            <label class="block text-white">Rating (1-5)</label>
            <input type="number" name="rating" min="1" max="5" required class="p-2 rounded text-black">

            <label class="block text-white">Comment</label>
            <textarea name="comment" rows="3" class="p-2 rounded text-black"></textarea>

            <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded text-white">Submit Review</button>
        </form>
    </div>

    {{-- รีวิวทั้งหมด --}}
    <h1 class="text-2xl text-white font-bold mb-4">Reviews for {{ $product->name }}</h1>
    <div class="text-white space-y-4">
        @forelse ($reviews as $review)
            <div class="p-4 border rounded bg-gray-800 text-white">
                <p><strong>{{ $review->user->name }}</strong> rated: {{ $review->rating }}/5</p>
                <p>{{ $review->comment }}</p>
            </div>
        @empty
            <p>No reviews yet.</p>
        @endforelse
    </div>

    {{-- JS: แสดง/ซ่อนฟอร์มรีวิว --}}
    <script>
        const btn = document.getElementById('add-review-btn');
        const form = document.getElementById('review-form');

        btn.addEventListener('click', function(e) {
            e.preventDefault();
            form.classList.toggle('hidden');
        });
    </script>
</x-app-layout>
