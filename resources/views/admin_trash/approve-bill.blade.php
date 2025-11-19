@extends('layout.layout-admin-trash')
@section('title', 'รายการใบเสร็จรออนุมัติ')

@section('desktop-content')
    <div class="container bg-white bg-opacity-75 p-4 rounded-3 shadow-sm">
        <h3 class="text-center mb-4">รายการบิลที่รออนุมัติทั้งหมด</h3>

        {{-- ฟิลเตอร์ --}}
        <div class="d-flex justify-content-between mb-3">
            <form method="GET" class="d-flex align-items-center">
                <span class="me-1">แสดง</span>
                <select name="data_table_length" class="form-select form-select-sm me-2" style="width:auto;"
                    onchange="this.form.submit()">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="40" {{ $perPage == 40 ? 'selected' : '' }}>40</option>
                    <option value="80" {{ $perPage == 80 ? 'selected' : '' }}>80</option>
                    <option value="-1" {{ $perPage == -1 ? 'selected' : '' }}>ทั้งหมด</option>
                </select>
                <span class="me-1">รายการ</span>
            </form>

            <form method="GET" class="d-flex">
                <span class="me-1">ค้นหา :</span>
                <input type="search" name="search" class="form-control form-control-sm me-2"
                    placeholder="ค้นหาชื่อเจ้าของ..." value="{{ $search }}" style="width:auto;">
                <input type="hidden" name="data_table_length" value="{{ $perPage }}">
            </form>
        </div>

        {{-- ตารางบิล --}}
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>เจ้าของ</th>
                        <th>ที่อยู่</th>
                        <th>จำนวนเงิน</th>
                        <th>รูปใบเสร็จ</th>
                        <th>ผู้ทำการรับเงิน</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bills as $bill)
                        <tr>
                            <td>{{ $loop->iteration + (($bills->currentPage() - 1) * $bills->perPage() ?? 0) }}</td>
                            <td>{{ $bill->trashLocation->owner->name ?? '-' }}</td>
                            <td>{{ $bill->trashLocation->address ?? '-' }}</td>
                            <td>{{ number_format($bill->amount, 2) }} บาท</td>
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
                            <td>{{ $bill->receive_by }}</td>
                            <td>
                                <img src="{{ url('../img/icon/' . $bill->status . '.png') }}" alt="{{ $bill->status }}"
                                    class="img-fluid logo-img" style="width: 32px">
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm show-bill"
                                    data-id="{{ $bill->id }}">ดูรายละเอียด</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">ไม่มีบิลรออนุมัติ</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($bills instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="d-flex justify-content-center mt-3">
                {{ $bills->links() }}
            </div>
        @endif
    </div>
@endsection


