@extends('layout.layout-admin-trash')

@section('title', 'ตรวจสอบการชำระเงิน')
@section('desktop-content')
    <div class="d-flex flex-column align-items-center">
        <img src="{{ url('../img/trash_verify/1.png') }}" alt="icon-5" class="img-fluid logo-img">
        <h3 class="px-2 text-center">ตรวจสอบการชำระเงิน</h3>
    </div>

    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">
        {{-- ฟิลเตอร์ --}}
        <div class="row mb-2">
            {{-- จำนวนข้อมูลต่อหน้า --}}
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

            {{-- ช่องค้นหา --}}
            <div class="col-md-6 d-flex justify-content-end">
                <form method="GET" class="d-flex">
                    <span class="me-1">ค้นหา : </span>
                    <input type="search" name="search" class="form-control form-control-sm me-2"
                        placeholder="ค้นหาที่อยู่หรือชื่อ..." value="{{ $search }}" style="width:auto;">
                    <input type="hidden" name="data_table_length" value="{{ $perPage }}">
                </form>
            </div>
        </div>

        {{-- ตาราง --}}
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>วันที่ชำระ</th>
                    <th>ชื่อผู้จ่าย</th>
                    <th>ที่อยู่</th>
                    <th>ยอดชำระ (บาท)</th>
                    <th>สลิปชำระเงิน</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($locations as $index => $location)
                    @forelse($location->bills as $bill)
                        <tr>
                            <td>{{ ($locations->currentPage() - 1) * $locations->perPage() + $loop->iteration }}</td>
                            <td> {{ $bill->paid_date ? \Carbon\Carbon::parse($bill->paid_date)->format('Y-m-d') : '-' }}
                            </td>
                            <td>{{ $location->name }}</td>
                            <td>{{ $location->address }}</td>
                            <td>{{ number_format($bill->amount, 2) }}</td>
                            <td>
                                @if ($bill->slip_path)
                                    <a href="{{ asset('storage/' . $bill->slip_path) }}" target="_blank">
                                        <img src="{{ url('../img/trash_verify/5.png') }}" class="img-fluid logo-img"
                                            alt="Slip">
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>รอการตรวจสอบ</td>
                            <td>
                                <button type="button" data-id="{{ $bill->id }}"
                                    class="btn-manage p-0 border-0 bg-transparent">
                                    <img src="{{ url('../img/trash_verify/4.png') }}" class="img-fluid logo-img"
                                        alt="Manage">
                                </button>
                            </td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">ไม่มีข้อมูลบิลของ {{ $location->name }}</td>
                        </tr>
                    @endforelse
                @empty
                    <tr>
                        <td colspan="8">ไม่มีข้อมูลสถานที่</td>
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



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const manageButtons = document.querySelectorAll('.btn-manage');

            manageButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const cells = row.querySelectorAll('td');
                    const billId = this.dataset.id;
                    const slipLink = cells[5].querySelector('a') ? cells[5].querySelector('a')
                        .href : null;
                    const htmlContent = `
                <div style="text-align:left; font-size:16px;">
                    <p><b>วันที่ชำระ:</b> ${cells[1].innerText}</p>
                    <p><b>ชื่อผู้จ่าย:</b> ${cells[2].innerText}</p>
                    <p><b>ที่อยู่:</b> ${cells[3].innerText}</p>
                    <p><b>ยอดชำระ:</b> ${cells[4].innerText}</p>
                    ${slipLink ? `<p><b>สลิปชำระเงิน:</b></p>
                                                        <img src="${slipLink}" alt="Slip" style="width:100%; max-height:400px; border:1px solid #ccc; padding:5px;">` 
                        : `<p><b>สลิปชำระเงิน:</b> ไม่มี</p>`}
                        <div class="mt-3">
                        <label><b>ชื่อผู้รับเงิน:</b></label>
                        <select id="billStatus" class="form-select mt-1">
                            <option value="นางนันทจิต เปียฉ่ำ">นางนันทจิต เปียฉ่ำ</option>
                            <option value="นายศักดิ์สิทธิ์ หมัดรอ">นายศักดิ์สิทธิ์ หมัดรอ</option>
                            <option value="นายเดชสกุล นุ้ยนิ่ง">นายเดชสกุล นุ้ยนิ่ง</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button id="approveBtn" class="btn btn-primary me-2">อนุมัติ</button>
                        <button id="closeModel" class="btn btn-secondary">ปิด</button>
                    </div>
                </div>
            `;

                    Swal.fire({
                        title: 'รายละเอียดบิล',
                        html: htmlContent,
                        showConfirmButton: false,
                        customClass: {
                            title: 'text-start',
                            htmlContainer: 'text-start'
                        },
                        width: '600px',
                        didOpen: () => {
                            const closeBtn = Swal.getPopup().querySelector(
                                '#closeModel');
                            closeBtn.addEventListener('click', () => Swal.close());
                            const selectedStatus = Swal.getPopup().querySelector('#billStatus').value;


                            const approveBtn = Swal.getPopup().querySelector(
                                '#approveBtn');
                            approveBtn.addEventListener('click', async () => {
                                try {
                                    const res = await fetch(
                                        "{{ route('admin.verify_payment.approveBill') }}", {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify({
                                                bill_id: billId,
                                                receive_by: selectedStatus // ✅ ใช้ค่าที่อ่านมา bill_id: billId,
                                            })
                                        });
                                    const data = await res.json();

                                    if (res.ok && data.success) {
                                        Swal.fire('สำเร็จ', data.message,
                                            'success');
                                        cells[6].innerText = 'ชำระแล้ว';
                                        location.reload();
                                    } else {
                                        Swal.fire('ผิดพลาด', data.message ||
                                            'เกิดข้อผิดพลาด', 'error');
                                    }
                                } catch (err) {
                                    Swal.fire('ผิดพลาด',
                                        'เกิดข้อผิดพลาดในการเชื่อมต่อ',
                                        'error');
                                }
                            });
                        }
                    });
                });
            });
        });
    </script>

