<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'province',
        'district',
        'sub_district',
        'postal_code',
        'detail',
    ];

    /**
     * ความสัมพันธ์กับ User (1:1)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * รวมที่อยู่เป็นข้อความเดียว
     */
    public function getFullAddressAttribute()
    {
        // รวม detail ด้วยถ้ามี
        $detail = $this->detail ? "{$this->detail}, " : '';
        return "{$detail}{$this->sub_district}, {$this->district}, {$this->province} {$this->postal_code}";
    }
    
}
