<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * สร้างตาราง products สำหรับเก็บข้อมูลสินค้าแต่ละชิ้น
     * โดยเชื่อมกับตาราง categories ผ่าน category_id
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // FK → อ้างอิงหมวดหมู่ (เชื่อมกับ categories.id)
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->cascadeOnDelete(); // ลบหมวดแล้วลบสินค้าตาม

            // ชื่อสินค้า เช่น "Dog Toy", "Laptop Bag"
            $table->string('name');

            // รายละเอียดสินค้า (optional)
            $table->text('description')->nullable();

            // ราคาเก็บเป็น "สตางค์" เพื่อป้องกันปัญหา floating point
            // เช่น 199.00 บาท → 19900
            $table->unsignedInteger('price_cents');

            // จำนวนสินค้าในสต็อก
            $table->unsignedInteger('stock')->default(0);

            // เส้นทางรูปภาพ (เช่น 'products/dogtoy.jpg')
            $table->string('image_path')->nullable();

            // วันเวลา created_at / updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * ลบตาราง products กรณี rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
