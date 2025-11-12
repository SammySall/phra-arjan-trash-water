<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // ✅ ลบตารางเก่าก่อนสร้างใหม่
        Schema::dropIfExists('trash_locations');
        Schema::dropIfExists('bills');
        Schema::dropIfExists('users');

        // ✅ เปิดการตรวจสอบกลับคืน
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address');
            $table->string('tel', 10)->nullable();
            $table->string('id_card', 13)->nullable();
            $table->enum('role', ['admin-trash', 'admin-e-service','admin-emergency','admin-engineer','admin-health', 'user','admin-request','admin-water'])->default('user');
            $table->rememberToken();
            $table->timestamps();
            $table->text('api_token')->nullable();
        });

        DB::table('users')->insert([
            [
                'name' => 'Admin Trash',
                'email' => 'admin0@eservice.go.th',
                'password' => Hash::make('123456789'),
                'address' => '123/45',
                'tel' => '0000000000',
                'id_card' => '1111111111111',
                'role' => 'admin-trash',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin E-Service',
                'email' => 'admin01@eservice.go.th',
                'password' => Hash::make('123456789'),
                'address' => '67/78',
                'tel' => '0000000000',
                'id_card' => '1111111111111',
                'role' => 'admin-e-service',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Admin Emergency',
                'email' => 'admin05@eservice.go.th',
                'password' => Hash::make('123456789'),
                'address' => '67/78',
                'tel' => '0000000000',
                'id_card' => '1111111111111',
                'role' => 'admin-emergency',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin health',
                'email' => 'admin04@eservice.go.th',
                'password' => Hash::make('123456789'),
                'address' => '67/78',
                'tel' => '0000000000',
                'id_card' => '1111111111111',
                'role' => 'admin-health',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'นายเก้า อดิศร',
                'email' => 'users01@example.com',
                'password' => Hash::make('123456789'),
                'address' => '123 หมู่ 5',
                'tel' => '0000000000',
                'id_card' => '1111111111111',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Engineer',
                'email' => 'admin03@eservice.go.th',
                'password' => Hash::make('123456789'),
                'address' => '123 หมู่ 5',
                'tel' => '0000000000',
                'id_card' => '1111111111111',
                'role' => 'admin-engineer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Water',
                'email' => 'admin09@eservice.go.th',
                'password' => Hash::make('123456789'),
                'address' => '123 หมู่ 5',
                'tel' => '0000000000',
                'id_card' => '1111111111111',
                'role' => 'admin-water',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
