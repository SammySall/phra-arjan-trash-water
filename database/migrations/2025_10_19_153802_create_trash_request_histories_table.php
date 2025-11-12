<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('trash_request_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trash_request_id')->constrained('trash_requests')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // คนตอบกลับ
            $table->text('message')->nullable();
            $table->string('status_after')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trash_request_histories');
    }
};