@section('mobile-content')
    <div class="container bg-white bg-opacity-75 p-4 rounded-3 shadow-sm">
        <h3 class="text-center mb-4">รายการบิลที่รออนุมัติทั้งหมด</h3>

        {{-- ฟิลเตอร์ --}}
        <div class="d-flex justify-content-between mb-3">
            <form method="GET" class="d-flex align-items-center">
                <span class="me-1">แสดง</span>
                <select name="data_table_length" class="form-select form-select-sm me-2" style="width:auto;"
                    onchange="this.form.submit()">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="40" {{ $perPage == 40 ? 'selected' : '' }}>40</option>
                    <option value="80" {{ $perPage == 80 ? 'selected' : '' }}>80</option>
                    <option value="-1" {{ $perPage == -1 ? 'selected' : '' }}>ทั้งหมด</option>
                </select>
                <span class="me-1">รายการ</span>
            </form>

            <form method="GET" class="d-flex">
                <span class="me-1">ค้นหา :</span>
                <input type="search" name="search" class="form-control form-control-sm me-2"
                    placeholder="ค้นหาชื่อเจ้าของ..." value="{{ $search }}" style="width:auto;">
                <input type="hidden" name="data_table_length" value="{{ $perPage }}">
            </form>
        </div>

        {{-- ตารางบิล --}}
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>เจ้าของทะเบียน</th>
                        <th>เลขทะเบียนผู้ใช้น้ำ</th>
                        <th>จำนวนเงิน</th>
                        <th>รูปใบเสร็จ</th>
                        <th>ผู้ทำการรับเงิน</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bills as $bill)
                        <tr>
                            <td>{{ $loop->iteration + (($bills->currentPage() - 1) * $bills->perPage() ?? 0) }}</td>
                            <td>{{ $bill->waterLocation->owner->name ?? '-' }}</td>
                            <td>{{ $bill->waterLocation->water_user_no ?? '-' }}</td>
                            <td>{{ number_format($bill->amount, 2) }} บาท</td>
                            <td>{{ $bill->slip_path ?? '-' }}</td>
                            <td>{{ $bill->receive_by }}</td>
                            <td>
                                <img src="{{ url('../img/icon/' . $bill->status . '.png') }}" alt="{{ $bill->status }}"
                                    class="img-fluid logo-img">
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm show-bill"
                                    data-id="{{ $bill->id }}">ดูรายละเอียด</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">ไม่มีบิลรออนุมัติ</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($bills instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="d-flex justify-content-center mt-3">
                {{ $bills->links() }}
            </div>
        @endif
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ปุ่มดูรายละเอียดบิล
        const showBillButtons = document.querySelectorAll('.show-bill');

        showBillButtons.forEach(btn => {
            btn.addEventListener('click', async function() {
                const billId = this.dataset.id;

                try {
                    // ดึงข้อมูลบิลจาก API
                    const res = await fetch(
                        "{{ route('admin.verify_payment.getBill') }}?bill_id=" +
                        billId);
                    const {
                        bill
                    } = await res.json();

                    // สร้าง HTML Modal
                    const htmlContent = `
                    <div style="text-align:left; font-size:16px; padding:20px;">
                        <p><b>วันที่ชำระ:</b> ${bill.paid_date}</p>
                        <p><b>ชื่อผู้จ่าย:</b> ${bill.user}</p>
                        <p><b>ยอดชำระ:</b> ${bill.amount} บาท</p>
                        ${bill.slip_url ? `<p><b>สลิปชำระเงิน:</b></p>
                            <img src="${bill.slip_url}" alt="Slip" style="width:100%; max-height:400px; border:1px solid #ccc; padding:5px;">`
                        : `<p><b>สลิปชำระเงิน:</b> ไม่มี</p>`}
                        <p><b>ชื่อผู้รับเงิน:</b> ${bill.receive_by}</p>
                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-primary me-2 approve-bill" data-id="${bill.id}">อนุมัติ</button>
                            <button class="btn btn-secondary close-modal">ปิด</button>
                        </div>
                    </div>
                `;

                    Swal.fire({
                        title: 'รายละเอียดบิล',
                        html: htmlContent,
                        showConfirmButton: false,
                        width: '600px',
                        didOpen: () => {
                            const popup = Swal.getPopup();

                            // ปิด Modal
                            popup.querySelector('.close-modal')
                                .addEventListener('click', () => Swal.close());

                            // ปุ่มอนุมัติ
                            popup.querySelector('.approve-bill')
                                .addEventListener('click', async () => {

                                    const res = await fetch(
                                        '{{ route('admin.approve_bill.submit') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({
                                                bill_id: bill
                                                    .id,
                                                receive_by: bill
                                                    .receive_by
                                            })
                                        });

                                    const data = await res.json();
                                    console.log("Response:", data);

                                    if (res.ok && data.success) {
                                        Swal.fire('สำเร็จ', data
                                                .message, 'success')
                                            .then(() => location
                                            .reload());
                                    } else {
                                        Swal.fire('ผิดพลาด', data
                                            .message ||
                                            'เกิดข้อผิดพลาด',
                                            'error');
                                    }
                                });

                        }
                    });

                } catch (err) {
                    Swal.fire('ผิดพลาด', 'ไม่สามารถดึงข้อมูลบิลได้', 'error');
                    console.error(err);
                }
            });
        });
    });
</script>
