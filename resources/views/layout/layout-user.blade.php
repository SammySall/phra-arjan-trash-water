<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/garbage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/emergency.css') }}">

</head>

<body class="d-flex flex-column min-vh-100">
    {{-- header --}}
    <header class="header-bg {{ Request::is('user/waste_payment*')||Request::is('user/request/trash_request*') ? 'waste-header' : 'water-header' }} pt-2 pb-4">
        <div class="container d-flex flex-column flex-lg-row justify-content-between align-items-center">
            <div class="d-flex justify-content-center align-items-center text-decoration-none gap-2">
                {{-- รูปโลโก้ --}}
                <img src="{{ url('../img/menuuser/LOGO.png') }}" alt="LOGO" class="img-fluid logo-img">
                {{-- ข้อความข้างโลโก้ --}}
                <div class="d-flex flex-column justify-content-center align-items-start" style="line-height: 1;">
                    <div class="title-header">
                        องค์กรบริหารส่วนตำบลพระอาจารย์
                    </div>
                    <div class="mb-2 title-sub-header">
                        Pha Achan Subdistrist Administrative Organization
                    </div>
                    <div class="sub-title-header">ระบบยื่นคำร้องออนไลน์ <img src="{{ url('../img/menuuser/OSS.png') }}"
                            alt="" class="img-fluid logo-img"></div>
                </div>
            </div>
            {{-- ปุ่มล็อกอินและสมัครสมาชิก --}}
            <div class="d-flex flex-column justify-content-center align-items-center mt-3 mt-lg-0">
                @php
                    use Illuminate\Support\Facades\Crypt;

                    $userData = null;
                    if (session('token')) {
                        try {
                            $decoded = json_decode(Crypt::decryptString(session('token')), true);
                            $userData = $decoded;
                        } catch (\Exception $e) {
                            $userData = null;
                        }
                    }
                @endphp

                @if ($userData)
                    <div class="mb-1 font-bottom-login">
                        ผู้ใช้งาน : {{ $userData['name'] ?? 'ผู้ใช้งาน' }}
                    </div>
                @endif

                <div class="d-flex justify-content-center align-items-center gap-2">
                    @if (session('token'))
                        {{-- Logout --}}

                        <div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="btn p-0 border-0 bg-transparent">
                                <img src="../../../../img/menuuser/Logout-Button.png" alt="Logout"
                                    class="img-fluid btn-hover-effect">
                            </button>
                        </form>
                    @else
                        {{-- Login / Register --}}
                        <a href="/login" class="text-center me-3">
                            <img src="../../../img/menuuser/Login.png" alt="login"
                                class="img-fluid btn-hover-effect">
                        </a>
                        <a href="/register" class="text-center">
                            <img src="../../../img/menuuser/Register.png" alt="register"
                                class="img-fluid btn-hover-effect" height="46.13px">
                        </a>
                    @endif
                </div>
                @if (!session('token'))
                    <div class="text-warn mt-2 text-center font-bottom-login">
                        <strong>*คำแนะนำ*</strong>สมัครสมาชิกเพื่อติดตามสถานะการดำเนินการ
                    </div>
                @endif
            </div>

    </header>

    {{-- content --}}
    <main>
        <div class="@yield('body-class', 'body-bg') {{ Request::is('user/waste_payment*') ? 'waste-body' : 'water-body' }} p-2">
            @yield('content')
        </div>
    </main>

    {{-- footer --}}
    <footer class="footer-bg {{ Request::is('user/waste_payment*')||Request::is('user/request/trash_request*') ? 'waste-footer' : 'water-footer' }} pt-2 pb-4">
        <div class="container d-flex flex-column justify-content-center align-items-center">
            <div class="title-footer">องค์กรบริหารส่วนตำบลพระอาจารย์</div>
            <div class="d-flex flex-column-reverse flex-md-row justify-content-center align-items-center gap-3 pt-2">
                {{-- ที่อยู่ --}}
                <div class="footer-location me-3">
                    <img src="../../../img/menuuser/icon-1.png" alt="home">
                    ถนนคลองหกวา หมู่ที่ 5 ตำบลพระอาจารย์ อ.องครักษ์ จ.นครนายก 26120
                </div>
                {{-- เบอร์โทรติดต่อ --}}
                <div class="footer-location">
                    <img src="../../../img/menuuser/icon-2.png" alt="phone">
                    037-310559
                </div>
            </div>
        </div>
    </footer>

</body>

</html>

<style>
    .search-menu {
        border: none;
        outline: none;
        box-shadow: none;
        background: transparent;
    }

    .avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.375rem;
        height: 2.375rem;
        cursor: pointer;
    }

    .avatar i {
        width: 100%;
        height: auto;
        font-size: 2.375rem;
    }
</style>
