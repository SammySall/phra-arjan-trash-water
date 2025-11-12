@extends('layout.layout-user')
@section('title', 'Check Payment')
@section('body-class', 'body-waterworks-bg')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-2">
                <div>
                    <a href="/user/waterworks">
                        <img src="../../img/water-menu-page/Back-Button.png" alt="ปุ่มกลับ" class="back-garbage-btn mb-4">
                    </a>
                </div>
            </div>

            <div class="col-md-10 bg-body-secondary payment-bg text-black">
                <div class="d-flex mb-4 align-items-start flex-wrap water-card">

                    {{-- รูปภาพด้านซ้าย --}}
                    <div class="me-3 mb-2" style="flex: 0 0 30%;">
                        <div class="d-flex justify-content-center align-items-end h-100 mb-2">
                            <img src="../../img/check-water-payment/Image.png" alt="banner"
                                class="trash-toxic-img img-fluid rounded shadow-sm">
                        </div>
                        <div
                            class="d-flex justify-content-between rounded align-items-center ps-3 py-2 
                                bg-info-subtle rounded shadow-sm mb-2">
                            <span class="fw-bold text-dark">
                                {{ $user->name }} </span>
                        </div>
                        <div class="row gx-2 mb-2"> <!-- gx-2 = ระยะห่างแนวนอนระหว่างคอลัมน์ -->
                            <div class="col-5">
                                <div class="ps-3 py-2 bg-info-subtle rounded shadow-sm mb-2 h-100">
                                    <span class="fw-bold text-dark">สถานะ: ปกติ</span>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="ps-3 py-2 bg-info-subtle rounded shadow-sm mb-2 h-100">
                                    <span class="fw-bold text-dark">
                                        <img src="../../img/check-water-payment/icon-3.png" alt="banner"
                                            class="trash-toxic-img img-fluid rounded shadow-sm me-1"
                                            style="width: 20px; height: 20px;">
                                        ประเภท: {{ $user->role }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="d-flex justify-content-between rounded align-items-center ps-3 py-2 
                                bg-info-subtle rounded shadow-sm mb-2">
                            <span class="fw-bold text-dark">
                                ที่อยู่: {{ $user->address }}</span>
                        </div>
                    </div>

                    {{-- การ์ดด้านขวา --}}
                    <div class="border-0 rounded text-center p-3 row flex-grow-1">
                        <div class="col bg-info-subtle p-3 shadow-sm rounded">
                            <h2><img src="../../img/check-water-payment/icon-5.png" alt="banner"
                                    class="trash-toxic-img img-fluid rounded shadow-sm me-1 mb-2">
                                ประวัติการชำระเงิน</h2>
                            <table class="table table-bordered table-striped mt-2 text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>เดือน</th>
                                        <th>ทะเบียนลูกค้า</th>
                                        <th>สถานะ</th>
                                        <th>ยอดชำระ</th>
                                        <th>ชำระ</th> <!-- คอลัมน์ปุ่มชำระ -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bills as $bill)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($bill->due_date)->format('M Y') }}</td>
                                            <td>{{ $bill->waterLocation->water_user_no ?? '-' }}</td>
                                            <td>{{ $bill->status }}</td>
                                            <td>{{ number_format($bill->amount, 2) }} บาท</td>
                                            <td>
                                                @if ($bill->status == 'ยังไม่ชำระ')
                                                    <button class="btn btn-primary btn-sm pay-btn"
                                                        data-amount="{{ number_format($bill->amount, 2) }}"
                                                        data-id="{{ $bill->id }}">
                                                        <i class="bi bi-cash-stack"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('admin.water_bill.pdf', $bill->id) }}" target="_blank"
                                                        class="btn btn-danger btn-sm text-white">
                                                        <i class="bi bi-filetype-pdf"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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

                <!-- ข้อมูลการชำระเงิน -->
                <div class="mb-3">
                    <p><b>โอนเข้าบัญชี:</b>ธนาคาร กรุงไทย เลขที่ 202-1240355</p>
                </div>

                <!-- อัปโหลดสลิป -->
                <label for='slipFile'>อัปโหลดสลิปการชำระเงิน:</label>
                <input type="file" id="slipFile" accept="image/*" style="width:100%; padding:5px; margin-bottom:10px;">
                <img id="slipPreview" style="width:100%; display:none; border:1px solid #ccc; padding:5px;">

                <!-- ปุ่ม -->
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
