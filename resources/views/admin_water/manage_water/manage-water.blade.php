@extends('layout.layout-admin-water')

@section('title', 'Dashboard')


@section('desktop-content')
    <h3 class="text-center px-2 mb-4">จัดการค่าประปา</h3>

    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">


        {{-- ตัวกรอง pagination + search --}}
        <div id="data_table_wrapper" class="mb-3">
            <div class="row mb-2">
                <div class="col-md-6">
                    <form method="GET" class="d-flex align-items-center">
                        <span class="me-1">แสดง</span>
                        <select name="data_table_length" class="form-select form-select-sm me-2" style="width:auto;"
                            onchange="this.form.submit()">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="40" {{ $perPage == 40 ? 'selected' : '' }}>40</option>
                            <option value="80" {{ $perPage == 80 ? 'selected' : '' }}>80</option>
                            <option value="-1" {{ $perPage == -1 ? 'selected' : '' }}>ทั้งหมด</option>
                        </select>
                        <input type="hidden" name="search" value="{{ $search }}">
                        <span class="me-1">รายการ</span>

                    </form>
                </div>

                <div class="col-md-6 d-flex justify-content-end">
                    <form method="GET" class="d-flex">
                        <span class="me-1">ค้นหา : </span>
                        <input type="search" name="search" class="form-control form-control-sm me-2"
                            placeholder="ค้นหาชื่อหรือที่อยู่..." value="{{ $search }}" style="width:auto;">
                        <input type="hidden" name="data_table_length" value="{{ $perPage }}">
                    </form>
                </div>
            </div>
        </div>

        {{-- ตารางบิล --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th class="text-center">ทะเบียนลูกค้า</th>
                        <th class="text-center">ชื่อทะเบียน</th>
                        <th class="text-center">ที่อยู่</th>
                        {{-- <th class="text-center">สาขา</th> --}}
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $index => $location)
                        <tr>
                            <td class="text-center">
                                {{ $location->water_user_no }}
                            </td>
                            <td>{{ $location->name }}</td>
                            <td>{{ $location->address }}</td>
                            {{-- <td>{{ $location->branch }}</td> --}}
                            <td class="text-center">
                                <a href="manage-water/detail/{{ $location->id }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-search"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">ไม่มีข้อมูลสถานที่</td>
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
                            <li class="paginate_button page-item {{ $page == $locations->currentPage() ? 'active' : '' }}">
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

@endsection

@section('mobile-content')
    <h3 class="text-center px-2 mb-4">จัดการค่าประปา</h3>

    <div class="container bg-white bg-opacity-75 p-4 rounded-3 shadow-sm">

        <div id="data_table_wrapper" class="mb-3 d-flex flex-column gap-2">
            <form method="GET" class="d-flex align-items-center">
                <span class="me-1">แสดง</span>
                <select name="data_table_length" class="form-select form-select-sm me-2" style="width:auto;"
                    onchange="this.form.submit()">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="40" {{ $perPage == 40 ? 'selected' : '' }}>40</option>
                    <option value="80" {{ $perPage == 80 ? 'selected' : '' }}>80</option>
                    <option value="-1" {{ $perPage == -1 ? 'selected' : '' }}>ทั้งหมด</option>
                </select>
                <input type="hidden" name="search" value="{{ $search }}">
                <span class="me-1">รายการ</span>
            </form>

            <form method="GET" class="d-flex">
                <span class="me-1">ค้นหา :</span>
                <input type="search" name="search" class="form-control form-control-sm me-2" placeholder="ค้นหา..."
                    value="{{ $search }}">
                <input type="hidden" name="data_table_length" value="{{ $perPage }}">
            </form>
        </div>

        {{-- ตารางบิล --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th class="text-center">ทะเบียนลูกค้า</th>
                        <th class="text-center">ชื่อทะเบียน</th>
                        <th class="text-center">ที่อยู่</th>
                        {{-- <th class="text-center">สาขา</th> --}}
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $index => $location)
                        <tr>
                            <td class="text-center">
                                {{ $location->water_user_no }}
                            </td>
                            <td>{{ $location->name }}</td>
                            <td>{{ $location->address }}</td>
                            {{-- <td>{{ $location->branch }}</td> --}}
                            <td class="text-center">
                                <a href="manage-water/detail/{{ $location->id }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-search"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">ไม่มีข้อมูลสถานที่</td>
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
                                <a class="page-link" href="#"><i class="bi bi-chevron-double-right"></i></a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>

    </div>
@endsection
