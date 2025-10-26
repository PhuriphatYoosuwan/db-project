<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id','name','price_cents','image_path'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    // Helper แสดงราคาเป็นบาท (มีทศนิยม 2 ตำแหน่ง)
    public function getPriceBahtAttribute(): string {
        return number_format($this->price_cents / 100, 2);
    }

    // Helper คืน URL รูปสินค้า
    public function getImageUrlAttribute(): string {
        return $this->image_path
            ? asset('storage/'.$this->image_path)
            : asset('images/placeholder.png');
    }
}
