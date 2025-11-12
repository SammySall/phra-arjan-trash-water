@extends('layout.layout-user')
@section('title', 'Trash Page')
@section('body-class', 'body-garbage-bg')
@section('content')
    <div class="container">
        <div class="row">
            {{-- <a href="/homepage" class="mt-4">
                <img src="../img/Garbage/Back-Button.png" alt="ปุ่มกลับ" class="back-garbage-btn">
            </a> --}}
            <div class="row g-3 text-center justify-content-center">
                <div class="col-6 col-md-3">
                    <a href="/user/waste_payment/status-trash">
                        <img src="../img/Garbage/Button-1.png" alt="ดูสถานะรถขยะ" class="img-fluid link-garbage-btn">
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="/user/waste_payment/trash_bank">
                        <img src="../img/Garbage/Button-4.png" alt="ธนาคารขยะ" class="img-fluid link-garbage-btn">
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="/user/waste_payment/check-payment">
                        <img src="../img/Garbage/Button-2.png" alt="ดูข้อมูลการชำระ" class="img-fluid link-garbage-btn">
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="/user/request/trash_request">
                        <img src="../img/Garbage/Button-4.png" alt="ขอใช้บริการถังขยะ" class="img-fluid link-garbage-btn">
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
