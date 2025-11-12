@extends('layout.layout-admin-trash')

@section('title', 'รายละเอียดบิล')
@section('desktop-content')
    <h3 class="text-center">บิลที่รอการชำระเงิน : {{ $location->name ?? '-' }}</h3>
    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">

        <div id="data_table_wrapper">
            {{-- บรรทัดเดือนและปี --}}
            <div class="row mb-2">
                <div class="col-sm-12 col-md-12 d-flex align-items-center">
                    <label class="d-flex align-items-center">
                        <select name="month_filter" class="form-select form-select-sm me-2" style="width:auto;">
                            <option value="" selected>---เลือกเดือน---</option>
                            <option value="1">มกราคม</option>
                            <option value="2">กุมภาพันธ์</option>
                            <option value="3">มีนาคม</option>
                            <option value="4">เมษายน</option>
                            <option value="5">พฤษภาคม</option>
                            <option value="6">มิถุนายน</option>
                            <option value="7">กรกฎาคม</option>
                            <option value="8">สิงหาคม</option>
                            <option value="9">กันยายน</option>
                            <option value="10">ตุลาคม</option>
                            <option value="11">พฤศจิกายน</option>
                            <option value="12">ธันวาคม</option>
                        </select>

                        <select name="year_filter" class="form-select form-select-sm" style="width:auto;">
                            <option value="" selected>---เลือกปี---</option>
                            @for ($y = 2568; $y > 2558; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </label>
                </div>
            </div>

            {{-- ปุ่ม Export PDF --}}
            <div class="row mb-2">
                <div class="col-sm-12 col-md-12">
                    <a href="{{ route('admin.non_payment.export', $location->id) }}" class="btn btn-danger btn-sm">
                        Export PDF
                    </a>
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

            {{-- ตารางบิล --}}
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>จำนวนเงิน</th>
                                <th>สถานะ</th>
                                <th>วันครบกำหนด</th>
                                <th>วันที่ชำระ</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($location->bills as $index => $bill)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ number_format($bill->amount, 2) }} บาท</td>
                                    <td>
                                        @if ($bill->status == 'ชำระแล้ว')
                                            <span class="badge bg-success">{{ $bill->status }}</span>
                                        @elseif ($bill->status == 'รอการตรวจสอบ')
                                            <span class="badge bg-warning">{{ $bill->status }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $bill->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $bill->due_date ? \Carbon\Carbon::parse($bill->due_date)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>{{ $bill->paid_date ? \Carbon\Carbon::parse($bill->paid_date)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>
                                        @if ($bill->status != 'ชำระแล้ว')
                                            <button class="btn btn-primary btn-sm pay-btn"
                                                data-amount="{{ number_format($bill->amount, 2) }}"
                                                data-id="{{ $bill->id }}">
                                                จ่ายบิล
                                            </button>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">ไม่มีข้อมูล</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="fw-bold text-center">ยอดรวมค้างชำระทั้งหมด</td>
                                <td colspan="2" class="fw-bold text-center">{{ number_format($totalPending, 2) }} บาท
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12 col-md-5">
                    <div>แสดง 1 ถึง 2 จาก 2 รายการ</div>
                </div>
                <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                    <ul class="pagination">
                        <li class="paginate_button page-item previous disabled">
                            <a class="page-link" href="#" aria-disabled="true">ก่อนหน้า</a>
                        </li>
                        <li class="paginate_button page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="paginate_button page-item next disabled">
                            <a class="page-link" href="#" aria-disabled="true">ถัดไป</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll(".pay-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const billId = btn.dataset.id;
                const amount = btn.dataset.amount;

                const htmlContent = `
            <div style="text-align:left; font-size:16px; width:100%;">
                <p>ยอดที่ต้องชำระ: <b>${amount}</b> บาท</p>
                <label for='slipFile'>อัปโหลดสลิปการชำระเงิน:</label>
                <input type="file" id="slipFile" accept="image/*" style="width:100%; padding:5px; margin-bottom:10px;">
                <img id="slipPreview" style="width:100%; display:none; border:1px solid #ccc; padding:5px;">
                <div class="d-flex justify-content-end mt-3">
                    <button id="sendSlip" class="btn btn-primary me-2">ยืนยันการชำระเงิน</button>
                    <button id="closeSlip" class="btn btn-secondary">ปิด</button>
                </div>
            </div>
        `;

                Swal.fire({
                    title: 'ชำระเงิน',
                    html: htmlContent,
                    showConfirmButton: false,
                    showCancelButton: false,
                    width: '700px',
                    customClass: {
                        title: 'text-start'
                    },
                    didOpen: () => {
                        const input = Swal.getPopup().querySelector('#slipFile');
                        const preview = Swal.getPopup().querySelector('#slipPreview');

                        input.addEventListener('change', () => {
                            const file = input.files[0];
                            if (file) {
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

                        document.getElementById('closeSlip').addEventListener('click', () =>
                            Swal.close());

                        document.getElementById('sendSlip').addEventListener('click',
                            async () => {
                                if (!input.files[0]) {
                                    Swal.showValidationMessage(
                                        'กรุณาเลือกไฟล์รูปสลิปก่อน');
                                    return;
                                }

                                const formData = new FormData();
                                formData.append('slip', input.files[0]);
                                formData.append('bill_id', billId);
                                formData.append('_token', '{{ csrf_token() }}');

                                try {
                                    const res = await fetch(
                                        '{{ route('admin.non_payment.upload_slip') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Accept': 'application/json'
                                            },
                                            body: formData
                                        });

                                    const data = await res.json();

                                    if (res.ok && data.success) {
                                        Swal.fire('สำเร็จ', data.message, 'success')
                                            .then(() => location.reload());
                                    } else {
                                        Swal.fire('ผิดพลาด', data.message ||
                                            'ไม่สามารถบันทึกสลิปได้', 'error');
                                    }
                                } catch (err) {
                                    Swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาดในการเชื่อมต่อ',
                                        'error');
                                }
                            });
                    }
                });
            });
        });
    </script>


