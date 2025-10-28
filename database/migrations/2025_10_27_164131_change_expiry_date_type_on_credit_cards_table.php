<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // อัปเดต: เปลี่ยนจาก date -> string(7) เพื่อเก็บรูปแบบ MM/YY หรือ MM/YYYY
    public function up(): void
    {
        DB::table('credit_cards')->update(['expiry_date' => null]);

        Schema::table('credit_cards', function (Blueprint $table) {
            $table->string('expiry_date', 10)->nullable()->change(); // ให้ยาวขึ้นนิดเพื่อรองรับ YYYY-MM
        });
    }

    // ย้อนกลับ: เปลี่ยนกลับเป็น date (ถ้าจำเป็น)
    // หมายเหตุ: ถ้าในฐานข้อมูลมีค่าเป็น 'MM/YY' จะ cast กลับเป็น date ไม่ได้ อาจต้องลบ/แปลงค่าก่อน
    public function down(): void
    {
        Schema::table('credit_cards', function (Blueprint $table) {
            $table->date('expiry_date')->nullable()->change();
        });
    }
};
