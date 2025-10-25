@extends('layouts.app')

@section('title','Dashboard • Shopping')

@section('content')
  {{-- Promotions --}}
  <div class="card mb-4">
    <div class="card-body">
      <h5 class="mb-3">Promotion</h5>
      <div class="row g-3">
        <div class="col-md-4">
          <div class="p-3 border bg-light rounded-3 text-center">Spend Over 5000 – Get 10% Off</div>
        </div>
        <div class="col-md-4">
          <div class="p-3 border bg-light rounded-3 text-center">Only one promotion can be used per purchase.</div>
        </div>
        <div class="col-md-4">
          <div class="p-3 border bg-light rounded-3 text-center">Buy 1 Get 1 Free</div>
        </div>
        <div class="col-md-6">
          <div class="p-3 border bg-light rounded-3 text-center">Spend 1000 – Get 100฿ Off</div>
        </div>
      </div>
    </div>
  </div>

  {{-- Categories (clickable) --}}
  <div class="card">
    <div class="card-body">
      <h5 class="mb-3">Categories</h5>

      @php
        // ถ้ามาจาก DB ให้ใช้ $categories (ต้องมี fields: name, slug)
        // ถ้าไม่มี ให้ fallback เป็นรายการด้านล่าง
        $fallback = collect([
          ['name'=>'Bags','slug'=>'bags'],
          ['name'=>'Pets','slug'=>'pets'],
          ['name'=>'Shoes','slug'=>'shoes'],
          ['name'=>'Gaming gear','slug'=>'gaming-gear'],
          ['name'=>'Phone','slug'=>'phone'],
          ['name'=>'Tools','slug'=>'tools'],
          ['name'=>'Medicines','slug'=>'medicines'],
          ['name'=>'Shirts','slug'=>'shirts'],
          ['name'=>'Accessories','slug'=>'accessories'],
          ['name'=>'Furniture','slug'=>'furniture'],
          ['name'=>'Food & Drink','slug'=>'food-and-drink'],
          ['name'=>'Sports','slug'=>'sports'],
          ['name'=>'Camping','slug'=>'camping'],
          ['name'=>'Computer','slug'=>'computer'],
        ]);
        $cats = isset($categories) && count($categories) ? collect($categories)->map(fn($c)=>['name'=>$c->name,'slug'=>$c->slug]) : $fallback;
      @endphp>

      @if($cats->isEmpty())
        <div class="alert alert-light border">ยังไม่มีหมวดหมู่</div>
      @else
        <style>
          .cat-tile{transition:.15s ease; border-radius:.75rem; border:1px solid rgba(0,0,0,.15);}
          .cat-tile:hover{transform:translateY(-2px); box-shadow:0 .25rem .75rem rgba(0,0,0,.08);}
        </style>
        <div class="row row-cols-2 row-cols-md-4 row-cols-xl-6 g-3 text-center">
          @foreach ($cats as $cat)
            <div class="col">
              <a href="{{ route('shop.category', $cat['slug']) }}" class="text-decoration-none text-body d-block">
                <div class="cat-tile p-3 bg-light">{{ $cat['name'] }}</div>
              </a>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
@endsection
