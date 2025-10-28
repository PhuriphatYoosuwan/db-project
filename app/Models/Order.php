<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     // อนุญาตให้เติมค่า mass assignment สำหรับฟิลด์เหล่านี้
    protected $fillable = [
        'user_id',
        'total',
    ];

    // ความสัมพันธ์กับ OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ความสัมพันธ์กับ User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
