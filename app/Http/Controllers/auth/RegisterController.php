<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // แสดงหน้า Register
    public function showRegisterForm()
    {
        return view('auth.register'); // ให้ตรงกับไฟล์ blade ที่คุณมี
    }

    // ฟังก์ชันบันทึกข้อมูลลง DB
    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:9|confirmed',
            'salutation' => 'required',
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'tel' => 'required|digits:10',
            'address' => 'required|string',
            'province' => 'required|string',
            'district' => 'required|string',
            'subdistrict' => 'required|string',
        ], [
            'email.unique' => 'อีเมลนี้มีผู้ใช้งานแล้ว',
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
        ]);

        // รวมที่อยู่ทั้งหมดให้เป็นข้อความเดียว
        $fullAddress = "{$validated['address']} ต.{$validated['subdistrict']} อ.{$validated['district']} จ.{$validated['province']}";

        // ✅ บันทึกข้อมูล
        User::create([
            'name' => "{$validated['salutation']} {$validated['name']}",
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'address' => $fullAddress,
            'role' => 'user',
        ]);

        return redirect('/login')->with('success', 'สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ');
    }
}