@endsection

@section('mobile-content')
    <div class="d-flex flex-column align-items-center">
        <img src="{{ url('../img/trash_verify/1.png') }}" alt="icon-5" class="img-fluid logo-img">
        <h3 class="px-2 text-center">ตรวจสอบการชำระเงิน</h3>
    </div>

    {{-- ตาราง --}}
    <div class="table-responsive">

        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>วันที่ชำระ</th>
                    <th>ชื่อผู้จ่าย</th>
                    <th>ที่อยู่</th>
                    <th>ยอดชำระ (บาท)</th>
                    <th>สลิปชำระเงิน</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($locations as $index => $location)
                    @forelse($location->bills as $bill)
                        <tr>
                            <td>{{ ($locations->currentPage() - 1) * $locations->perPage() + $loop->iteration }}</td>
                            <td> {{ $bill->paid_date ? \Carbon\Carbon::parse($bill->paid_date)->format('Y-m-d') : '-' }}
                            </td>
                            <td>{{ $location->name }}</td>
                            <td>{{ $location->address }}</td>
                            <td>{{ number_format($bill->amount, 2) }}</td>
                            <td>
                                @if ($bill->slip_path)
                                    <a href="{{ asset('storage/' . $bill->slip_path) }}" target="_blank">
                                        <img src="{{ url('../img/trash_verify/5.png') }}" class="img-fluid logo-img"
                                            alt="Slip">
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>รอการตรวจสอบ</td>
                            <td>
                                <button type="button" data-id="{{ $bill->id }}"
                                    class="btn-manage p-0 border-0 bg-transparent">
                                    <img src="{{ url('../img/trash_verify/4.png') }}" class="img-fluid logo-img"
                                        alt="Manage">
                                </button>
                            </td>



                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">ไม่มีข้อมูลบิลของ {{ $location->name }}</td>
                        </tr>
                    @endforelse
                @empty
                    <tr>
                        <td colspan="8">ไม่มีข้อมูลสถานที่</td>
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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const manageButtons = document.querySelectorAll('.btn-manage');

            manageButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const cells = row.querySelectorAll('td');
                    const billId = this.dataset.id;
                    const slipLink = cells[5].querySelector('a') ? cells[5].querySelector('a')
                        .href : null;
                    const selectedStatus = Swal.getPopup().querySelector('#billStatus').value;


                    const htmlContent = `
                <div style="text-align:left; font-size:16px;">
                    <p><b>วันที่ชำระ:</b> ${cells[1].innerText}</p>
                    <p><b>ชื่อผู้จ่าย:</b> ${cells[2].innerText}</p>
                    <p><b>ที่อยู่:</b> ${cells[3].innerText}</p>
                    <p><b>ยอดชำระ:</b> ${cells[4].innerText}</p>
                    ${slipLink ? `<p><b>สลิปชำระเงิน:</b></p>
                                    <img src="${slipLink}" alt="Slip" style="width:100%; max-height:400px; border:1px solid #ccc; padding:5px;">`
                        : `<p><b>สลิปชำระเงิน:</b> ไม่มี</p>`}
                    <div class="mt-3">
                        <label><b>ชื่อผู้รับเงิน:</b></label>
                        <select id="billStatus" class="form-select mt-1">
                            <option value="นางนันทจิต เปียฉ่ำ">นางนันทจิต เปียฉ่ำ</option>
                            <option value="นายศักดิ์สิทธิ์ หมัดรอ">นายศักดิ์สิทธิ์ หมัดรอ</option>
                            <option value="นายเดชสกุล นุ้ยนิ่ง">นายเดชสกุล นุ้ยนิ่ง</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button id="approveBtn" class="btn btn-primary me-2">อนุมัติ</button>
                        <button id="closeModel" class="btn btn-secondary">ปิด</button>
                    </div>
                </div>
            `;


                    Swal.fire({
                        title: 'รายละเอียดบิล',
                        html: htmlContent,
                        showConfirmButton: false,
                        customClass: {
                            title: 'text-start',
                            htmlContainer: 'text-start'
                        },
                        width: '600px',
                        didOpen: () => {
                            const closeBtn = Swal.getPopup().querySelector(
                                '#closeModel');
                            closeBtn.addEventListener('click', () => Swal.close());

                            const approveBtn = Swal.getPopup().querySelector(
                                '#approveBtn');
                            approveBtn.addEventListener('click', async () => {
                                try {
                                    const res = await fetch(
                                        "{{ route('admin.verify_payment.approveBill') }}", {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify({
                                                bill_id: billId,
                                                receive_by: selectedStatus // ✅ ใช้ค่าที่อ่านมา bill_id: billId,
                                            })
                                        });
                                    const data = await res.json();

                                    if (res.ok && data.success) {
                                        Swal.fire('สำเร็จ', data.message,
                                            'success');
                                        cells[6].innerText = 'ชำระแล้ว';
                                        location.reload();
                                    } else {
                                        Swal.fire('ผิดพลาด', data.message ||
                                            'เกิดข้อผิดพลาด', 'error');
                                    }
                                } catch (err) {
                                    Swal.fire('ผิดพลาด',
                                        'เกิดข้อผิดพลาดในการเชื่อมต่อ',
                                        'error');
                                }
                            });
                        }
                    });
                });
            });
        });
    </script>

@endsection
