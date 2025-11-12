<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('trash_requests', function (Blueprint $table) {
            $table->foreignId('water_location_id')->nullable()->constrained('water_locations')->nullOnDelete()->after('trash_location_id');
        });
    }

    public function down(): void
    {
        Schema::table('trash_requests', function (Blueprint $table) {
            $table->dropForeign(['water_location_id']);
            $table->dropColumn('water_location_id');
        });
    }
};
