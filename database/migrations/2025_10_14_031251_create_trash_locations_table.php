<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {

        // ✅ สร้างตารางใหม่
        Schema::create('trash_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->enum('status', ['เสร็จสิ้น', 'รออนุมัติเรียกชำระเงิน']);
            $table->string('tel', 10)->default('0634461165');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); 
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->timestamps();
        });

        // ✅ ใส่ข้อมูลตัวอย่าง
        DB::table('trash_locations')->insert([
            [
                'id' => 1,
                'name' => 'ทดสอบบบ',
                'address' => 'ที่อยู่ ุ66 หมู่ที่ 5 ต.แสนภูดาษ อ.บ้านโพธิ จ.ฉะเชิงเทรา',
                'status' => 'เสร็จสิ้น',
                'tel' => '0634461165',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'ทอสอบๅๅ',
                'address' => 'ที่อยู่ กถถ หมู่ที่ 5 ต.แสนภูดาษ อ.บ้านโพธิ จ.ฉะเชิงเทรา',
                'status' => 'รออนุมัติเรียกชำระเงิน',
                'tel' => '0634461165',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'TEST',
                'address' => 'ที่อยู่ กถถ หมู่ที่ 5 ต.แสนภูดาษ อ.บ้านโพธิ จ.ฉะเชิงเทรา',
                'status' => 'รออนุมัติเรียกชำระเงิน',
                'tel' => '0634461165',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'TESTT',
                'address' => 'ที่อยู่ กถถ หมู่ที่ 777 ต.แสนภูดาษ อ.บ้านโพธิ จ.ฉะเชิงเทรา',
                'status' => 'เสร็จสิ้น',
                'tel' => '0634461165',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('trash_locations');
    }
};
