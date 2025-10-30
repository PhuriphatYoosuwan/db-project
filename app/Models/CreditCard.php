<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class CreditCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_holder',
        'card_number',
        'expiry_date',
        'cvv',
    ];

    // ✅ ความสัมพันธ์กับ User (1:1)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ Encryption (เข้ารหัสก่อนบันทึก)
    public function setCardNumberAttribute($value)
    {
        $this->attributes['card_number'] = $value ? Crypt::encryptString($value) : null;
    }

    public function getCardNumberAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public function setCvvAttribute($value)
    {
        $this->attributes['cvv'] = $value ? Crypt::encryptString($value) : null;
    }

    public function getCvvAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public function getMaskedCardNumberAttribute()
    {
        $num = $this->card_number;
        return '**** **** **** ' . substr($num, -4);
    }

    public function getExpiryMonthAttribute()
    {
        return $this->expiry_date ? substr($this->expiry_date, 5, 2) : null;
    }

    public function getExpiryYearAttribute()
    {
        return $this->expiry_date ? substr($this->expiry_date, 0, 4) : null;
    }
}

