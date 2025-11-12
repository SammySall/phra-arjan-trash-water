@extends('layout.layout-admin-trash')

@section('title', 'ประวัติการชำระเงิน')
@section('desktop-content')
    <div class="d-flex flex-column align-items-center">
        <img src="{{ url('../img/trash_verify/1.1.png') }}" alt="icon-5" class="img-fluid logo-img">
        <h3 class="px-2 text-center">ประวัติการชำระเงิน</h3>
    </div>

    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">

        {{-- ฟิลเตอร์ --}}
        <form method="GET" action="{{ route('admin.payment_history') }}">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-6">
                    <label class="d-flex align-items-center">
                        <span class="me-1">แสดง</span>
                        <select name="data_table_length" class="form-select form-select-sm me-1" style="width: auto;">
                            <option value="10">10</option>
                            <option value="40">40</option>
                            <option value="80">80</option>
                            <option value="-1">ทั้งหมด</option>
                        </select>
                        <span>รายการ</span>
                    </label>
                </div>

                <div class="col-sm-12 col-md-6 d-flex justify-content-end">
                    <label class="d-flex align-items-center">
                        <span class="me-2">ค้นหา :</span>
                        <input type="search" name="search" class="form-control form-control-sm"
                            placeholder="ค้นหาที่อยู่..." value="{{ request('search') }}" style="width: auto;"
                            onkeydown="if(event.key === 'Enter'){ this.form.submit(); }">
                    </label>
                </div>
            </div>
        </form>

        {{-- ตารางข้อมูล --}}
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>วันที่ชำระ (ล่าสุด)</th>
                            <th>ที่อยู่</th>
                            <th>ยอดชำระทั้งหมด (บาท)</th>
                            <th>จำนวนรายการ</th>
                            <th>สถานะ</th>
                            <th>รายละเอียด</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($locations as $index => $location)
                            @php
                                $totalAmount = $location->bills->sum('amount');
                                $count = $location->bills->count();
                                $latestPaid = $location->bills->max('paid_date');
                                $hasMissingSlip = $location->bills->contains(function ($bill) {
                                    return is_null($bill->slip_path);
                                });
                            @endphp
                            <tr>
                                <td>{{ ($locations->currentPage() - 1) * $locations->perPage() + $index + 1 }}</td>
                                <td>{{ $latestPaid ? \Carbon\Carbon::parse($latestPaid)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $location->name ?? '-' }}</td>
                                <td>{{ number_format($totalAmount, 2) }}</td>
                                <td>{{ $count }}</td>
                                <td>
                                    @if ($hasMissingSlip)
                                        <img src="{{ url('../img/icon/ยังไม่ชำระ.png') }}" class="img-fluid logo-img"
                                            alt="ยังไม่ชำระ">
                                    @else
                                        <img src="{{ url('../img/icon/เสร็จสิ้น.png') }}" class="img-fluid logo-img"
                                            alt="เสร็จสิ้น">
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.payment_history.detail', $location->id) }}"
                                        class="btn btn-primary btn-sm">ดูใบเสร็จ</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">ไม่มีข้อมูล</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{-- แสดงจำนวนรายการ --}}
                    <div class="text-start mb-2">
                        แสดง {{ $locations->firstItem() ?? 0 }} ถึง {{ $locations->lastItem() ?? 0 }} จาก
                        {{ $locations->total() ?? 0 }} รายการ
                    </div>

                    {{-- ปุ่ม pagination --}}
                    <div class="d-flex justify-content-center">
                        <nav>
                            <ul class="pagination mb-0">
                                {{-- ปุ่มก่อนหน้า --}}
                                @if ($locations->onFirstPage())
                                    <li class="paginate_button page-item previous disabled">
                                        <a class="page-link" href="#"><i class="bi bi-chevron-double-left"></i></a>
                                    </li>
                                @else
                                    <li class="paginate_button page-item previous">
                                        <a class="page-link" href="{{ $locations->previousPageUrl() }}"><i
                                                class="bi bi-chevron-double-left"></i></a>
                                    </li>
                                @endif

                                {{-- หน้าเลข --}}
                                @foreach ($locations->getUrlRange(1, $locations->lastPage()) as $page => $url)
                                    <li
                                        class="paginate_button page-item {{ $page == $locations->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                {{-- ปุ่มถัดไป --}}
                                @if ($locations->hasMorePages())
                                    <li class="paginate_button page-item next">
                                        <a class="page-link" href="{{ $locations->nextPageUrl() }}"><i
                                                class="bi bi-chevron-double-right"></i></a>
                                    </li>
                                @else
                                    <li class="paginate_button page-item next disabled">
                                        <a class="page-link" href="#"><i class="bi bi-chevron-double-right"></i></a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection

