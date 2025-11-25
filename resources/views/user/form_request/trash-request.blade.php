@extends('layout.layout-request')
@section('title', 'คำร้องขออนุญาตลงถังขยะ')
@section('request-header-img', 'trash-request')
@section('request-header', 'คำร้องขออนุญาตลงถังขยะ')
@section('back-button', '/user/waste_payment')

@section('request-content')
    <div class="list-group">
        <form action="{{ route('trash-request.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-3 " style="display: none">
                <label class="form-label">ประเภท<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="type" value="trash-request" required>
            </div>

            <div class="mb-3">
                <label class="form-label">วันที่</label>
                <input type="text" name="field_date" class="form-control" value="{{ date('d/m/Y') }}" readonly>
            </div>

            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="prefix" class="form-label">คำนำหน้า<span class="text-danger">*</span></label>
                    <select id="prefix" name="field_1" class="form-control" required>
                        <option value="">-- โปรดเลือก --</option>
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label">ชื่อ - นามสกุล<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_2" id="name" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">อายุ<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="field_5" required>
                </div>
            </div>
            <div class="row g-3 mt-3">
                <div class="col-md-3">
                    <label class="form-label">สัญชาติ<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_6" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">บ้านเลขที่<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_7" required>
                </div>
                <div class="col-md-3">
                    <label for="alley" class="form-label">ตรอก/ซอย</label>
                    <input type="text" class="form-control" name="field_14" id="alley">
                </div>
                <div class="col-md-3">
                    <label for="road" class="form-label">ถนน</label>
                    <input type="text" class="form-control" name="field_15" id="road">
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-md-3">
                    <label class="form-label">หมู่ที่</label>
                    <input type="text" class="form-control" name="field_8">
                </div>
                <div class="col-md-3">
                    <label class="form-label">แขวง/ตำบล<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_9" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">เขต/อำเภอ<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_10" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">จังหวัด<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_11" required>
                </div>
                <div class="col-md-3">
                    <label for="tel" class="form-label">เบอร์โทร<span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="field_3" id="tel" pattern="[0-9]{10}"
                        maxlength="10" required>
                </div>
                <div class="col-md-3">
                    <label for="fax" class="form-label">โทรสาร</label>
                    <input type="tel" class="form-control" name="field_4" id="fax" pattern="[0-9]{10}"
                        maxlength="10">
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
                            <input class="form-check-input" type="radio" name="addon[option]" id="option1"
                                value="1">
                            <label class="form-check-label" for="option1">บ้านที่อยู่อาศัย</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="addon[option]" id="option2"
                                value="2">
                            <label class="form-check-label" for="option2">บ้านเช่า/อาคารให้เช่า</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="addon[option]" id="option3"
                                value="3">
                            <label class="form-check-label" for="option3">ร้านค้า</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="addon[option]" id="option4"
                                value="4">
                            <label class="form-check-label" for="option4">โรงงาน/ประกอบธุรกิจ</label>
                        </div>
                        <div class="form-check me-3 d-flex align-items-center">
                            <input class="form-check-input" type="radio" name="addon[option]" id="option5"
                                value="5">
                            <label class="form-check-label me-2" for="option5">อื่นๆ</label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 🗺️ แผนที่ --}}
            <div class="mb-3">
                <label class="form-label">ตำแหน่งสถานที่จัดเก็บขยะมูลฝอย <span class="text-danger">*</span></label>
                <div id="map" style="height: 400px; border-radius: 15px; overflow: hidden;"></div>
                <small class="text-muted">ระบบจะปักหมุดตำแหน่งปัจจุบันของคุณโดยอัตโนมัติ
                    หรือคลิกบนแผนที่เพื่อเลือกตำแหน่งใหม่</small>
            </div>

            <input type="hidden" name="lat" id="lat">
            <input type="hidden" name="lng" id="lng">

            <div class="mb-3 mt-3">
                <label class="form-label">
                    แนบเอกสารประกอบ <br>
                    <span class="text-danger">ประเภทไฟล์: jpg,jpeg,png,pdf (ไม่เกิน 2 MB)</span>
                </label>

                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck1">
                    <label class="form-check-label"
                        for="fileCheck1">สำเนาบัตรประจำตัวประชาชน/ข้าราชการ/พนักงานรัฐวิสาหกิจ</label>
                    <input type="file" name="files1[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck2">
                    <label class="form-check-label" for="fileCheck2">สำเนาหนังสือรับรองการจดทะเบียนนิติบุคคล
                        พร้อมสำเนาบัตรประจำตัวประชาชนของผู้แทนนิติบุคคล
                        (ในกรณีที่ผู้ขออนุญาตเป็นนิติบุคคล)
                    </label>
                    <input type="file" name="files2[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck3">
                    <label class="form-check-label" for="fileCheck3">
                        สำเนาหนังสือรับรองการจดทะเบียนนิติบุคคล พร้อมสำเนาบัตรประจำตัวประชาชนของผู้แทน นิติบุคคล
                    </label>
                    <input type="file" name="files3[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck5">
                    <label class="form-check-label" for="fileCheck5">หนังสือรับรองอำนาจ
                        ในกรณีที่เจ้าของกิจการไม่มายื่นขออนุญาตด้วยตนเอง
                    </label>
                    <input type="file" name="files5[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck6">
                    <label class="form-check-label" for="fileCheck6">เอกสารหลักฐานอื่น ๆ
                    </label>
                    <input type="file" name="files6[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5">บันทึก</button>
            </div>
        </form>
    </div>

    {{-- 🌍 Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const map = L.map('map').setView([13.736717, 100.523186], 13);
            const tile = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                maxZoom: 20
            }).addTo(map);

            let marker;
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    map.setView([lat, lng], 15);
                    marker = L.marker([lat, lng]).addTo(map).bindPopup("ตำแหน่งปัจจุบันของคุณ").openPopup();
                    document.getElementById('lat').value = lat;
                    document.getElementById('lng').value = lng;
                });
            }

            map.on('click', function(e) {
                const {
                    lat,
                    lng
                } = e.latlng;
                if (marker) {
                    marker.setLatLng(e.latlng).bindPopup("ตำแหน่งที่เลือกใหม่").openPopup();
                } else {
                    marker = L.marker(e.latlng).addTo(map).bindPopup("ตำแหน่งที่เลือกใหม่").openPopup();
                }
                document.getElementById('lat').value = lat;
                document.getElementById('lng').value = lng;
            });
        });
    </script>

    {{-- ✅ SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'บันทึกสำเร็จ!',
                text: 'ทำการร้องขอเสร็จสิ้นเรียบร้อยแล้ว',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                window.location.href = "{{ url('/user/waste_payment') }}"; // กลับหน้า homepage
            });
        </script>
    @endif
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll(".file-checkbox");
            checkboxes.forEach(cb => {
                cb.addEventListener("change", function() {
                    const parent = this.closest(".form-check");
                    const fileInput = parent.querySelector(".file-input");
                    if (fileInput) {
                        if (this.checked) {
                            fileInput.style.display = "block";
                            fileInput.style.opacity = 0;
                            fileInput.style.transition = "opacity 0.3s ease";
                            requestAnimationFrame(() => fileInput.style.opacity = 1);
                        } else {
                            fileInput.style.opacity = 0;
                            fileInput.addEventListener("transitionend", function hide() {
                                fileInput.style.display = "none";
                                fileInput.value = "";
                                fileInput.removeEventListener("transitionend", hide);
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
