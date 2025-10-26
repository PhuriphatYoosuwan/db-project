@extends('layouts.app')

@section('title', 'All Products')

@section('content')
<div class="container py-4">
  <h2 class="mb-4 text-center">🛍️ All Products</h2>

  {{-- Grid แสดงสินค้า --}}
  <div class="row g-4">
    @foreach($products as $product)
      <div class="col-6 col-md-4 col-lg-3">
        <div class="card h-100 shadow-sm border-0">
          {{-- รูปสินค้า --}}
          <img src="{{ $product->image_url }}"
     alt="{{ $product->name }}"
     class="card-img-top"
     style="object-fit: cover; width: 100%; height: 220px; border-radius: 10px;">


          <div class="card-body d-flex flex-column">
            {{-- ชื่อสินค้า --}}
            <h5 class="card-title text-center mb-2">{{ $product->name }}</h5>

            {{-- ราคา --}}
            <p class="text-center fw-bold text-success mb-2">
              ฿{{ number_format($product->price_cents / 100, 2) }}
            </p>

            {{-- คำอธิบาย --}}
            <p class="text-muted small text-center flex-grow-1">
              {{ $product->description }}
            </p>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  {{-- ถ้าไม่มีสินค้า --}}
  @if($products->isEmpty())
    <p class="text-center mt-5 text-muted">ไม่มีสินค้าที่จะแสดงในขณะนี้</p>
  @endif
</div>
@endsection
