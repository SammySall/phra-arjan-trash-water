@extends('layout.layout-admin-trash')
@section('title', 'รายการธนาคารขยะ')

@section('desktop-content')
    <h3 class="text-center px-2 mb-4">รายการธนาคารขยะ</h3>

    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">

        <div class="d-flex justify-content-end align-items-center mb-3">
            <!-- ปุ่มเพิ่ม -->
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTrashBankModal">
                เพิ่มข้อมูล
            </button>
        </div>

        {{-- ตัวกรอง search + pagination --}}
        <div class="mb-3 d-flex justify-content-between">
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

            <form method="GET" class="d-flex align-items-center">
                <span class="me-2">ค้นหา:</span>
                <input type="search" name="search" class="form-control form-control-sm flex-grow-1 me-2"
                    placeholder="ค้นหา..." value="{{ $search }}">
                <input type="hidden" name="data_table_length" value="{{ $perPage }}">
            </form>

        </div>

        {{-- ตาราง --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ประเภท</th>
                        <th>ประเภทย่อย</th>
                        <th>น้ำหนัก (kg)</th>
                        <th>จำนวนเงิน (บาท)</th>
                        <th>ผู้ฝาก</th>
                        <th>ผู้สร้าง</th>
                        <th>วันที่สร้าง</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashBanks as $index => $item)
                        <tr>
                            <td>{{ $loop->iteration + (($trashBanks->currentPage() - 1) * $trashBanks->perPage() ?? 0) }}
                            </td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->subtype ?? '-' }}</td>
                            <td>{{ $item->weight }}</td>
                            <td>{{ number_format($item->amount, 2) }}</td>
                            <td>{{ $item->depositor }}</td>
                            <td>{{ $item->creator->name ?? '-' }}</td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">ไม่มีข้อมูล</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $trashBanks->links() }}
        </div>
    </div>
    <!-- Modal เพิ่มข้อมูล -->
    <div class="modal fade" id="addTrashBankModal" tabindex="-1" aria-labelledby="addTrashBankLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.trash_bank.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTrashBankLabel">เพิ่มข้อมูลธนาคารขยะ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>ประเภท</label>
                            <input type="text" class="form-control" name="type" required>
                        </div>
                        <div class="mb-2">
                            <label>ประเภทย่อย</label>
                            <input type="text" class="form-control" name="subtype">
                        </div>
                        <div class="mb-2">
                            <label>น้ำหนัก (kg)</label>
                            <input type="number" step="0.01" class="form-control" name="weight" required>
                        </div>
                        <div class="mb-2">
                            <label>จำนวนเงิน (บาท)</label>
                            <input type="number" step="0.01" class="form-control" name="amount" required>
                        </div>
                        <div class="mb-2">
                            <label>ผู้ฝาก</label>
                            <select name="depositor" class="form-select" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- ผู้สร้างดึงจาก auth อัตโนมัติ -->
                        <input type="hidden" name="creator_id" value="{{ auth()->user()->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
