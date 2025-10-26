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
        Schema::create('products', function (Blueprint $table) {
            $table->id();                    // product_id
            $table->foreignId('category_id') // เชื่อมกับ category
                ->constrained()           // หมายถึง references id on categories
                ->onDelete('cascade');    // ถ้า category ถูกลบ product ก็ถูกลบ
            $table->string('name');          // ชื่อสินค้า
            $table->integer('price'); // ราคาสินค้า
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
