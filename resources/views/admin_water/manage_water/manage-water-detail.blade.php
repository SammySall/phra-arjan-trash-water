@extends('layout.layout-admin-water')
@section('title', 'รายการใบเสร็จ')

@section('desktop-content')
    <h3 class="text-center px-2 mb-4">รายการใบเสร็จของ {{ $location->name ?? '-' }}</h3>

    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <div><strong>เจ้าของทะเบียน :</strong> {{ $location->owner->name ?? '-' }}</div>
                <div><strong>ที่อยู่ :</strong> {{ $location->address ?? '-' }}</div>
                {{-- <div><strong>สาขาที่ใช้น้ำ :</strong> {{ $location->branch ?? '-' }}</div> --}}
            </div>

            <div>
                <button class="btn" style="text-align: right;" data-bs-toggle="modal" data-bs-target="#addSlipModal">
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
                                    class="img-fluid logo-img" style="width: 32px">
                            </td>
                            <td>
                                <a href="{{ route('admin.water_bill.pdf', $bill->id) }}" target="_blank"
                                    class="btn btn-danger btn-sm text-white">
                                    <i class="bi bi-filetype-pdf"></i>
                                </a>
                                {{-- ถ้า old_miter = 0 และ role ไม่ใช่ meter-filler --}}
                                @php
                                    $userRole = auth()->user()->role ?? '';
                                @endphp
                                @if (($histories[$index]->old_miter ?? 0) == 0 && $userRole !== 'meter-filler')
                                    <button class="btn btn-warning btn-sm edit-miter-btn"
                                        data-history-id="{{ $histories[$index]->id }}"
                                        data-old-miter="{{ $histories[$index]->old_miter }}"
                                        data-update-miter="{{ $histories[$index]->update_miter }}"
                                        data-bill-id="{{ $bill->id }}">
                                        แก้ไขมิเตอร์เดิม
                                    </button>
                                @endif
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

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <div><strong>เจ้าของทะเบียน :</strong> {{ $location->owner->name ?? '-' }}</div>
                <div><strong>ที่อยู่ :</strong> {{ $location->address ?? '-' }}</div>
                {{-- <div><strong>สาขาที่ใช้น้ำ :</strong> {{ $location->branch ?? '-' }}</div> --}}
            </div>

        </div>
        <div>
            <button class="btn" data-bs-toggle="modal" data-bs-target="#addSlipModal">
                <img src="{{ url('../img/water-menu-page/Add-Button.png') }}" alt="Coin" class="w-75">
            </button>
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
                            <td>{{ $histories[$index]->old_miter ?? '-' }}
                            </td>
                            <td>{{ $histories[$index]->update_miter ?? '-' }}
                            </td>
                            <td>{{ number_format($bill->amount, 2) }} บาท</td>
                            <td>{{ \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') }}</td>
                            <td>
                                <img src="{{ url('../img/icon/' . $bill->status . '.png') }}" alt="{{ $bill->status }}"
                                    class="img-fluid logo-img" style="width: 32px">
                            </td>
                            <td>
                                <a href="{{ route('admin.water_bill.pdf', $bill->id) }}" target="_blank"
                                    class="btn btn-danger btn-sm text-white">
                                    <i class="bi bi-filetype-pdf"></i>
                                </a>
                                @if ($bill->status == 'รอการตรวจสอบ')
                                    <button class="btn btn-primary btn-sm pay-btn"
                                        data-amount="{{ number_format($bill->amount, 2) }}"
                                        data-id="{{ $bill->id }}">
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
                    <div style="text-align:left; font-size:16px; padding:20px;">
                        <p><b>วันที่ชำระ:</b> ${bill.bill.paid_date ?? '-'}</p>
                        <p><b>ชื่อผู้จ่าย:</b> ${bill.bill.user ?? '-'}</p>
                        <p><b>ยอดชำระ:</b> ${bill.bill.amount} บาท</p>
                        ${bill.bill.slip_url ? `<p><b>สลิปชำระเงิน:</b></p>
                    <img src="${bill.bill.slip_url}" alt="Slip" style="width:100%; max-height:400px; border:1px solid #ccc; padding:5px;">`
                    : `<p><b>สลิปชำระเงิน:</b> ไม่มี</p>`}
                    <div class="mt-3">
                        <label><b>ชื่อผู้รับเงิน:</b></label>
                        <select id="billStatus" class="form-select mt-1">
                            <option value="นางนันทจิต เปียฉ่ำ">นางนันทจิต เปียฉ่ำ</option>
                            <option value="นายศักดิ์สิทธิ์ หมัดรอ" >นายศักดิ์สิทธิ์ หมัดรอ</option>
                            <option value="นายเดชสกุล นุ้ยนิ่ง" >นายเดชสกุล นุ้ยนิ่ง</option>
                        </select>
                    </div>
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
                                    const selectedStatus = popup
                                        .querySelector('#billStatus')
                                        .value; // ✅ เพิ่มตรงนี้

                                    const approveRes = await fetch(
                                        "{{ route('admin.water.verify_payment.receiveBill') }}", {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({
                                                bill_id: billId,
                                                receive_by: selectedStatus // ✅ ใช้ค่าที่อ่านมา
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
                <div style="text-align:left; font-size:16px;  padding:20px;">
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
    <div class="modal-dialog modal-lg ">
        <div class="modal-content px-4 pt-4">
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
                    <label for="unit_price" class="form-label">ราคาต่อหน่วย</label>
                    <input type="number" class="form-control" id="unit_price" name="unit_price" required>
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

{{-- มิเตอร์แก้ไข --}}
<div class="modal fade" id="editMiterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <h5>แก้ไขมิเตอร์เดิม</h5>

            <form id="editMiterForm">
                @csrf

                <input type="hidden" id="edit_history_id">
                <input type="hidden" id="edit_bill_id">

                <div class="mb-3">
                    <label class="form-label">มิเตอร์เดิม</label>
                    <input type="number" id="edit_old_miter" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">มิเตอร์ล่าสุด</label>
                    <input type="number" id="edit_update_miter" class="form-control" readonly>
                </div>

                <button type="submit" class="btn btn-primary w-100">บันทึก</button>
            </form>

        </div>
    </div>
</div>


<script>
    document.getElementById('new_miter').addEventListener('input', calculateAmount);
    document.getElementById('unit_price').addEventListener('input', calculateAmount);

    function calculateAmount() {

        const oldMiter = parseFloat(document.getElementById('old_miter').value) || 0;
        const newMiter = parseFloat(document.getElementById('new_miter').value) || 0;
        const unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;

        let usage = newMiter - oldMiter;
        if (usage < 0) usage = 0;

        const total = usage * unitPrice;

        document.getElementById('amount').value = total.toFixed(2);

        // ส่งค่าไปเก็บใน hidden input ถ้าต้องการ
        document.getElementById('price_per_unit').value = unitPrice;
    }
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

<script>
    // ดักไม่ให้ส่งฟอร์มถ้ามิเตอร์ใหม่ < มิเตอร์เก่า
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#addSlipModal form');

        form.addEventListener('submit', function(e) {

            const oldMiter = parseFloat(document.getElementById('old_miter').value) || 0;
            const newMiter = parseFloat(document.getElementById('new_miter').value) || 0;

            if (newMiter <= oldMiter) {
                e.preventDefault(); // ❌ หยุดการ submit

                Swal.fire({
                    icon: 'error',
                    title: 'ค่ามิเตอร์ไม่ถูกต้อง',
                    text: 'มิเตอร์ล่าสุดต้องไม่น้อยกว่ามิเตอร์เดิม',
                });

                return false;
            }
        });
    });
</script>

{{-- สำหรับเปิดmodelแก้ไข --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {

        document.querySelectorAll('.edit-miter-btn').forEach(btn => {
            btn.addEventListener('click', () => {

                document.getElementById('edit_history_id').value = btn.dataset.historyId;
                document.getElementById('edit_bill_id').value = btn.dataset.billId;
                document.getElementById('edit_old_miter').value = btn.dataset.oldMiter;
                document.getElementById('edit_update_miter').value = btn.dataset.updateMiter;

                // รองรับ Bootstrap 4 + 5
                if (typeof bootstrap !== 'undefined') {
                    new bootstrap.Modal(document.getElementById('editMiterModal')).show();
                } else {
                    $('#editMiterModal').modal('show');
                }

            });
        });

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.getElementById('editMiterForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('history_id', document.getElementById('edit_history_id').value);
            formData.append('bill_id', document.getElementById('edit_bill_id').value);
            formData.append('old_miter', document.getElementById('edit_old_miter').value);

            try {
                const res = await fetch("{{ route('admin.water.updateOldMiter') }}", {
                    method: 'POST',
                    body: formData
                });

                const data = await res.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ',
                        text: data.message
                    }).then(() => {
                        location.reload();
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: data.message || 'เกิดข้อผิดพลาด'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'ผิดพลาด',
                    text: 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้'
                });
            }
        });

    });
</script>
