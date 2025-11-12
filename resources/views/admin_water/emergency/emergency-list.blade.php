@extends('layout.layout-admin-water')
@section('title', 'รายการเหตุการณ์ฉุกเฉิน')

@section('desktop-content')
    <h3 class="text-center mb-4">{{ $title }}</h3> {{-- ✅ เปลี่ยนหัวเป็น “แจ้งเหตุ” --}}
    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">

    <div id="data_table_wrapper">
        {{-- ตาราง --}}
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable" id="data_table">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>ชื่อผู้แจ้ง</th>
                            <th>ประเภท</th>
                            <th>เบอร์โทร</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($emergencies as $index => $emergency)
                            <tr>
                                <td>{{ ($emergencies->currentPage() - 1) * $emergencies->perPage() + $index + 1 }}</td>
                                <td>{{ $emergency->name }}</td>

                                {{-- แปลง type เป็นชื่อภาษาไทย --}}
                                <td>
                                    {{ $emergencyNames[$emergency->type] ?? ucfirst($emergency->type) }}
                                </td>

                                <td>{{ $emergency->tel }}</td>
                                <td>
                                    <a href="{{ route('admin.emergency.detail', ['id' => $emergency->id]) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-search"></i> ดูรายละเอียด
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">ไม่มีรายการเหตุการณ์</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="row mt-2">
            <div class="col-sm-12 col-md-5">
                <div>
                    แสดง {{ $emergencies->firstItem() ?? 0 }} ถึง {{ $emergencies->lastItem() ?? 0 }} จาก
                    {{ $emergencies->total() ?? 0 }} รายการ
                </div>
            </div>
            <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                {{ $emergencies->links() }}
            </div>
        </div>
    </div>
    </div>
@endsection
