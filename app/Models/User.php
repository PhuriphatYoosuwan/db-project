<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;  // << ลบ HasApiTokens ออก เหลือแค่ Notifiable

    protected $fillable = [
        'name','email','password',
        'phone','gender','dob','avatar_path',
    ];

    protected $hidden = ['password','remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'date',
    ];

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar_path ? asset('storage/'.$this->avatar_path) : null;
    }
}
