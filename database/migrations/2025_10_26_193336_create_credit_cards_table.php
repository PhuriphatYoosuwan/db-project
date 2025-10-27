<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id();

            // ความสัมพันธ์ 1:1 กับ users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // ข้อมูลบัตร
            $table->string('card_holder')->nullable(); // ชื่อบนบัตร
            $table->text('card_number')->nullable();   // 🔐 เข้ารหัส → ใช้ text
            $table->date('expiry_date')->nullable();   // วันหมดอายุ
            $table->text('cvv')->nullable();           // 🔐 เข้ารหัส → ใช้ text

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_cards');
    }
};
