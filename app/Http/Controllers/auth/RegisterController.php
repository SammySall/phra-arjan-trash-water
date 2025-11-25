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
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
        ]);

        // รวมที่อยู่
        $fullAddress = "{$validated['address']} ต.{$validated['subdistrict']} อ.{$validated['district']} จ.{$validated['province']}";

        // ใช้ email หรือ phone เป็น email
        $loginEmail = $request->email ? $request->email : $request->tel;

        // ตรวจสอบซ้ำ
        if (User::where('email', $loginEmail)->exists()) {
            return back()->withErrors(['email' => 'อีเมล/เบอร์นี้มีผู้ใช้งานแล้ว'])->withInput();
        }

        // บันทึก
        User::create([
            'name' => "{$validated['salutation']} {$validated['name']}",
            'email' => $loginEmail,
            'password' => Hash::make($validated['password']),
            'address' => $fullAddress,
            'role' => 'user',
        ]);

        return redirect('/login')->with('success', 'สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ');
    }

}
