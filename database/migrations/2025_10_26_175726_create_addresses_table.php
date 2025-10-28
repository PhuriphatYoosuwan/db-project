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
         Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            // เชื่อมกับ users (1:1)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // ฟิลด์ที่อยู่แบบไทย
            $table->string('province')->nullable();      // จังหวัด
            $table->string('district')->nullable();      // อำเภอ
            $table->string('sub_district')->nullable();  // ตำบล
            $table->string('postal_code', 10)->nullable(); // รหัสไปรษณีย์

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