@section('mobile-content')
    <div class="d-flex flex-column align-items-center">
        <img src="{{ url('../img/trash_verify/1.1.png') }}" alt="icon-5" class="img-fluid logo-img">
        <h3 class="px-2 text-center">ประวัติการชำระเงิน</h3>
    </div>

    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">

        {{-- ตารางข้อมูล --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">

                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>วันที่ชำระ (ล่าสุด)</th>
                                <th>ที่อยู่</th>
                                <th>ยอดชำระทั้งหมด (บาท)</th>
                                <th>จำนวนรายการ</th>
                                <th>สถานะ</th>
                                <th>รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($locations as $index => $location)
                                @php
                                    $totalAmount = $location->bills->sum('amount');
                                    $count = $location->bills->count();
                                    $latestPaid = $location->bills->max('paid_date');
                                    $hasMissingSlip = $location->bills->contains(function ($bill) {
                                        return is_null($bill->slip_path);
                                    });
                                @endphp
                                <tr>
                                    <td>{{ ($locations->currentPage() - 1) * $locations->perPage() + $index + 1 }}</td>
                                    <td>{{ $latestPaid ? \Carbon\Carbon::parse($latestPaid)->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $location->name ?? '-' }}</td>
                                    <td>{{ number_format($totalAmount, 2) }}</td>
                                    <td>{{ $count }}</td>
                                    <td>
                                        @if ($hasMissingSlip)
                                            <img src="{{ url('../img/icon/ยังไม่ชำระ.png') }}" class="img-fluid logo-img"
                                                alt="ยังไม่ชำระ">
                                        @else
                                            <img src="{{ url('../img/icon/เสร็จสิ้น.png') }}" class="img-fluid logo-img"
                                                alt="เสร็จสิ้น">
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.payment_history.detail', $location->id) }}"
                                            class="btn btn-primary btn-sm">ดูใบเสร็จ</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">ไม่มีข้อมูล</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{-- แสดงจำนวนรายการ --}}
                    <div class="text-start mb-2">
                        แสดง {{ $locations->firstItem() ?? 0 }} ถึง {{ $locations->lastItem() ?? 0 }} จาก
                        {{ $locations->total() ?? 0 }} รายการ
                    </div>

                    {{-- ปุ่ม pagination --}}
                    <div class="d-flex justify-content-center">
                        <nav>
                            <ul class="pagination mb-0">
                                {{-- ปุ่มก่อนหน้า --}}
                                @if ($locations->onFirstPage())
                                    <li class="paginate_button page-item previous disabled">
                                        <a class="page-link" href="#"><i class="bi bi-chevron-double-left"></i></a>
                                    </li>
                                @else
                                    <li class="paginate_button page-item previous">
                                        <a class="page-link" href="{{ $locations->previousPageUrl() }}"><i
                                                class="bi bi-chevron-double-left"></i></a>
                                    </li>
                                @endif

                                {{-- หน้าเลข --}}
                                @foreach ($locations->getUrlRange(1, $locations->lastPage()) as $page => $url)
                                    <li
                                        class="paginate_button page-item {{ $page == $locations->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                {{-- ปุ่มถัดไป --}}
                                @if ($locations->hasMorePages())
                                    <li class="paginate_button page-item next">
                                        <a class="page-link" href="{{ $locations->nextPageUrl() }}"><i
                                                class="bi bi-chevron-double-right"></i></a>
                                    </li>
                                @else
                                    <li class="paginate_button page-item next disabled">
                                        <a class="page-link" href="#"><i
                                                class="bi bi-chevron-double-right"></i></a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
