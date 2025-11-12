<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emergencies', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // ประเภทเหตุการณ์: accident, fire, tree-fall
            $table->string('name'); // ชื่อผู้แจ้ง
            $table->string('tel'); // เบอร์โทร
            $table->text('description')->nullable(); // รายละเอียด
            $table->string('picture')->nullable(); // path รูป
            $table->decimal('lat', 10, 7)->nullable(); // ละติจูด
            $table->decimal('lng', 10, 7)->nullable(); // ลองจิจูด
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emergencies');
    }
};
