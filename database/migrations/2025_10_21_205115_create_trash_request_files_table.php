<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trash_request_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trash_request_id')->constrained('trash_requests')->onDelete('cascade');
            $table->string('field_name'); // เช่น files1, files2
            $table->string('file_path');  // path ของไฟล์
            $table->string('file_name');  // ชื่อไฟล์จริง
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trash_request_files');
    }
};
