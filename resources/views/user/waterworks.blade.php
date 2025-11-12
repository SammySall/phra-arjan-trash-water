@extends('layout.layout-user')
@section('title', 'Waterworks Page')
@section('body-class', 'body-waterworks-bg')
@section('content')
    <div class="container">
        <div class="row">
            {{-- <a href="/homepage" class="mt-4">
                <img src="../img/water-menu-page/Back-Button.png" alt="ปุ่มกลับ" class="back-garbage-btn">
            </a> --}}
            <div class="row g-3 text-center justify-content-center">
                <div class="col-6 col-md-3">
                    <a href="/user/water_payment/statistics">
                        <img src="../img/water-menu-page/Banner-1.png" alt="สถิติการใช้น้ำ" class="img-fluid link-garbage-btn">
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="/user/water_payment/check-payment">
                        <img src="../img/water-menu-page/Banner-2.png" alt="ข้อมูลการชำระเงิน" class="img-fluid link-garbage-btn">
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="/user/waterworks/emergency/water-leak">
                        <img src="../img/water-menu-page/Banner-3.png" alt="แจ้งเหตุ" class="img-fluid link-garbage-btn">
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
