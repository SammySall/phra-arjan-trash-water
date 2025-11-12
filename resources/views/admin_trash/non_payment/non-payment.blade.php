@extends('layout.layout-admin-trash')

@section('title', 'บิลที่รอการชำระเงิน')
@section('desktop-content')
    <div class="d-flex flex-column align-items-center">
        <img src="{{ url('../img/trash_verify/1.2.png') }}" alt="icon-5" class="img-fluid logo-img">
        <h3 class="px-2 text-center">บิลที่รอการชำระเงิน</h3>
    </div>
    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">

        <div id="data_table_wrapper ">
            <form method="GET" action="{{ route('admin.non_payment') }}">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-6">
                        <label class="d-flex align-items-center">
                            <span class="me-1">แสดง</span>
                            <select name="data_table_length" class="form-select form-select-sm me-1" style="width:auto;">
                                <option value="10" {{ request('data_table_length') == 10 ? 'selected' : '' }}>10
                                </option>
                                <option value="40" {{ request('data_table_length') == 40 ? 'selected' : '' }}>40
                                </option>
                                <option value="80" {{ request('data_table_length') == 80 ? 'selected' : '' }}>80
                                </option>
                                <option value="-1" {{ request('data_table_length') == -1 ? 'selected' : '' }}>ทั้งหมด
                                </option>
                            </select>
                            <span>รายการ</span>
                        </label>
                    </div>

                    <div class="col-sm-12 col-md-6 d-flex justify-content-end">
                        <label class="d-flex align-items-center">
                            <span class="me-2">ค้นหา :</span>
                            <input type="search" name="search" value="{{ request('search') }}"
                                class="form-control form-control-sm" placeholder="ค้นหาที่อยู่..."
                                onkeydown="if(event.key === 'Enter'){ this.form.submit(); }" style="width:auto;">
                        </label>
                    </div>
                </div>
            </form>

            {{-- ตารางข้อมูล --}}
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>ที่อยู่</th>
                        <th>เบอร์โทร</th>
                        <th>จำนวนเงิน</th>
                        <th>สถานะ</th>
                        <th>รายละเอียด</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $location)
                        @php
                            $unpaidCount = $location->bills->count();
                            $totalAmount = $location->bills->sum('amount');
                        @endphp
                        <tr>
                            <td>{{ $location->address }}</td>
                            <td>{{ $location->tel ?? '-' }}</td>
                            <td>{{ number_format($totalAmount, 2) }} บาท</td>
                            <td>
                                @if ($unpaidCount > 0)
                                    <img src="{{ url('../img/icon/ยังไม่ชำระ.png') }}" class="img-fluid logo-img"
                                        alt="ยังไม่ชำระ">
                                @else
                                    <img src="{{ url('../img/icon/เสร็จสิ้น.png') }}" class="img-fluid logo-img"
                                        alt="เสร็จสิ้น">
                                @endif

                            </td>
                            <td>
                                <a href="{{ route('non_payment.detail', $location->id) }}" class="btn btn-primary btn-sm">
                                    ดูบิล
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">ไม่มีข้อมูล</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- แสดงผลการแบ่งหน้า --}}
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
@endsection

@section('mobile-content')
    <div class="d-flex flex-column align-items-center">
        <img src="{{ url('../img/trash_verify/1.2.png') }}" alt="icon-5" class="img-fluid logo-img">
        <h3 class="px-2 text-center">บิลที่รอการชำระเงิน</h3>
    </div>

    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">

        <div id="data_table_wrapper">
            {{-- ตารางข้อมูล --}}
            <div class="table-responsive">

                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>ที่อยู่</th>
                            <th>เบอร์โทร</th>
                            <th>จำนวนเงิน</th>
                            <th>สถานะ</th>
                            <th>รายละเอียด</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($locations as $location)
                            @php
                                $unpaidCount = $location->bills->count();
                                $totalAmount = $location->bills->sum('amount');
                            @endphp
                            <tr>
                                <td>{{ $location->address }}</td>
                                <td>{{ $location->tel ?? '-' }}</td>
                                <td>{{ number_format($totalAmount, 2) }} บาท</td>
                                <td>
                                    @if ($unpaidCount > 0)
                                        <img src="{{ url('../img/icon/ยังไม่ชำระ.png') }}" class="img-fluid logo-img"
                                            alt="ยังไม่ชำระ">
                                    @else
                                        <img src="{{ url('../img/icon/เสร็จสิ้น.png') }}" class="img-fluid logo-img"
                                            alt="เสร็จสิ้น">
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('non_payment.detail', $location->id) }}"
                                        class="btn btn-primary btn-sm">
                                        ดูบิล
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">ไม่มีข้อมูล</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- แสดงผลการแบ่งหน้า --}}
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
@endsection
