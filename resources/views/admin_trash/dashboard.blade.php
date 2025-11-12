@extends('layout.layout-admin-trash')
@section('title', 'Dashboard Waste Payment')

@section('desktop-content')
    <div class="row bg-white bg-opacity-75 p-3 rounded-3 shadow-sm">
        <div class="col-md-4">
            <div class="complete-bg-img text-center">
                <div class="d-inline-flex align-items-center text-title-dashboard-bg justify-content-center p-2 rounded ">
                    <h5 class=" me-2">ใบเสร็จที่ชำระเงินแล้ว</h5>
                    <img src="{{ url('../img/trash-system/icon-10.png') }}" alt="icon-7" class="img-fluid"
                        style="height: 40px;">
                </div>
                <div class="text-number-dashboard">{{ number_format($paidCount) }}</div>
                <div><a href="{{ route('admin.payment_history') }}"> <img
                            src="{{ url('../img/trash-system/Button-1.png') }}" alt="icon-7" class="img-fluid"
                            style="height: 30px;"></a>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="missed-bg-img text-center">
                <div class="d-inline-flex align-items-center text-title-dashboard-bg justify-content-center p-2 rounded ">
                    <h5 class=" me-2">ใบเสร็จที่ขาดชำระเงิน</h5>
                    <img src="{{ url('../img/trash-system/icon-11.png') }}" alt="icon-7" class="img-fluid"
                        style="height: 40px;">
                </div>
                <div class="text-number-dashboard">{{ number_format($unpaidCount) }}</div>
                <div><a href="{{ route('admin.payment_history') }}"> <img
                            src="{{ url('../img/trash-system/Button-1.png') }}" alt="icon-7" class="img-fluid"
                            style="height: 30px;"></a>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="wait-bg-img text-center">
                <div class="d-inline-flex align-items-center text-title-dashboard-bg justify-content-center p-2 rounded ">
                    <h5 class=" me-2">รอตรวจสอบการชำระ</h5>
                    <img src="{{ url('../img/trash-system/icon-8.png') }}" alt="icon-7" class="img-fluid"
                        style="height: 40px;">
                </div>
                <div class="text-number-dashboard">{{ number_format($unpaidCount) }}</div>
                <div><a href="{{ route('admin.payment_history') }}"> <img
                            src="{{ url('../img/trash-system/Button-1.png') }}" alt="icon-7" class="img-fluid"
                            style="height: 30px;"></a>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('mobile-content')
    <div class="row">
        <div class="col-md-4 bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">
            <div class="complete-bg-img text-center">
                <div class="d-inline-flex align-items-center text-title-dashboard-bg justify-content-center p-2 rounded ">
                    <h5 class=" me-2">ใบเสร็จที่ชำระเงินแล้ว</h5>
                    <img src="{{ url('../img/trash-system/icon-10.png') }}" alt="icon-7" class="img-fluid"
                        style="height: 40px;">
                </div>
                <div class="text-number-dashboard">{{ number_format($paidCount) }}</div>
                <div><a href="{{ route('admin.payment_history') }}"> <img
                            src="{{ url('../img/trash-system/Button-1.png') }}" alt="icon-7" class="img-fluid"
                            style="height: 30px;"></a>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="missed-bg-img text-center">
                <div class="d-inline-flex align-items-center text-title-dashboard-bg justify-content-center p-2 rounded ">
                    <h5 class=" me-2">ใบเสร็จที่ขาดชำระเงิน</h5>
                    <img src="{{ url('../img/trash-system/icon-11.png') }}" alt="icon-7" class="img-fluid"
                        style="height: 40px;">
                </div>
                <div class="text-number-dashboard">{{ number_format($unpaidCount) }}</div>
                <div><a href="{{ route('admin.payment_history') }}"> <img
                            src="{{ url('../img/trash-system/Button-1.png') }}" alt="icon-7" class="img-fluid"
                            style="height: 30px;"></a>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="wait-bg-img text-center">
                <div class="d-inline-flex align-items-center text-title-dashboard-bg justify-content-center p-2 rounded ">
                    <h5 class=" me-2">รอตรวจสอบการชำระ</h5>
                    <img src="{{ url('../img/trash-system/icon-8.png') }}" alt="icon-7" class="img-fluid"
                        style="height: 40px;">
                </div>
                <div class="text-number-dashboard">{{ number_format($unpaidCount) }}</div>
                <div><a href="{{ route('admin.payment_history') }}"> <img
                            src="{{ url('../img/trash-system/Button-1.png') }}" alt="icon-7" class="img-fluid"
                            style="height: 30px;"></a>

                </div>
            </div>
        </div>
    </div>
@endsection
