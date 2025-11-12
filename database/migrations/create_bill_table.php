<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('type');

            // FK ไป trash_locations
            $table->foreignId('trash_location_id')
                ->nullable()
                ->default(null)
                ->constrained('trash_locations')
                ->nullOnDelete();

            // FK ไป water_locations
            $table->foreignId('water_location_id')
                ->nullable()
                ->default(null)
                ->constrained('water_locations')
                ->nullOnDelete();

            // FK ไป users
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->decimal('amount', 10, 2);
            $table->enum('status', ['ยังไม่ชำระ', 'รอการตรวจสอบ', 'ชำระแล้ว'])
                ->default('ยังไม่ชำระ');
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->text('slip_path')->nullable();
            $table->timestamps();
        });

        // ✅ ปิด foreign key checks ชั่วคราว
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // ✅ ตรวจสอบว่ามี user, trash_location, water_location หรือยัง ถ้าไม่มีก็สร้างจำลอง
        if (!DB::table('users')->where('id', 5)->exists()) {
            DB::table('users')->insert([
                'id' => 5,
                'name' => 'Demo User',
                'email' => 'demo@example.com',
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if (!DB::table('trash_locations')->where('id', 1)->exists()) {
            DB::table('trash_locations')->insert([
                'id' => 1,
                'name' => 'พื้นที่ขยะตัวอย่าง',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if (!DB::table('water_locations')->where('id', 1)->exists()) {
            DB::table('water_locations')->insert([
                'id' => 1,
                'name' => 'พื้นที่น้ำตัวอย่าง',
                'owner_id' => 5,
                'old_miter' => 100,
                'new_miter' => 120,
                'water_user_no' => 'W001',
                'address' => '123/4 ตำบลท่าข้าม',
                'branch' => 'สาขากลาง',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ✅ Insert ตัวอย่างบิล
        DB::table('bills')->insert([
            [
                'trash_location_id' => 1,
                'water_location_id' => null,
                'type' => 'trash-request',
                'user_id' => 5,
                'amount' => 2000.00,
                'status' => 'ยังไม่ชำระ',
                'due_date' => '2025-10-28',
                'paid_date' => null,
                'slip_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'trash_location_id' => null,
                'water_location_id' => 1,
                'type' => 'water-request',
                'user_id' => 5,
                'amount' => 1500.00,
                'status' => 'ยังไม่ชำระ',
                'due_date' => '2025-10-28',
                'paid_date' => null,
                'slip_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ✅ เปิดกลับ
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
