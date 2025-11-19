@extends('layout.layout-user')
@section('title', 'Water Usage Statistics')
@section('body-class', 'body-waterworks-bg')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/water-statistics.css') }}">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-2">
                <div>
                    <a href="/user/waterworks">
                        <img src="../../img/water-menu-page/Back-Button.png" alt="ปุ่มกลับ" class="back-garbage-btn mb-4">
                    </a>
                </div>
            </div>

            <div class="col-md-10 bg-white payment-bg text-black">
                @foreach ($waterLocations as $location)
                    <div class="d-flex mb-2 align-items-start flex-wrap">

                        {{-- รูปภาพด้านซ้าย --}}
                        <div class="mt-5 d-flex flex-column justify-content-center" style="flex: 0 0 30%;">
                            <div class="d-flex justify-content-center align-items-end h-100 mb-2">
                                <img src="../../img/water-statistics/Image.png" alt="banner"
                                    class="trash-toxic-img img-fluid rounded shadow-sm">
                            </div>
                            <div
                                class="d-flex justify-content-between rounded align-items-center ps-3 py-2 bg-info-subtle rounded shadow-sm">
                                <span class="fw-bold text-dark">
                                    {{ $location->name ?? 'ไม่ระบุ' }} ({{ $location->water_user_no ?? '-' }})
                                </span>
                                <img src="../../img/water-statistics/icon-4.png" alt="banner"
                                    class="trash-toxic-img img-fluid rounded shadow-sm me-3">
                            </div>

                        </div>

                        {{-- การ์ดด้านขวา --}}
                        <div class="border-0 rounded text-center p-3 row flex-grow-1" style="flex: 0 0;">
                            <div class="col-md-12 mb-3">
                                <img src="../../img/water-statistics/Image-2.png" alt="banner"
                                    class="img-fluid rounded shadow-sm w-75">
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="label-box">ทะเบียนลูกค้า</div>
                                <div class="value-box">{{ $location->water_user_no ?? '-' }}</div>
                            </div>


                            <div class="col-md-6 mb-5">
                                <p class="label-box">สถานที่ใช้น้ำ</p>
                                <p class="value-box">{{ $location->address ?? '-' }}</p>
                            </div>
                            <div class="col-md-12 d-flex justify-content-center align-items-center">
                                <a href="{{ route('user.water_payment.statistics.detail', ['id' => $location->id]) }}"
                                    class="label-box">
                                    ดูสถิติการใช้น้ำ
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="row mb-5 text-end">
                    <div class="col-md-4 d-flex justify-content-center align-items-center">
                    </div>
                    <a href="/user/water_payment/register_water_no"
                        class="col-md-8 d-flex justify-content-center align-items-center add-water">
                        <i class="bi bi-plus icon-plus"></i>เพิ่มทะเบียนลูกค้า
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- ✅ SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll(".pay-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const billId = btn.dataset.id;
                const amount = btn.dataset.amount;

                const htmlContent = `
            <div style="text-align:left; font-size:16px; width:100%;">
                <p>ยอดที่ต้องชำระ: <b>${amount}</b> บาท</p>

                <div class="mb-3">
                    <p><b>โอนเข้าบัญชี:</b> ธนาคาร กรุงไทย เลขที่ 202-1240355</p>
                    <p><b>QR Code ชำระเงิน:</b></p>
                    <img src="{{ url('../img/Payment/QR.jpg') }}" alt="QR Code"
                        style="width:100%; max-width:250px; border:1px solid #ccc; padding:5px; display:block;">
                </div>

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
