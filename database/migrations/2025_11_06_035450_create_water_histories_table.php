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
        Schema::create('water_histories', function (Blueprint $table) {
            $table->id();

            // อ้างอิงไปยังตาราง water_locations
            $table->foreignId('water_location_id')
                ->nullable()
                ->constrained('water_locations')
                ->nullOnDelete(); // ถ้าต้นทางโดนลบ ให้เป็น null

            $table->integer('old_miter')->nullable();      // ค่ามิเตอร์เก่า
            $table->integer('update_miter')->nullable();   // ค่ามิเตอร์ใหม่
            $table->timestamp('updateAt')->useCurrent();   // วันที่อัปเดต
            $table->foreignId('updateBy')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete(); // ผู้ที่ทำการอัปเดต (nullable เผื่อ user ถูกลบ)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_histories');
    }
};
