@extends('layout.layout-user')
@section('title', 'Emergency Page')
@section('body-class', 'body-waterworks-bg')

@section('content')
    <div class="container py-4">
        <form class="row" id="emergency-form" action="{{ route('emergency.submit') }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="lat" id="lat">
            <input type="hidden" name="lng" id="lng">

            <div>
                <a href="/user/waterworks">
                    <img src="../../../../img/check-water-payment/Back-Button.png" alt="ปุ่มกลับ"
                        class="back-garbage-btn mb-4">
                </a>
            </div>

            <div class="d-flex align-items-center mb-3">
                <label for="salutation" class="form-label me-2 mb-0 label-emergency">เลือกเหตุที่ต้องการแจ้ง</label>
                <select class="form-select" id="salutation" name="salutation" required style="width: 200px;">
                    <option value="" disabled {{ empty($type) ? 'selected' : '' }}>
                        {{ empty($type) ? '-- โปรดเลือกเหตุผล --' : '' }}
                    </option>
                    <option value="water-leak" {{ ($type ?? '') == 'water-leak' ? 'selected' : '' }}>น้ำรั่ว</option>
                    <option value="fire" {{ ($type ?? '') == 'fire' ? 'selected' : '' }}>ไฟไหม้</option>
                    <option value="tree-fall" {{ ($type ?? '') == 'tree-fall' ? 'selected' : '' }}>ต้นไม้ล้ม</option>
                    <option value="broken-road" {{ ($type ?? '') == 'broken-road' ? 'selected' : '' }}>ถนนเสีย</option>
                    <option value="elec-broken" {{ ($type ?? '') == 'elec-broken' ? 'selected' : '' }}>ไฟเสีย</option>
                </select>
            </div>

            <!-- ✅ คอลัมน์ซ้าย: แผนที่ -->
            <div class="col-md-7 mb-3">
                <div id="map" style="height: 400px; border-radius: 15px; overflow: hidden;"></div>
                {{-- <div class="d-flex justify-content-end mt-2">
                    <img src="../../img/Emergency/Banner.png" alt="ตำแหน่งของคุณ" class="emergency-banner">
                </div> --}}
            </div>

            <!-- ✅ คอลัมน์ขวา: ฟอร์ม -->
            <div class="col-md-5 bg-body-secondary emergency-form-bg text-black p-3">
                <div class="mb-2">
                    <label for="picture-emergency" class="form-label">ตัวอย่างภาพสถานที่เกิดเหตุ</label>
                    <input type="file" name="picture" id="picture-emergency" class="form-control" accept="image/*">
                </div>

                <div class="mb-2">
                    <label for="name" class="form-label">ชื่อผู้แจ้งเหตุ</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="กรอกชื่อ-นามสกุลของผู้แจ้งเหตุ">
                </div>

                <div class="mb-2">
                    <label for="tel" class="form-label">เบอร์โทรที่ติดต่อได้</label>
                    <input type="tel" class="form-control" id="tel" name="tel" pattern="\d{10}" maxlength="10"
                        placeholder="กรอกตัวเลข 10 หลัก" required>
                    <small class="form-text text-muted">กรอกตัวเลข 10 หลัก เช่น 0812345678</small>
                </div>

                <div class="mb-2">
                    <label for="description" class="form-label">รายละเอียด</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-danger rounded-pill px-4" id="submit-btn">
                        คลิกเพื่อแจ้งเหตุ
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- โหลด Leaflet + SweetAlert2 --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('emergency-form');
            const salutationSelect = document.getElementById('salutation');

            // --- Leaflet Map ---
            var map = L.map('map').setView([13.6840, 100.5500], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);

            var userIcon = L.icon({
                iconUrl: '../../../img/admin-water/1.png',
                iconSize: [20, 32],
                iconAnchor: [10, 32],
                popupAnchor: [0, -32]
            });

            var userMarker = null;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    userMarker = L.marker([lat, lng], {
                            icon: userIcon
                        })
                        .addTo(map)
                        .bindPopup("คุณอยู่ที่นี่").openPopup();
                    map.setView([lat, lng], 15);
                    document.getElementById('lat').value = lat;
                    document.getElementById('lng').value = lng;
                });
            }

            map.on('click', function(e) {
                if (userMarker) map.removeLayer(userMarker);
                userMarker = L.marker([e.latlng.lat, e.latlng.lng], {
                        icon: userIcon
                    })
                    .addTo(map)
                    .bindPopup("ตำแหน่งที่คุณเลือก").openPopup();
                document.getElementById('lat').value = e.latlng.lat;
                document.getElementById('lng').value = e.latlng.lng;
            });

            // --- ตรวจสอบค่า salutation ---
            salutationSelect.addEventListener('change', function() {
                const selectedValue = this.value;
                console.log('ผู้ใช้เลือกเหตุผล:', selectedValue);
            });

            // --- Submit form ---
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const fields = [{
                        id: 'name',
                        label: 'กรุณากรอกชื่อผู้แจ้งเหตุ'
                    },
                    {
                        id: 'lat',
                        label: 'กรุณาเลือกตำแหน่งบนแผนที่'
                    },
                    {
                        id: 'picture-emergency',
                        label: 'กรุณาอัพโหลดรูปภาพ'
                    },
                    {
                        id: 'tel',
                        label: 'กรุณากรอกเบอร์โทร'
                    },
                    {
                        id: 'description',
                        label: 'กรุณากรอกรายละเอียด'
                    }
                ];

                for (let f of fields) {
                    const el = document.getElementById(f.id);
                    if (!el.value || el.value.trim() === '') {
                        Swal.fire({
                            icon: 'warning',
                            title: f.label,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false
                        });
                        return;
                    }
                }

                Swal.fire({
                    title: 'คุณต้องการส่งข้อมูลใช่หรือไม่?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'ตกลง',
                    cancelButtonText: 'ยกเลิก',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        let formData = new FormData(form);
                        fetch(form.action, {
                                method: 'POST',
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'ส่งไปยังหน่วยงานที่เกี่ยวข้องเรียบร้อยแล้ว',
                                        confirmButtonText: 'OK',
                                        allowOutsideClick: false
                                    }).then(() => {
                                        window.location.href = '/user/waterworks';
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'เกิดข้อผิดพลาด',
                                        text: data.message || 'กรุณาลองใหม่อีกครั้ง',
                                        confirmButtonText: 'OK',
                                        allowOutsideClick: false
                                    });
                                }
                            })
                            .catch(err => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาด',
                                    text: 'กรุณาลองใหม่อีกครั้ง',
                                    confirmButtonText: 'OK',
                                    allowOutsideClick: false
                                });
                            });
                    }
                });
            });
        });
    </script>
@endsection
