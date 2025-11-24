<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menu-admin-trash.css') }}">
</head>

<body class="d-flex body-bg">

    @php
        $path = request()->path();
        $tokenData = json_decode(\Illuminate\Support\Facades\Crypt::decryptString(session('token')), true);
    @endphp

    <!-- Sidebar -->
    <div class="d-flex flex-column flex-shrink-0 sidebar-bg p-3">
        <img src="{{ url('../img/trash-system/Coin.png') }}" alt="Coin" class="img-fluid logo-img">
        <div class="d-flex flex-column justify-content-center align-items-center mb-3 mb-md-0 text-decoration-none">
            <div>ระบบจัดการค่าบริการจัดการ</div>
            <h1>ขยะมูลฝอย</h1>
        </div>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <a href="/admin/waste_payment"
                    class="nav-link {{ Str::contains($path, 'waste_payment') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-fill pe-2"></i> Dashboard
                </a>
            </li>

            <div class="mt-3 fw-bold">
                <h4>จัดการ <img src="{{ url('../img/trash-system/Manage-icon.png') }}" alt="Manage-icon"
                        class="img-fluid logo-img"></h4>
            </div>

            <li>
                <a href="/admin/showdata" class="nav-link {{ Str::contains($path, 'showdata') ? 'active' : '' }}">
                    <img src="{{ url('../img/trash-system/icon-1.png') }}" alt="icon-1" class="img-fluid logo-img">
                    ข้อมูลฟอร์มที่ส่งเข้ามา
                </a>
            </li>

            <li>
                <a href="/admin/trash_can_installation"
                    class="nav-link {{ Str::contains($path, 'trash_can_installation') ? 'active' : '' }}">
                    <img src="{{ url('../img/trash-system/icon-3.png') }}" alt="icon-3" class="img-fluid logo-img">
                    ตำแหน่งที่ติดตั้งถังขยะ
                </a>
            </li>

            <li>
                <a href="/admin/trash_installer"
                    class="nav-link {{ Str::contains($path, 'trash_installer') ? 'active' : '' }}">
                    <img src="{{ url('../img/trash-system/icon-2.png') }}" alt="icon-2" class="img-fluid logo-img">
                    ผู้ใช้บริการติดตั้งถังขยะ
                </a>
            </li>

            <li>
                <a href="/admin/trash_bank" class="nav-link {{ Str::contains($path, 'trash_bank') ? 'active' : '' }}">
                    <img src="{{ url('../img/trash-system/Waste-Bank-Icon.png') }}" alt="icon-2"
                        class="img-fluid logo-img" width="32px">
                    ธนาคารขยะ
                </a>
            </li>

            @if (isset($tokenData['role']) && $tokenData['role'] === 'admin-trash-head')
                <li>
                    <a href="/admin/approve_bill"
                        class="nav-link {{ Str::contains($path, 'approve_bill') ? 'active' : '' }}">
                        <img src="{{ url('../../img/admin-water/Icon-6.png') }}" alt="icon-3"
                            class="img-fluid logo-img" style="width: 20px;">
                        อนุมัติใบเสร็จ
                    </a>
                </li>
            @endif

            <div class="mt-3 fw-bold">
                <h4>รายงาน <img src="{{ url('../img/trash-system/Report-icon.png') }}" alt="Manage-icon"
                        class="img-fluid logo-img"></h4>
            </div>

            <li>
                <a href="/admin/verify_payment"
                    class="nav-link {{ Str::contains($path, 'verify_payment') ? 'active' : '' }}">
                    <img src="{{ url('../img/trash-system/icon-7.png') }}" alt="icon-7" class="img-fluid logo-img">
                    ตรวจสอบการชำระเงิน
                </a>
            </li>

            <li>
                <a href="/admin/payment_history"
                    class="nav-link {{ Str::contains($path, 'payment_history') ? 'active' : '' }}">
                    <img src="{{ url('../img/trash-system/icon-6.png') }}" alt="icon-6" class="img-fluid logo-img">
                    ประวัติการชำระเงิน
                </a>
            </li>

            <li>
                <a href="/admin/non_payment"
                    class="nav-link {{ Str::contains($path, 'non_payment') ? 'active' : '' }}">
                    <img src="{{ url('../img/trash-system/icon-5.png') }}" alt="icon-5" class="img-fluid logo-img">
                    บิลที่รอการชำระเงิน
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="p-4 flex-grow-1">

        {{-- search bar + Hamburger --}}
        <div class="bg-white my-4 p-2 rounded-3 d-flex align-items-center justify-content-end">
            <button class="btn btn-outline-secondary d-md-none me-2" id="hamburger-btn">
                <i class="bi bi-list fs-3"></i>
            </button>

            <div class="nav-item dropdown">
                <a class="nav-link avatar" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    @if (session('token'))
                        <li class="dropdown-item-text d-flex align-items-end gap-2">
                            <i class="bi bi-person-circle"></i>
                            <span>{{ $tokenData['name'] }}</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    @else
                        <li><a class="dropdown-item" href="/login">Login</a></li>
                        <li><a class="dropdown-item" href="/register">Register</a></li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- Content --}}
        <!-- Mobile -->
        <div class="mobile-only content-trash-bg rounded-3">
            <div class="container py-3">
                <div class="bg-white bg-opacity-75 p-3 rounded-3 shadow-sm">
                    @yield('mobile-content')
                </div>
            </div>
        </div>

        <!-- Desktop -->
        <div class="container-fluid content-trash-bg desktop-only">
            <div class="row">
                <div class="col-12 p-5">
                    @yield('desktop-content')
                </div>
            </div>
        </div>

    </div>

    {{-- JS Sidebar Hamburger --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar-bg');
            const hamburgerBtn = document.getElementById('hamburger-btn');

            // toggle sidebar
            hamburgerBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                document.body.classList.toggle('overlay-active');
            });

            // click outside to close
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(e.target) && !hamburgerBtn.contains(e.target)) {
                        sidebar.classList.remove('active');
                        document.body.classList.remove('overlay-active');
                    }
                }
            });
        });
    </script>

</body>

</html>
