<x-app-layout>
  {{-- คอนเทนเนอร์หลัก มีระยะห่างขอบรอบ ๆ --}}
  <div class="max-w-6xl mx-auto px-6 py-8 text-white">

    <!-- {{-- Breadcrumb --}}
    <div class="text-sm text-gray-400 mb-4">
      <a href="{{ route('shop') }}" class="hover:underline">Shop</a>
      <span class="mx-2">›</span>
      <span class="text-gray-300">{{ $product->name }}</span>
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
    </div> -->

    {{-- Product Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      {{-- รูปสินค้า --}}
      <div class="bg-gray-900/90 border border-gray-800 rounded-2xl p-4 shadow-lg flex justify-center items-center">
        @if($product->image)
          <img src="{{ asset('storage/images/'.$product->image) }}"
               alt="{{ $product->name }}"
               class="w-64 h-auto object-contain rounded-xl shadow-md">
        @else
          <div class="text-gray-400">No image available</div>
        @endif
      </div>

      {{-- รายละเอียดสินค้า --}}
      <div class="bg-gray-900/90 border border-gray-800 rounded-2xl p-6 shadow-lg space-y-5">
        <h1 class="text-3xl font-bold">{{ $product->name }}</h1>

        {{-- คะแนนเฉลี่ย --}}
        @php
          $avg = $averageRating ?? 0;
          $full = floor($avg); $half = ($avg - $full) >= 0.5; $empty = 5 - $full - ($half ? 1 : 0);
        @endphp
        <div class="flex items-center gap-2">
          <div class="flex">
            @for($i=0;$i<$full;$i++) <span class="text-yellow-400 text-2xl">★</span> @endfor
            @if($half) <span class="text-yellow-400 text-2xl">☆</span> @endif
            @for($i=0;$i<$empty;$i++) <span class="text-gray-600 text-2xl">★</span> @endfor
          </div>
          <div class="text-gray-300">
            {{ $avg ? number_format($avg,1) : 'No rating' }} / 5 · {{ $reviews->count() }} reviews
          </div>
        </div>

        {{-- ราคา --}}
        <div class="bg-black/30 border border-gray-800 rounded-xl p-4 flex items-baseline gap-3">
          <div class="text-3xl font-extrabold text-orange-400">
            ฿{{ number_format($product->price,2) }}
          </div>
          @if(!empty($product->compare_price))
            <div class="line-through text-gray-500">฿{{ number_format($product->compare_price,2) }}</div>
            <span class="text-xs bg-orange-500/20 text-orange-300 px-2 py-0.5 rounded">
              -{{ max(0, round((1-$product->price/$product->compare_price)*100)) }}%
            </span>
          @endif
        </div>

        {{-- ปุ่มเพิ่มรีวิว --}}
        <a href="#review-form"
           id="add-review-btn"
           class="inline-block mt-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white shadow hover:shadow-md transition">
          Add Review
        </a>

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

    {{-- Divider --}}
    <div class="my-10 border-t border-gray-800"></div>

    {{-- ฟอร์มรีวิว --}}
    <div id="review-form" class="bg-gray-900/90 border border-gray-800 rounded-2xl p-6 shadow-lg mb-10">
      <h2 class="text-white text-xl font-semibold mb-4">เขียนรีวิวสินค้า</h2>
      <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
    {{-- ฟอร์มรีวิว --}}
    <div id="review-form" class="hidden mb-6">
        <form action="{{ route('reviews.store') }}" method="POST" class="space-y-2">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            
            <label class="block text-white">Rating (1-5)</label>
            <input type="number" name="rating" min="1" max="5" required class="p-2 rounded text-black">

        {{-- Interactive star --}}
        <div>
          <label class="block text-white mb-2">ให้คะแนน</label>
          <div id="starPicker" class="flex items-center gap-1 text-3xl select-none">
            @for($i=1;$i<=5;$i++)
              <button type="button"
                      data-v="{{ $i }}"
                      class="star text-gray-600 hover:scale-110 transition"
                      aria-label="ให้ {{ $i }} ดาว">★</button>
            @endfor
          </div>
          <input type="hidden" id="rating" name="rating" value="5" required>
        </div>

        <div>
          <label class="block text-white mb-2">ความคิดเห็น</label>
          <textarea name="comment"
                    rows="3"
                    class="w-full p-3 rounded-xl text-black"
                    placeholder="เล่าประสบการณ์การใช้งานสินค้า..."></textarea>
        </div>

        <button type="submit"
                class="px-5 py-2.5 rounded-xl bg-green-600 hover:bg-green-700 text-white shadow hover:shadow-md transition">
          ส่งรีวิว
        </button>
      </form>
    </div>

    {{-- รีวิวทั้งหมด --}}
    <div id="reviews">
      <h2 class="text-2xl font-bold text-white mb-5">รีวิวทั้งหมด</h2>

      @forelse ($reviews as $review)
        <div class="mb-4 bg-gray-900/90 border border-gray-800 rounded-2xl p-5 shadow-md">
          <div class="flex justify-between items-center mb-1">
            <div class="font-semibold text-white">{{ $review->user->name }}</div>
            <div class="text-yellow-400 text-lg">
              @for($i=0;$i<$review->rating;$i++) ★ @endfor
              @for($i=$review->rating;$i<5;$i++) <span class="text-gray-600">★</span> @endfor
            </div>
          </div>
          <p class="text-gray-200">{{ $review->comment }}</p>
          @if(!empty($review->created_at))
            <div class="mt-1 text-xs text-gray-500">{{ $review->created_at->format('d M Y H:i') }}</div>
          @endif
        </div>
      @empty
        <div class="bg-gray-900/90 border border-gray-800 rounded-2xl p-6 text-gray-400 text-center">
          ยังไม่มีรีวิว
        </div>
      @endforelse
    </div>
  </div>

  {{-- JS: scroll + interactive star --}}
  <script>
    document.getElementById('add-review-btn')?.addEventListener('click', e => {
      e.preventDefault();
      document.getElementById('review-form')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    (function () {
      const picker = document.getElementById('starPicker');
      if (!picker) return;
      const stars = picker.querySelectorAll('.star');
      const rating = document.getElementById('rating');

      function paint(n) {
        stars.forEach((s, i) => {
          s.classList.toggle('text-yellow-400', i < n);
          s.classList.toggle('text-gray-600', i >= n);
        });
      }

      paint(parseInt(rating.value, 10) || 5);
      stars.forEach(s => {
        s.addEventListener('mouseenter', () => paint(parseInt(s.dataset.v, 10)));
        s.addEventListener('click', () => {
          rating.value = s.dataset.v;
          paint(parseInt(rating.value, 10));
        });
      });
      picker.addEventListener('mouseleave', () => paint(parseInt(rating.value, 10)));
    })();
  </script>
</x-app-layout>
