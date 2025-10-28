<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // เคลียร์ค่าเดิมเพื่อป้องกัน error “Data too long”
        DB::table('credit_cards')->update(['expiry_date' => null]);

        // เปลี่ยนชนิดคอลัมน์เป็น string(7)
        Schema::table('credit_cards', function (Blueprint $table) {
            $table->string('expiry_date', 7)->nullable()->change();
        });
    }

    public function down(): void
    {
        // เปลี่ยนกลับเป็น date ถ้าต้อง rollback
        Schema::table('credit_cards', function (Blueprint $table) {
            $table->date('expiry_date')->nullable()->change();
        });
    }
};
