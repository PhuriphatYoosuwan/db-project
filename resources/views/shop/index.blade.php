@extends('layouts.app')

@section('title', ($active?->name ?? 'Categories').' • Shopping')

@section('content')
<div class="row g-4">
  {{-- Sidebar หมวด --}}
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <h5 class="mb-3">Category</h5>
        <ul class="list-unstyled m-0">
          @forelse($categories as $cat)
            @php $isActive = $active && $active->id === $cat->id; @endphp
            <li class="mb-1">
              <a href="{{ route('shop.category', $cat->slug) }}"
                 class="d-block px-3 py-2 rounded text-decoration-none {{ $isActive ? 'bg-dark text-white' : 'text-body' }}">
                {{ $cat->name }}
              </a>
            </li>
          @empty
            <li class="text-muted">No categories yet.</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>

  {{-- พื้นที่รายการสินค้า --}}
  <div class="col-md-9">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="m-0">{{ $active?->name ?? 'All Products' }}</h5>
      <small class="text-muted">{{ $products->total() }} items</small>
    </div>

    @if($products->count() === 0)
      <div class="alert alert-light border">ยังไม่มีสินค้าในหมวดนี้</div>
    @else
      <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
        @foreach($products as $p)
          <div class="col">
            <div class="card h-100 shadow-sm">
              <img src="{{ $p->image_url }}" class="card-img-top" alt="{{ $p->name }}" style="height:140px;object-fit:cover">
              <div class="card-body d-flex flex-column">
                <div class="fw-semibold mb-1 text-truncate" title="{{ $p->name }}">{{ $p->name }}</div>
                <div class="text-danger mb-3">฿{{ $p->price_baht }}</div>

                {{-- ตัวควบคุมจำนวน (ฟรอนต์เอ็นด์เฉย ๆ ไว้ต่อ Cart ทีหลัง) --}}
                <div class="mt-auto d-flex align-items-center">
                  <button class="btn btn-outline-secondary btn-sm qty-minus">–</button>
                  <input type="number" class="form-control form-control-sm mx-2 text-center qty-input" value="0" min="0" style="width:64px;">
                  <button class="btn btn-outline-secondary btn-sm qty-plus">+</button>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="mt-4">
        {{ $products->withQueryString()->links() }}
      </div>
    @endif
  </div>
</div>

{{-- JS เบา ๆ สำหรับปุ่ม + / – --}}
<script>
document.addEventListener('click', e => {
  if (e.target.classList.contains('qty-plus') || e.target.classList.contains('qty-minus')) {
    const card = e.target.closest('.card');
    const input = card.querySelector('.qty-input');
    let v = parseInt(input.value || '0', 10);
    if (e.target.classList.contains('qty-plus')) v++;
    if (e.target.classList.contains('qty-minus')) v = Math.max(0, v-1);
    input.value = v;
  }
});
</script>
@endsection
