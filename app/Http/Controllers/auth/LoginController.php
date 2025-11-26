<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    // ✅ แสดงหน้า login
    public function showLoginForm(Request $request)
    {
        // เก็บ URL เดิม (ก่อนเข้า login) ไว้ใน session แค่ครั้งเดียว
        if (!Session::has('url.intended') && url()->previous() !== url('/login')) {
            Session::put('url.intended', url()->previous());
        }

        return view('auth.login');
    }

    // ✅ ตรวจสอบการล็อกอิน
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            $user = Auth::user();

            // สร้าง session token
            $sessionKey = Str::random(20);
            $tokenData = [
                'userId' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
                'position' => $user->user_position,
                'address' => $user->address,
                'session_key' => $sessionKey,
                'login_at' => now()->toDateTimeString(),
            ];
            $encryptedToken = Crypt::encryptString(json_encode($tokenData));

            $user->api_token = $encryptedToken;
            $user->save();
            session(['token' => $encryptedToken]);

            // ✅ ดึง URL ก่อนหน้า (ถ้ามี)
            $previousUrl = Session::pull('url.intended', '/');

            // ✅ redirect ตาม role
            if (str_contains($user->role, 'admin-trash')) {
                return redirect('/admin/waste_payment');
            } elseif (str_contains($user->role, 'admin-water')) {
                return redirect('/admin/waterworks/showdata');
            } elseif(str_contains($user->role, 'meter-filler')){
                return redirect('/admin/waterworks/manage-water');
            }elseif ($user->role === 'user') {

                // 🔥 ถ้ามาจาก register → ใช้ URL ก่อน register แทน
                if (str_contains($previousUrl, '/register')) {
                    $previousUrl = Session::pull('before_register', '/user/waterworks');
                }
                // 🔥 ส่งกลับไปยังหน้าที่อยู่จริงก่อนสมัคร
                if ($previousUrl && $previousUrl !== url('/login')) {
                    return redirect($previousUrl);
                }
                // fallback
                return redirect('/user/waterworks');
            }



            // fallback
            return redirect('/user/waterworks'); // หรือหน้า home ของ user
        }

        return back()->with('error', 'อีเมลหรือรหัสผ่านไม่ถูกต้อง');
    }

    // ✅ ออกจากระบบ
    public function logout(Request $request)
    {
        $previousUrl = url()->previous();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ตรวจสอบ path ก่อน logout แล้ว redirect ไปยัง path ที่เหมาะสม
        if (preg_match('/\/water/', $previousUrl)) {
            return redirect('/user/waterworks');
        } else {
            return redirect('/user/waste_payment');
        }

        return redirect('/homepage');
    }
}
