<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * สร้างตาราง categories สำหรับเก็บหมวดหมู่สินค้า
     * เช่น Pets, Bags, Tools, etc.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // ชื่อหมวดหมู่ เช่น "Pets", "Bags"
            $table->string('name');

            // slug สำหรับใช้ใน URL เช่น "pets", "bags"
            $table->string('slug')->unique();

            // รายละเอียดเพิ่มเติม (optional)
            $table->text('description')->nullable();

            // วันเวลา created_at / updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * ลบตาราง categories ถ้าต้องการ rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