@endsection


@section('mobile-content')
    <h3 class="text-center">บิลที่รอการชำระเงิน : {{ $location->name ?? '-' }}</h3>

    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">

        <div id="data_table_wrapper">
            {{-- บรรทัดเดือนและปี --}}
            <div class="row mb-2">
                <div class="col-sm-12 col-md-12 d-flex align-items-center">
                    <label class="d-flex align-items-center">
                        <select name="month_filter" class="form-select form-select-sm me-2" style="width:auto;">
                            <option value="" selected>---เลือกเดือน---</option>
                            <option value="1">มกราคม</option>
                            <option value="2">กุมภาพันธ์</option>
                            <option value="3">มีนาคม</option>
                            <option value="4">เมษายน</option>
                            <option value="5">พฤษภาคม</option>
                            <option value="6">มิถุนายน</option>
                            <option value="7">กรกฎาคม</option>
                            <option value="8">สิงหาคม</option>
                            <option value="9">กันยายน</option>
                            <option value="10">ตุลาคม</option>
                            <option value="11">พฤศจิกายน</option>
                            <option value="12">ธันวาคม</option>
                        </select>

                        <select name="year_filter" class="form-select form-select-sm" style="width:auto;">
                            <option value="" selected>---เลือกปี---</option>
                            @for ($y = 2568; $y > 2558; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </label>
                </div>
            </div>

            {{-- ปุ่ม Export PDF --}}
            <div class="row mb-2">
                <div class="col-sm-12 col-md-12">
                    <a href="{{ route('admin.non_payment.export', $location->id) }}" class="btn btn-danger btn-sm">
                        Export PDF
                    </a>
                </div>
            </div>

            {{-- ตารางบิล --}}
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">

                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>จำนวนเงิน</th>
                                    <th>สถานะ</th>
                                    <th>วันครบกำหนด</th>
                                    <th>วันที่ชำระ</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($location->bills as $index => $bill)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ number_format($bill->amount, 2) }} บาท</td>
                                        <td>
                                            @if ($bill->status == 'ชำระแล้ว')
                                                <span class="badge bg-success">{{ $bill->status }}</span>
                                            @elseif ($bill->status == 'รอการตรวจสอบ')
                                                <span class="badge bg-warning">{{ $bill->status }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $bill->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $bill->due_date ? \Carbon\Carbon::parse($bill->due_date)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>{{ $bill->paid_date ? \Carbon\Carbon::parse($bill->paid_date)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>
                                            @if ($bill->status != 'ชำระแล้ว')
                                                <button class="btn btn-primary btn-sm pay-btn"
                                                    data-amount="{{ number_format($bill->amount, 2) }}"
                                                    data-id="{{ $bill->id }}">
                                                    จ่ายบิล
                                                </button>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">ไม่มีข้อมูล</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="fw-bold text-center">ยอดรวมค้างชำระทั้งหมด</td>
                                    <td colspan="2" class="fw-bold text-center">{{ number_format($totalPending, 2) }}
                                        บาท
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12 col-md-5">
                    <div>แสดง 1 ถึง 2 จาก 2 รายการ</div>
                </div>
                <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                    <ul class="pagination">
                        <li class="paginate_button page-item previous disabled">
                            <a class="page-link" href="#" aria-disabled="true">ก่อนหน้า</a>
                        </li>
                        <li class="paginate_button page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="paginate_button page-item next disabled">
                            <a class="page-link" href="#" aria-disabled="true">ถัดไป</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll(".pay-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const billId = btn.dataset.id;
                const amount = btn.dataset.amount;

                const htmlContent = `
            <div style="text-align:left; font-size:16px; width:100%;">
                <p>ยอดที่ต้องชำระ: <b>${amount}</b> บาท</p>
                <label for='slipFile'>อัปโหลดสลิปการชำระเงิน:</label>
                <input type="file" id="slipFile" accept="image/*" style="width:100%; padding:5px; margin-bottom:10px;">
                <img id="slipPreview" style="width:100%; display:none; border:1px solid #ccc; padding:5px;">
                <div class="d-flex justify-content-end mt-3">
                    <button id="sendSlip" class="btn btn-primary me-2">ยืนยันการชำระเงิน</button>
                    <button id="closeSlip" class="btn btn-secondary">ปิด</button>
                </div>
            </div>
        `;

                Swal.fire({
                    title: 'ชำระเงิน',
                    html: htmlContent,
                    showConfirmButton: false,
                    showCancelButton: false,
                    width: '700px',
                    customClass: {
                        title: 'text-start'
                    },
                    didOpen: () => {
                        const input = Swal.getPopup().querySelector('#slipFile');
                        const preview = Swal.getPopup().querySelector('#slipPreview');

                        input.addEventListener('change', () => {
                            const file = input.files[0];
                            if (file) {
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

                        document.getElementById('closeSlip').addEventListener('click', () =>
                            Swal.close());

                        document.getElementById('sendSlip').addEventListener('click',
                            async () => {
                                if (!input.files[0]) {
                                    Swal.showValidationMessage(
                                        'กรุณาเลือกไฟล์รูปสลิปก่อน');
                                    return;
                                }

                                const formData = new FormData();
                                formData.append('slip', input.files[0]);
                                formData.append('bill_id', billId);
                                formData.append('_token', '{{ csrf_token() }}');

                                try {
                                    const res = await fetch(
                                        '{{ route('admin.non_payment.upload_slip') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Accept': 'application/json'
                                            },
                                            body: formData
                                        });

                                    const data = await res.json();

                                    if (res.ok && data.success) {
                                        Swal.fire('สำเร็จ', data.message, 'success')
                                            .then(() => location.reload());
                                    } else {
                                        Swal.fire('ผิดพลาด', data.message ||
                                            'ไม่สามารถบันทึกสลิปได้', 'error');
                                    }
                                } catch (err) {
                                    Swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาดในการเชื่อมต่อ',
                                        'error');
                                }
                            });
                    }
                });
            });
        });
    </script>


@endsection
