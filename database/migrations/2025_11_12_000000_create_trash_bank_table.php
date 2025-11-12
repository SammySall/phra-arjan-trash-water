<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trash_bank', function (Blueprint $table) {
            $table->id();
            $table->string('type');        // ประเภทขยะ
            $table->string('subtype')->nullable(); // ประเภทย่อย
            $table->float('weight')->default(0);  // น้ำหนัก
            $table->decimal('amount', 10, 2);     // จำนวนเงิน
            $table->string('depositor');          // ผู้ฝาก
            $table->foreignId('creator_id')->nullable()->constrained('users'); // ผู้สร้าง
            $table->timestamps();                 // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trash_bank');
    }
};
