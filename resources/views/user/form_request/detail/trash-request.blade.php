@extends('layout.layout-request')
@section('title', 'คำร้องขออนุญาตลงถังขยะ')
@section('request-header-img', 'trash-request')
@section('request-header', 'คำร้องขออนุญาตลงถังขยะ')
@section('back-button', '/user/waste_payment')

@section('request-content')
    <div class="text-center">
        <h4 class="header-form-name my-2 mx-4">
            รายละเอียดคำร้องขออนุญาตลงถังขยะ
        </h4>
    </div>

    <div class="list-group text-start">
        {{-- วันที่ --}}
        <div class="mb-3">
            <label class="form-label">วันที่</label>
            <input type="text" class="form-control" value="{{ $trashRequest->created_at->format('d/m/Y') ?? '-' }}"
                readonly>
        </div>

        {{-- ข้อมูลทั่วไป --}}
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">คำนำหน้า</label>
                <input type="text" class="form-control" value="{{ $trashRequest->prefix ?? '-' }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">ชื่อ - นามสกุล</label>
                <input type="text" class="form-control" value="{{ $trashRequest->fullname ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">อายุ</label>
                <input type="number" class="form-control" value="{{ $trashRequest->age ?? '-' }}" readonly>
            </div>
        </div>

        {{-- ที่อยู่ --}}
        <div class="row g-3 align-items-end mt-3">
            <div class="col-md-3">
                <label class="form-label">สัญชาติ</label>
                <input type="text" class="form-control" value="{{ $trashRequest->nationality ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">บ้านเลขที่</label>
                <input type="text" class="form-control" value="{{ $trashRequest->house_no ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">ตรอก/ซอย</label>
                <input type="text" class="form-control" value="{{ $trashRequest->alley ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">ถนน</label>
                <input type="text" class="form-control" value="{{ $trashRequest->road ?? '-' }}" readonly>
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-md-3">
                <label class="form-label">หมู่ที่</label>
                <input type="text" class="form-control" value="{{ $trashRequest->village_no ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">แขวง/ตำบล</label>
                <input type="text" class="form-control" value="{{ $trashRequest->subdistrict ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">เขต/อำเภอ</label>
                <input type="text" class="form-control" value="{{ $trashRequest->district ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">จังหวัด</label>
                <input type="text" class="form-control" value="{{ $trashRequest->province ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">เบอร์โทร</label>
                <input type="text" class="form-control" value="{{ $trashRequest->tel ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">โทรสาร</label>
                <input type="text" class="form-control" value="{{ $trashRequest->fax ?? '-' }}" readonly>
            </div>
        </div>

        <div class="mb-3 mt-3">
            <div class="col-md-12">
                <label class="form-label">
                    โปรด/ ลงใน ( ) หน้าข้อความที่ตรงกับประเภทของสถานที่จัดเก็บขยะมูลฝอยของท่าน <span
                        class="text-danger">*</span>
                </label>
                <div class="d-flex flex-wrap align-items-center">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio"
                            {{ ($addon['option'] ?? '') == '1' ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="option1">บ้านที่อยู่อาศัย</label>
                    </div>
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio"
                            {{ ($addon['option'] ?? '') == '2' ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="option2">บ้านเช่า/อาคารให้เช่า</label>
                    </div>
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio"
                            {{ ($addon['option'] ?? '') == '3' ? 'checked' : '' }} disabled> <label
                            class="form-check-label" for="option3">ร้านค้า</label>
                    </div>
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio"
                            {{ ($addon['option'] ?? '') == '4' ? 'checked' : '' }} disabled> <label
                            class="form-check-label" for="option4">โรงงาน/ประกอบธุรกิจ</label>
                    </div>
                    <div class="form-check me-3 d-flex align-items-center">
                        <input class="form-check-input" type="radio"
                            {{ ($addon['option'] ?? '') == '5' ? 'checked' : '' }} disabled> <label
                            class="form-check-label me-2" for="option5">อื่นๆ</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3 mt-3">
            <div class="col-md-12">
                <label class="form-label">
                    โปรด/ ลงใน ( ) หน้าข้อความที่ตรงกับรอบจ่ายค่าขยะมูลฝอยของท่าน <span
                        class="text-danger">*</span>
                </label>
                <div class="d-flex flex-wrap align-items-center">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio"
                            {{ ($addon['for'] ?? '') == 'รายปี' ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="option1">รายเดือน</label>
                    </div>
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio"
                            {{ ($addon['for'] ?? '') == 'รายเดือน' ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="option2">รายเดือน</label>
                    </div>
                </div>
            </div>
        </div>

        {{-- 🗺️ แผนที่ --}}
        <div class="mb-3">
            <label class="form-label">ตำแหน่งสถานที่จัดเก็บขยะมูลฝอย</label>
            <div id="map" style="height: 400px; border-radius: 15px; overflow: hidden;"></div>
        </div>

        <input type="hidden" name="lat" id="lat">
        <input type="hidden" name="lng" id="lng">

        <div class="mb-3 mt-3">
            <label class="form-label">
                แนบเอกสารประกอบ <br>
            </label>

            @php
                // ดึงไฟล์แต่ละ field ออกมา
                $file1 = $trashRequest->files->where('field_name', 'files1')->first();
                $file2 = $trashRequest->files->where('field_name', 'files2')->first();
                $file3 = $trashRequest->files->where('field_name', 'files3')->first();
                $file4 = $trashRequest->files->where('field_name', 'files4')->first();
                $file5 = $trashRequest->files->where('field_name', 'files5')->first();
            @endphp

            <div class="mb-3">
                <label class="form-label">สำเนาบัตรประจำตัวประชาชน/ข้าราชการ/พนักงานรัฐวิสาหกิจ</label>
                @if ($file1)
                    <a href="{{ asset('storage/' . $file1->file_path) }}" target="_blank">{{ $file1->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">สำเนาหนังสือรับรองการจดทะเบียนนิติบุคคล
                    พร้อมสำเนาบัตรประจำตัวประชาชนของผู้แทนนิติบุคคล
                    (ในกรณีที่ผู้ขออนุญาตเป็นนิติบุคคล)</label>
                @if ($file2)
                    <a href="{{ asset('storage/' . $file2->file_path) }}" target="_blank">{{ $file2->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">สำเนาหนังสือรับรองการจดทะเบียนนิติบุคคล พร้อมสำเนาบัตรประจำตัวประชาชนของผู้แทน
                    นิติบุคคล</label>
                @if ($file3)
                    <a href="{{ asset('storage/' . $file3->file_path) }}" target="_blank">{{ $file3->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">หนังสือรับรองอำนาจ
                    ในกรณีที่เจ้าของกิจการไม่มายื่นขออนุญาตด้วยตนเอง</label>
                @if ($file4)
                    <a href="{{ asset('storage/' . $file4->file_path) }}" target="_blank">{{ $file4->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">เอกสารหลักฐานอื่น ๆ</label>
                @if ($file5)
                    <a href="{{ asset('storage/' . $file5->file_path) }}" target="_blank">{{ $file5->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>
        </div>
        <div class="mt-4">
            <h5 class="mb-3">ประวัติการตอบกลับ</h5>
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">ผู้ตอบกลับ</th>
                        <th class="text-center">วันที่ตอบกลับ</th>
                        <th class="text-center">ข้อความที่ตอบกลับ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($trashRequest->histories as $history)
                        <tr>
                            <td class="text-center">{{ $history->user->name ?? 'ระบบ' }}</td>
                            <td class="text-center">{{ $history->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $history->message ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">ไม่มีประวัติการตอบกลับ</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>

    {{-- 🌍 Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // กำหนดค่า lat/lng จาก TrashRequest
            const lat = {{ $trashRequest->lat ?? 13.736717 }};
            const lng = {{ $trashRequest->lng ?? 100.523186 }};

            // สร้าง map
            const map = L.map('map', {
                dragging: false, // ปิดลาก map
                touchZoom: false, // ปิด zoom ด้วย touch
                scrollWheelZoom: false, // ปิด zoom ด้วย scroll
                doubleClickZoom: false, // ปิด zoom ด้วย double click
                boxZoom: false, // ปิด zoom แบบ box
                keyboard: false, // ปิด keyboard control
                zoomControl: false, // ปิดปุ่ม zoom
                tap: false
            }).setView([lat, lng], 15);

            // แผนที่ Google
            L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                maxZoom: 20
            }).addTo(map);

            // ปักหมุดตำแหน่ง
            L.marker([lat, lng]).addTo(map)
                .bindPopup("ตำแหน่งที่บันทึกไว้")
                .openPopup();
        });
    </script>
@endsection
