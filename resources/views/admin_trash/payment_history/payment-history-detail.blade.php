@extends('layout.layout-admin-trash')

@section('title', 'Dashboard')
@section('desktop-content')
    <h3 class="text-center px-2">บิลที่รอการชำระเงิน : {{ $location->name ?? '-' }}</h3>

    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">

        {{-- ฟิลเตอร์ --}}
        <form method="GET" action="{{ route('admin.payment_history.detail', $location->id) }}">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-12 d-flex align-items-center">
                    <label class="d-flex align-items-center">
                        <select name="month_filter" class="form-select form-select-sm me-2" style="width:auto;">
                            <option value="">---เลือกเดือน---</option>
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" @if (request('month_filter') == $m) selected @endif>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>

                        <select name="year_filter" class="form-select form-select-sm" style="width:auto;">
                            <option value="">---เลือกปี---</option>
                            @for ($y = 2568; $y > 2558; $y--)
                                <option value="{{ $y }}" @if (request('year_filter') == $y) selected @endif>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </label>
                </div>
            </div>
        </form>

        {{-- ปุ่ม Export PDF --}}
        <div class="row mb-2">
            <div class="col-sm-12 col-md-12">
                <a href="#" class="btn btn-danger btn-sm">Export PDF</a>
            </div>
        </div>

        {{-- บรรทัดจำนวนรายการและช่องค้นหา --}}
        <div class="row mb-2">
            <div class="col-sm-12 col-md-6">
                <label class="d-flex align-items-center">
                    <span class="me-1">แสดง</span>
                    <select name="data_table_length" aria-controls="data_table" class="form-select form-select-sm me-1"
                        style="width: auto;">
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
                    <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="data_table"
                        style="width: auto;">
                </label>
            </div>
        </div>

        {{-- ตารางข้อมูล --}}
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped text-center">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>วันที่ชำระ</th>
                            <th>ที่อยู่</th>
                            <th>ยอดชำระ (บาท)</th>
                            <th>สลิปชำระเงิน</th>
                            <th>สถานะ</th>
                            <th>รายละเอียด</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($bills as $index => $bill)
                            <tr>
                                <td>{{ $bills->firstItem() + $index }}</td>
                                <td>{{ $bill->paid_date ? \Carbon\Carbon::parse($bill->paid_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $location->address ?? '-' }}</td>
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
                                <td>
                                    @if ($bill->status === 'รอการตรวจสอบ')
                                        @php
                                            $bill->status = 'รอตรวจสอบการชำระเงิน';
                                        @endphp
                                    @endif
                                    <img src="{{ url('../img/icon/' . $bill->status . '.png') }}"
                                        class="img-fluid logo-img" alt="{{ $bill->status }}" style="width: 32px">
                                </td>

                                <td class="text-center">
                                    @if ($bill->status === 'ยังไม่ชำระ')
                                        <button class="btn btn-primary pay-btn" data-id="{{ $bill->id }}"
                                            data-amount="{{ $bill->amount }}" title="รอการตรวจสอบ ไม่สามารถดำเนินการได้">
                                            <i class="bi bi-archive"></i>
                                        </button>
                                    @elseif ($bill->status === 'รอการตรวจสอบ')
                                        <button class="btn btn-primary pay-btn" data-id="{{ $bill->id }}"
                                            data-amount="{{ $bill->amount }}" disabled
                                            title="รอการตรวจสอบ ไม่สามารถดำเนินการได้">
                                            <i class="bi bi-archive"></i>
                                        </button>
                                    @elseif ($bill->status === 'ชำระแล้ว' || $bill->status === 'รออนุมัติ')
                                        <button type="button" class="btn btn-sm">
                                            <a href="{{ route('admin.bill.pdf', $bill->trash_location_id) }}"
                                                target="_blank" class="btn btn-danger btn-sm">
                                                <i class="bi bi-filetype-pdf"></i>
                                            </a>
                                        </button>
                                    @endif
                                </td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">ไม่มีข้อมูลบิล</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-5">
                        <div>แสดง {{ $bills->firstItem() ?? 0 }} ถึง {{ $bills->lastItem() ?? 0 }} จาก
                            {{ $bills->total() ?? 0 }} รายการ</div>
                    </div>
                    <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                        {{ $bills->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".pay-btn").forEach(btn => {
                btn.addEventListener("click", function() {
                    const billId = btn.dataset.id;
                    const amount = btn.dataset.amount;

                    const htmlContent = `
                <div style="text-align:left; font-size:16px; width:100%;">
                    <p>ไม่มีข้อมูล</p>
                    <label for='slipFile'>แนบบิล (PDF, JPG, PNG):</label>
                    <input type="file" id="slipFile" accept="image/*,.pdf" style="width:100%; padding:5px; margin-bottom:10px;">
                    <img id="slipPreview" style="width:100%; display:none; border:1px solid #ccc; padding:5px; margin-bottom:10px;">
                    <div class="d-flex justify-content-end mt-3">
                        <button id="closeSlip" class="btn btn-secondary me-2">ปิด</button>
                        <button id="saveSlip" class="btn btn-success">บันทึกบิล</button>
                    </div>
                </div>
            `;

                    Swal.fire({
                        title: 'รายละเอียดบิลการชำระเงิน',
                        html: htmlContent,
                        showConfirmButton: false,
                        showCancelButton: false,
                        width: '700px',
                        customClass: {
                            title: 'text-start'
                        },
                        didOpen: () => {
                            const input = Swal.getPopup().querySelector('#slipFile');
                            const preview = Swal.getPopup().querySelector(
                                '#slipPreview');

                            // preview รูปสลิป
                            input.addEventListener('change', () => {
                                const file = input.files[0];
                                if (file && file.type.startsWith('image/')) {
                                    const reader = new FileReader();
                                    reader.onload = e => {
                                        preview.src = e.target.result;
                                        preview.style.display = 'block';
                                    };
                                    reader.readAsDataURL(file);
                                } else {
                                    preview.style.display = 'none';
                                    preview.src = '';
                                }
                            });

                            // ปุ่มปิด
                            document.getElementById('closeSlip').addEventListener(
                                'click', () => Swal.close());

                            // ปุ่มบันทึกบิล
                            document.getElementById('saveSlip').addEventListener(
                                'click', () => {
                                    if (!input.files[0]) {
                                        Swal.showValidationMessage(
                                            'กรุณาเลือกไฟล์แนบบิลก่อน');
                                        return;
                                    }

                                    // แค่โชว์ success แบบจำลอง
                                    Swal.fire(
                                        'สำเร็จ',
                                        `บันทึกบิลจำลองเรียบร้อยสำหรับบิล #${billId}`,
                                        'success'
                                    ).then(() => Swal.close());
                                });
                        }
                    });
                });
            });
        });
    </script>

