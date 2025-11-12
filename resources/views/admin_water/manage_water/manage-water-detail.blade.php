@extends('layout.layout-admin-water')
@section('title', 'รายการใบเสร็จ')

@section('desktop-content')
    <h3 class="text-center px-2 mb-4">รายการใบเสร็จของ {{ $location->name ?? '-' }}</h3>

    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <div><strong>เจ้าของทะเบียน :</strong> {{ $location->owner->name ?? '-' }}</div>
                <div><strong>ที่อยู่ :</strong> {{ $location->address ?? '-' }}</div>
                <div><strong>สาขาที่ใช้น้ำ :</strong> {{ $location->branch ?? '-' }}</div>
            </div>

            <div>
                <button class="btn" data-bs-toggle="modal" data-bs-target="#addSlipModal">
                    <img src="{{ url('../img/water-menu-page/Add-Button.png') }}" alt="Coin" class="w-75">
                </button>
            </div>
        </div>

        {{-- ตัวกรอง pagination + search --}}
        <div id="data_table_wrapper" class="mb-3 d-flex justify-content-between">
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
                    value="{{ $search }}" style="width:auto;">
                <input type="hidden" name="data_table_length" value="{{ $perPage }}">
            </form>
        </div>

        {{-- ตารางบิล --}}
        <div class="table-responsive">
            @php
                $histories = $location->waterHistories()->orderBy('id')->get();
            @endphp
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>มิเตอร์เดิม</th>
                        <th>มิเตอร์ล่าสุด</th>
                        <th>จำนวนเงิน</th>
                        <th>วันที่ออกบิล</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bills as $index => $bill)
                        <tr>
                            <td>{{ $loop->iteration + (($bills->currentPage() - 1) * $bills->perPage() ?? 0) }}</td>
                            <td>{{ $histories[$index]->old_miter ?? '-' }}
                            </td>
                            <td>{{ $histories[$index]->update_miter ?? '-' }}
                            </td>
                            <td>{{ number_format($bill->amount, 2) }} บาท</td>
                            <td>{{ \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') }}</td>
                            <td>
                                <img src="{{ url('../img/icon/' . $bill->status . '.png') }}" alt="{{ $bill->status }}"
                                    class="img-fluid logo-img">
                            </td>
                            <td>
                                <a href="{{ route('admin.water_bill.pdf', $bill->id) }}" target="_blank"
                                    class="btn btn-danger btn-sm text-white">
                                    <i class="bi bi-filetype-pdf"></i>
                                </a>
                                @if ($bill->status == 'รอการตรวจสอบ')
                                    <button class="btn btn-primary btn-sm pay-btn"
                                        data-amount="{{ number_format($bill->amount, 2) }}" data-id="{{ $bill->id }}">
                                        ตรวจสอบการชำระเงิน </button>
                                @elseif ($bill->status == 'ชำระแล้ว')
                                    <button type="button" data-id="{{ $bill->id }}"
                                        class="btn-manage p-0 border-0 bg-transparent"> <img
                                            src="{{ url('../img/trash_verify/4.png') }}" class="img-fluid logo-img"
                                            alt="Manage"> </button>
                                @else
                                    <span class="text-muted"></span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">ไม่มีบิล</td>
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
    <h3 class="text-center px-2 mb-4">รายการใบเสร็จของ {{ $location->name ?? '-' }}</h3>

    <div class="container bg-white bg-opacity-75 p-4 rounded-3 shadow-sm">

        <div class="mb-3"><strong>ที่อยู่ :</strong> {{ $location->address ?? '-' }}</div>
        <div class="mb-3"><strong>สาขาที่ใช้น้ำ :</strong> {{ $location->branch ?? '-' }}</div>

        <div class="mb-3">
            <strong>สถานะ :</strong>
            @if ($location->status == 'เสร็จสิ้น')
                <span class="badge bg-success">ติดตั้งถังขยะแล้ว</span>
            @else
                <span class="badge bg-warning">รอติดตั้ง</span>
            @endif
        </div>

        {{-- ตัวกรอง pagination + search --}}
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
            @php
                $histories = $location->waterHistories()->orderBy('id')->get();
            @endphp
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>มิเตอร์เดิม</th>
                        <th>มิเตอร์ล่าสุด</th>
                        <th>จำนวนเงิน</th>
                        <th>วันที่ออกบิล</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bills as $index => $bill)
                        <tr>
                            <td>{{ $loop->iteration + (($bills->currentPage() - 1) * $bills->perPage() ?? 0) }}</td>
                            <td>{{ $loop->first ? $location->old_miter ?? '-' : $histories[$index - 1]->old_miter ?? '-' }}
                            </td>
                            <td>{{ $loop->first ? $location->new_miter ?? '-' : $histories[$index - 1]->update_miter ?? '-' }}
                            </td>
                            <td>{{ number_format($bill->amount, 2) }} บาท</td>
                            <td>{{ \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') }}</td>
                            <td>
                                @if ($bill->status == 'unpaid')
                                    <img src="{{ url('../img/icon/ยังไม่ชำระ.png') }}" class="img-fluid logo-img"
                                        alt="ยังไม่ชำระ">
                                @else
                                    <img src="{{ url('../img/icon/เสร็จสิ้น.png') }}" class="img-fluid logo-img"
                                        alt="เสร็จสิ้น">
                                @endif
                            </td>
                            <td></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">ไม่มีบิล</td>
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
        const payButtons = document.querySelectorAll('.pay-btn');
        const manageButtons = document.querySelectorAll('.btn-manage');

        // สำหรับปุ่มตรวจสอบการชำระเงิน (มีปุ่มอนุมัติ)
        payButtons.forEach(btn => {
            btn.addEventListener('click', async function() {
                const billId = this.dataset.id;
                const res = await fetch(
                    "{{ route('admin.water.verify_payment.getBill') }}?bill_id=" +
                    billId);
                const bill = await res.json();

                const htmlContent = `
                    <div style="text-align:left; font-size:16px;">
                        <p><b>วันที่ชำระ:</b> ${bill.bill.paid_date ?? '-'}</p>
                        <p><b>ชื่อผู้จ่าย:</b> ${bill.bill.user ?? '-'}</p>
                        <p><b>ยอดชำระ:</b> ${bill.bill.amount} บาท</p>
                        ${bill.bill.slip_url ? `<p><b>สลิปชำระเงิน:</b></p>
                    <img src="${bill.bill.slip_url}" alt="Slip" style="width:100%; max-height:400px; border:1px solid #ccc; padding:5px;">`
                    : `<p><b>สลิปชำระเงิน:</b> ไม่มี</p>`}
                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-primary me-2 approve-btn">อนุมัติ</button>
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

                        popup.querySelector('.close-modal').addEventListener(
                            'click', () => Swal.close());

                        popup.querySelector('.approve-btn').addEventListener(
                            'click', async () => {
                                try {
                                    const approveRes = await fetch(
                                        "{{ route('admin.water.verify_payment.approveBill') }}", {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({
                                                bill_id: billId
                                            })
                                        });
                                    const data = await approveRes
                                        .json();
                                    if (approveRes.ok && data.success) {
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

        // สำหรับปุ่ม Manage (ไม่มีปุ่มอนุมัติ)
        manageButtons.forEach(btn => {
            btn.addEventListener('click', async function() {
                const billId = this.dataset.id;
                const res = await fetch(
                    "{{ route('admin.water.verify_payment.getBill') }}?bill_id=" +
                    billId);
                const bill = await res.json();
                console.log(bill)

                const htmlContent = `
                <div style="text-align:left; font-size:16px;">
                    <p><b>วันที่ชำระ:</b> ${bill.bill.paid_date ?? '-'}</p>
                    <p><b>ชื่อผู้จ่าย:</b> ${bill.bill.user ?? '-'}</p>
                    <p><b>ยอดชำระ:</b> ${bill.bill.amount} บาท</p>
                    ${bill.bill.slip_url ? `<p><b>สลิปชำระเงิน:</b></p>
                    <img src="${bill.bill.slip_url}" alt="Slip" style="width:100%; max-height:400px; border:1px solid #ccc; padding:5px;">`
                    : `<p><b>สลิปชำระเงิน:</b> ไม่มี</p>`}
                    <div class="d-flex justify-content-end mt-3">
                        <button id="closeModal" class="btn btn-secondary">ปิด</button>
                    </div>
                </div>
            `;

                Swal.fire({
                    title: 'รายละเอียดบิล',
                    html: htmlContent,
                    showConfirmButton: false,
                    width: '600px',
                    customClass: {
                        title: 'text-start',
                        htmlContainer: 'text-start'
                    },
                    didOpen: () => {
                        Swal.getPopup().querySelector('#closeModal')
                            .addEventListener('click', () => Swal.close());
                    }
                });
            });
        });
    });
</script>

{{-- Modal: เพิ่มบิลน้ำ --}}
<div class="modal fade" id="addSlipModal" tabindex="-1" aria-labelledby="addSlipLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.water.storeNewBill') }}" method="POST">
                @csrf
                <input type="hidden" name="water_location_id" value="{{ $location->id }}">
                <input type="hidden" name="price_per_unit" id="price_per_unit" value="10">

                <div class="mb-3">
                    <label for="old_miter" class="form-label">มิเตอร์เดิม</label>
                    <input type="number" class="form-control" id="old_miter" name="old_miter"
                        value="{{ $location->new_miter ?? 0 }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="new_miter" class="form-label">มิเตอร์ล่าสุด</label>
                    <input type="number" class="form-control" id="new_miter" name="new_miter" required>
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label">จำนวนเงิน (คำนวณอัตโนมัติ)</label>
                    <input type="text" class="form-control" id="amount" name="amount" readonly>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    // คำนวณจำนวนเงินอัตโนมัติ
    document.getElementById('new_miter').addEventListener('input', function() {
        const oldMiter = parseFloat(document.getElementById('old_miter').value) || 0;
        const newMiter = parseFloat(this.value) || 0;

        let usage = newMiter - oldMiter;
        if (usage < 0) usage = 0;

        const pricePerUnit = 10; // ราคาต่อหน่วย
        document.getElementById('amount').value = (usage * pricePerUnit).toFixed(2);
        document.getElementById('price_per_unit').value = pricePerUnit;
    });
</script>
{{-- Script คำนวณ --}}
<script>
    function calcTotals() {
        let totalReceipt = 0;
        document.querySelectorAll('.receipt-input').forEach(i => totalReceipt += parseFloat(i.value || 0));

        let totalExpenses = 0;
        document.querySelectorAll('.expense-input').forEach(i => totalExpenses += parseFloat(i.value || 0));

        document.getElementById('total-receipt').innerText = totalReceipt.toLocaleString();
        document.getElementById('total-expenses').innerText = totalExpenses.toLocaleString();
        document.getElementById('total-net').innerText = (totalReceipt - totalExpenses).toLocaleString();
    }

    document.querySelectorAll('.receipt-input, .expense-input').forEach(input => {
        input.addEventListener('input', calcTotals);
    });
</script>
