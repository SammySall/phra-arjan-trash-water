<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WaterLocation;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UserImportController extends Controller
{
    public function importExcel()
    {
        ini_set('max_execution_time', 300); // 300 วินาที (5 นาที)
        // 1) ระบุ path ของไฟล์ใน storage
        $filePath = storage_path('app/import/ข้อมูลที่ต้องการเพิ่มเติม อบต.พระอาจารย์.xlsx');

        // 2) โหลดไฟล์ Excel
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        // 3) นับสำหรับสร้าง email
        $counter = 1;

        // 4) Loop ข้อมูล (ข้ามแถวหัวตาราง)
        foreach ($rows as $index => $row) {

            if ($index == 1) continue; // ข้าม header

            // ปรับคอลัมน์ตาม Excel จริง เช่น A=คำนำหน้า, B=ชื่อ, C=ที่อยู่
            $prefix   = trim($row['B']);
            $fullname = trim($row['C']);
            $address  = trim($row['E']);

            if (!$fullname) continue; // ถ้าว่าง ข้าม

            // 5) ชื่อที่ใช้เก็บใน water_locations (ไม่เอาคำนำหน้า + เอาเฉพาะชื่อจริง)
            $onlyName = str_replace([$prefix, " "], "", $fullname);

            // 6) สร้างอีเมล userXX
            $email = "user" . str_pad($counter, 2, "0", STR_PAD_LEFT);

            // 7) บันทึก USER
            $user = User::create([
                'name'      => $prefix . $fullname,
                'email'     => $email,
                'password'  => Hash::make("123456789"),
                'address'   => $address,
            ]);

            // 8) บันทึก water_locations
            WaterLocation::create([
                'name'      => $onlyName,
                'owner_id'  => $user->id,
                'address'   => $address,
                'active'    => 1,
            ]);

            $counter++;
        }

        return "นำเข้าข้อมูลสำเร็จ!";
    }
}