@endsection

@section('mobile-content')
    <h3 class="text-center px-2">บิลที่รอการชำระเงิน : {{ $location->name ?? '-' }}</h3>

    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">

        {{-- ปุ่ม Export PDF --}}
        <div class="row mb-2">
            <div class="col-sm-12 col-md-12">
                <a href="#" class="btn btn-danger btn-sm">Export PDF</a>
            </div>
        </div>

        {{-- บรรทัดจำนวนรายการและช่องค้นหา --}}
        <div class="row mb-2">
            <div class="col-sm-12 col-md-6">
                <label class="d-flex align-items-center">
                    <span class="me-1">แสดง</span>
                    <select name="data_table_length" aria-controls="data_table" class="form-select form-select-sm me-1"
                        style="width: auto;">
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
                    <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="data_table"
                        style="width: auto;">
                </label>
            </div>
        </div>

        {{-- ตารางข้อมูล --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">

                    <table class="table table-bordered table-striped text-center">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>วันที่ชำระ</th>
                                <th>ที่อยู่</th>
                                <th>ยอดชำระ (บาท)</th>
                                <th>สลิปชำระเงิน</th>
                                <th>สถานะ</th>
                                <th>รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse ($bills as $index => $bill)
                                <tr>
                                    <td>{{ $bills->firstItem() + $index }}</td>
                                    <td>{{ $bill->paid_date ? \Carbon\Carbon::parse($bill->paid_date)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>{{ $location->address ?? '-' }}</td>
                                    <td>{{ number_format($bill->amount, 2) }}</td>
                                    <td>
                                        @if ($bill->slip_path)
                                            <a href="{{ asset('storage/' . $bill->slip_path) }}" target="_blank">
                                                <img src="{{ url('../img/trash_verify/5.png') }}"
                                                    class="img-fluid logo-img" alt="Slip">
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($bill->status === 'ยังไม่ชำระ')
                                            <span class="text-warning">รอแนบบิล</span>
                                        @elseif ($bill->status === 'รอการตรวจสอบ')
                                            <span class="text-warning">รอการตรวจสอบ</span>
                                        @elseif ($bill->status === 'ชำระแล้ว')
                                            <span class="text-success">ชำระแล้ว</span>
                                        @else
                                            <span class="text-secondary">{{ $bill->status }}</span>
                                        @endif
                                        <img src="{{ url('../img/icon/' . $bill->status . '.png') }}"
                                            class="img-fluid logo-img" alt="{{ $bill->status }}" style="width: 32px">
                                    </td>

                                    <td class="text-center">
                                        @if ($bill->status === 'ยังไม่ชำระ')
                                            <button class="btn btn-primary pay-btn" data-id="{{ $bill->id }}"
                                                data-amount="{{ $bill->amount }}"
                                                title="รอการตรวจสอบ ไม่สามารถดำเนินการได้">
                                                <i class="bi bi-archive"></i>
                                            </button>
                                        @elseif ($bill->status === 'รอการตรวจสอบ')
                                            <button class="btn btn-primary pay-btn" data-id="{{ $bill->id }}"
                                                data-amount="{{ $bill->amount }}" disabled
                                                title="รอการตรวจสอบ ไม่สามารถดำเนินการได้">
                                                <i class="bi bi-archive"></i>
                                            </button>
                                        @elseif ($bill->status === 'ชำระแล้ว')
                                            <button type="button" class="btn btn-danger btn-sm">
                                                <a href="{{ route('admin.bill.pdf', $bill->trash_location_id) }}"
                                                    target="_blank" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-filetype-pdf"></i>
                                                </a>
                                            </button>
                                        @endif
                                    </td>


                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">ไม่มีข้อมูลบิล</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-5">
                        <div>แสดง {{ $bills->firstItem() ?? 0 }} ถึง {{ $bills->lastItem() ?? 0 }} จาก
                            {{ $bills->total() ?? 0 }} รายการ</div>
                    </div>
                    <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                        {{ $bills->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".pay-btn").forEach(btn => {
                btn.addEventListener("click", function() {
                    const billId = btn.dataset.id;
                    const amount = btn.dataset.amount;

                    const htmlContent = `
                <div style="text-align:left; font-size:16px; width:100%;">
                    <p>ไม่มีข้อมูล</p>
                    <label for='slipFile'>แนบบิล (PDF, JPG, PNG):</label>
                    <input type="file" id="slipFile" accept="image/*,.pdf" style="width:100%; padding:5px; margin-bottom:10px;">
                    <img id="slipPreview" style="width:100%; display:none; border:1px solid #ccc; padding:5px; margin-bottom:10px;">
                    <div class="d-flex justify-content-end mt-3">
                        <button id="closeSlip" class="btn btn-secondary me-2">ปิด</button>
                        <button id="saveSlip" class="btn btn-success">บันทึกบิล</button>
                    </div>
                </div>
            `;

                    Swal.fire({
                        title: 'รายละเอียดบิลการชำระเงิน',
                        html: htmlContent,
                        showConfirmButton: false,
                        showCancelButton: false,
                        width: '700px',
                        customClass: {
                            title: 'text-start'
                        },
                        didOpen: () => {
                            const input = Swal.getPopup().querySelector('#slipFile');
                            const preview = Swal.getPopup().querySelector(
                                '#slipPreview');

                            // preview รูปสลิป
                            input.addEventListener('change', () => {
                                const file = input.files[0];
                                if (file && file.type.startsWith('image/')) {
                                    const reader = new FileReader();
                                    reader.onload = e => {
                                        preview.src = e.target.result;
                                        preview.style.display = 'block';
                                    };
                                    reader.readAsDataURL(file);
                                } else {
                                    preview.style.display = 'none';
                                    preview.src = '';
                                }
                            });

                            // ปุ่มปิด
                            document.getElementById('closeSlip').addEventListener(
                                'click', () => Swal.close());

                            // ปุ่มบันทึกบิล
                            document.getElementById('saveSlip').addEventListener(
                                'click', () => {
                                    if (!input.files[0]) {
                                        Swal.showValidationMessage(
                                            'กรุณาเลือกไฟล์แนบบิลก่อน');
                                        return;
                                    }

                                    // แค่โชว์ success แบบจำลอง
                                    Swal.fire(
                                        'สำเร็จ',
                                        `บันทึกบิลจำลองเรียบร้อยสำหรับบิล #${billId}`,
                                        'success'
                                    ).then(() => Swal.close());
                                });
                        }
                    });
                });
            });
        });
    </script>

@endsection
