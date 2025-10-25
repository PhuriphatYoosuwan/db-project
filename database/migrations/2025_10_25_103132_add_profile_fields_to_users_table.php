<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone',30)->nullable()->after('email');
            $table->enum('gender',['male','female','others'])->nullable()->after('phone');
            $table->date('dob')->nullable()->after('gender');
            $table->string('avatar_path')->nullable()->after('dob');
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone','gender','dob','avatar_path']);
        });
    }
};
