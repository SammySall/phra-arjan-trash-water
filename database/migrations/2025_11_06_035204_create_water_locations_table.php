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
        Schema::create('water_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ชื่อสถานที่หรือชื่อจุดใช้น้ำ
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade'); // เจ้าของ มาจาก users
            $table->integer('old_miter')->nullable(); // ค่าเดิมของมิเตอร์น้ำ
            $table->integer('new_miter')->nullable(); // ค่าปัจจุบันของมิเตอร์น้ำ
            $table->string('water_user_no')->nullable(); // หมายเลขผู้ใช้น้ำ
            $table->text('address')->nullable(); // ที่อยู่
            $table->string('branch')->nullable(); // สาขาหรือเขต
            $table->boolean('active')->default(true); // ✅ สถานะการใช้งาน (ค่าเริ่มต้น = true)
            $table->timestamps(); // created_at และ updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_locations');
    }
};
