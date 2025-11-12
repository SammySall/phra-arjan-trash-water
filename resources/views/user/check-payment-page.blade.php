@extends('layout.layout-user')
@section('title', 'Check Payment')
@section('body-class', 'body-garbage-bg')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-5">
                <div>
                    <a href="/user/waste_payment">
                        <img src="../../img/ToxicTrash/Back-Button.png" alt="ปุ่มกลับ" class="back-garbage-btn mb-4">
                    </a>
                </div>

                <div class="mb-2 d-flex justify-content-center align-items-end">
                    <img src="../../img/Payment/Banner.png" alt="banner" class="trash-toxic-img">
                </div>
            </div>

            <div class="col-md-7 bg-body-secondary payment-bg text-black">
                <!-- ข้อมูลผู้ใช้ -->
                <div class="row mb-2">
                    <div class="col-5 bg-white p-2 shadow-sm rounded-pill me-4">
                        {{ $user->name }}
                    </div>
                    <div class="col-2 bg-white p-2 shadow-sm rounded-pill ms-3 me-2">
                        สถานะ: ปกติ
                    </div>
                    <div class="col-4 bg-white p-2 shadow-sm rounded-pill ms-1">
                        ประเภท: {{ $user->role }}
                    </div>
                </div>

                <!-- ที่อยู่ -->
                <div class="row mb-3">
                    <div class="col bg-white p-3 shadow-sm rounded">
                        ที่อยู่: {{ $user->address }}
                    </div>
                </div>

                <!-- ประวัติการชำระเงิน -->
                <div class="row mb-3">
                    <div class="col bg-white p-3 shadow-sm rounded">
                        <h5>ประวัติการชำระเงิน</h5>
                        <table class="table table-bordered table-striped mt-2 text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>เดือน</th>
                                    <th>รายการ</th>
                                    <th>สถานะ</th>
                                    <th>ยอดชำระ</th>
                                    <th>ชำระ</th> <!-- คอลัมน์ปุ่มชำระ -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bills as $bill)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($bill->due_date)->format('M Y') }}</td>
                                        <td>{{ $bill->trashLocation->name ?? '-' }}</td>
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
                                                <a href="{{ route('admin.bill.pdf', $bill->id) }}"
                                                    target="_blank" class="btn btn-danger btn-sm text-white">
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
                    <p><b>QR Code ชำระเงิน:</b></p>
                    <img src="{{ url('../img/Payment/QR.jpg') }}" alt="QR Code" style="width:100%; max-width:250px; border:1px solid #ccc; padding:5px; display:block;">
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
