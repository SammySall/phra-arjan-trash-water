@extends('layout.layout-user')
@section('title', 'Trash Bank')
@section('body-class', 'body-garbage-bg')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/bank.css') }}">

    <div class="container py-4">
        <div class="row">
            <!-- Sidebar / Banner -->
            <div class="col-md-2">
                <div>
                    <a href="/user/waste_payment">
                        <img src="../../img/ToxicTrash/Back-Button.png" alt="ปุ่มกลับ" class="back-garbage-btn mb-4">
                    </a>
                </div>
            </div>

            <!-- Main content -->
            <div class="col-md-10 bg-body-secondary payment-bg text-black">
                <table class="table table-bordered table-striped mt-2 text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>วันที่</th>
                            <th>ประเภท</th>
                            <th>ประเภทย่อย</th>
                            <th>น้ำหนัก (kg)</th>
                            <th>จำนวนเงิน (บาท)</th>
                            <th>ผู้ฝาก</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trashBanks as $item)
                            <tr>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->subtype ?? '-' }}</td>
                                <td>{{ $item->weight }}</td>
                                <td>{{ number_format($item->amount, 2) }}</td>
                                <td>{{ $item->depositor }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">ไม่มีข้อมูล</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- ยอดรวมแยกออกมา -->
                <div class="mt-3 p-5 sum-bg">
                    <h3 class="mt-3">ยอดรวม: <strong>{{ number_format($trashBanks->sum('amount'), 2) }} บาท</strong></h3>
                </div>


                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $trashBanks->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
