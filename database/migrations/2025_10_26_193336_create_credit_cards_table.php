<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id();

            // ความสัมพันธ์ 1:1 กับ users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // ✅ มีแค่ 2 ฟิลด์
            $table->string('card_number', 20)->nullable(); // หมายเลขบัตร
            $table->date('expiry_date')->nullable();       // วันหมดอายุ

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_cards');
    }
};
