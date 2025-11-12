@extends('layout.layout-user')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/menurequest.css') }}">

    <div class="container mt-3">
        <div>
            <a href="@yield('back-button', '/')">
                <img src="{{ asset('img/ToxicTrash/Back-Button.png') }}" alt="ปุ่มกลับ" class="back-garbage-btn mb-4">
            </a>
        </div>

        {{-- ✅ layout สลับอัตโนมัติ --}}
        <div class="row g-0 flex-wrap">

            {{-- ✅ เมนู (อยู่บนเมื่อจอเล็ก อยู่ซ้ายเมื่อจอใหญ่) --}}
            <nav class="menu-list col-12 col-md-4 col-lg-3 order-1 order-md-1 mb-4 mb-md-0">
                <ul>
                    <li class="menu-item has-sub">
                        <a href="#">กองสาธารณสุขฯ</a>
                        <ul class="submenu">
                            <li class="has-sub-sub">
                                <a href="#">คำร้องขออนุญาตลงถังขยะ</a>
                                <ul class="submenu-sub">
                                    <li><a href="/user/request/trash_request">แบบฟอร์มคำร้อง</a></li>
                                    <li><a href="/user/request/history_request/trash-request">ประวัติการส่งคำร้อง</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            {{-- ✅ เนื้อหา --}}
            <div class="col-12 col-md-8 col-lg-9 request-content order-2 order-md-2">
                @if (Request::is('user/request/history_request*'))
                    <div class="form-content my-3 mx-2">
                        <div class="p-3 pb-4">
                            @yield('request-content')
                        </div>
                    </div>
                @else
                    <img src="{{ asset('img/banner-request/' . $__env->yieldContent('request-header-img') . '.png') }}"
                        alt="banner-request" class="img-fluid mb-3 px-3 px-md-5">
                    <div class="form-content mb-3 mx-2 mx-md-5">
                        <div class="text-center">
                            <h4 class="header-form-name my-2 mx-4">
                                @yield('request-header')
                            </h4>
                        </div>
                        <div class="px-3 px-md-5 pb-4">
                            @yield('request-content')
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ✅ JS สำหรับเปิด/ปิด submenu --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.has-sub-sub > a').forEach(menu => {
                menu.addEventListener('click', function(e) {
                    e.preventDefault();
                    const submenu = this.nextElementSibling;
                    document.querySelectorAll('.submenu-sub').forEach(s => {
                        if (s !== submenu) s.style.maxHeight = null;
                    });
                    submenu.style.maxHeight = submenu.style.maxHeight ? null : submenu
                        .scrollHeight + "px";
                });
            });
        });
    </script>
@endsection
