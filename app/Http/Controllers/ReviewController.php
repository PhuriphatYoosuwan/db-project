<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;

class ReviewController extends Controller
{
    // แสดงรีวิวทั้งหมด (อาจสำหรับ admin)
    public function index()
    {
        $reviews = Review::with('product','user')->latest()->paginate(10);
        return view('reviews.index', compact('reviews'));
    }

    // แสดงรีวิวตามสินค้า
    public function reviewsByProduct($productId)
    {
        $product = Product::findOrFail($productId);
        $reviews = $product->reviews()->with('user')->latest()->get();
        return view('reviews.byProduct', compact('product','reviews'));
    }

    // ฟอร์มสร้างรีวิว
    public function create($productId)
    {
        return view('reviews.create', compact('productId'));
    }

    // บันทึกรีวิวใหม่
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success','Review added!');
    }

    // แก้ไขรีวิว
    public function edit($id)
    {
        $review = Review::findOrFail($id);
        return view('reviews.edit', compact('review'));
    }

    // อัปเดตรีวิว
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update($request->only('rating','comment'));

        return redirect()->back()->with('success','Review updated!');
    }

    // ลบรีวิว
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success','Review deleted!');
    }
}
