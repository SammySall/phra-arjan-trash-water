@extends('layout.layout-user')
@section('title', 'Status Trash Page')
@section('body-class', 'body-garbage-bg')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-5">
                <a href="/user/waste_payment">
                    <img src="../../img/GarbageCarStatus/Back-Button.png" alt="ปุ่มกลับ" class="back-garbage-btn mb-4">
                </a>
                <div class="mb-2 d-flex justify-content-center align-items-end">
                    <img src="../../img/GarbageCarStatus/Banner-1.png" alt="จุดทิ้งขยะมีพิษ" class="trash-toxic-img">
                </div>
                <div class="row">
                    <!-- คอลัมน์ซ้าย: ถังขยะ + ตำแหน่งคุณ -->
                    <div class="col-9 d-flex flex-column align-items-center">
                        <div class="mb-1 w-100 d-flex justify-content-end">
                            <img src="../../img/GarbageCarStatus/Banner-2.png" alt="ถังขยะ" class="trash-toxic-banner">
                        </div>
                        <div class="w-100 d-flex justify-content-end">
                            <img src="../../img/GarbageCarStatus/Banner-3.png" alt="ตำแหน่งของคุณ" class="trash-toxic-banner">
                        </div>
                    </div>

                    <!-- คอลัมน์ขวา: ลูกศร -->
                    <div class="col-3 d-flex justify-content-center align-items-center">
                        <img src="../../img/GarbageCarStatus/Arrow.png" alt="ลูกศร" class="trash-arrow">
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                {{-- แผนที่ --}}
                <div id="map" style="height: 400px; border-radius: 15px; overflow: hidden;"></div>
            </div>
        </div>
    </div>

    {{-- โหลด Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map('map').setView([13.6840, 100.5500], 13);

            // พื้นหลังแผนที่
            var baseMaps = {
                "แผนที่": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19
                }),
                "ดาวเทียม": L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                })
            };
            baseMaps["แผนที่"].addTo(map);
            L.control.layers(baseMaps).addTo(map);

            // ไอคอนถังขยะ
            var customIcon = L.icon({
                iconUrl: '../../img/GarbageCarStatus/Icon-1.png', // เปลี่ยนเป็น path รูปของคุณ
                iconSize: [20, 25], // ขนาดของไอคอน
                iconAnchor: [20, 40], // จุดที่ไอคอนจิ้มลงบนพิกัด
                popupAnchor: [0, -40] // จุดเปิด popup
            });

            // ไอคอนผู้ใช้
            var userIcon = L.icon({
                iconUrl: '../../img/GarbageCarStatus/Icon-2.png', // ใส่ path ไอคอนผู้ใช้
                iconSize: [20, 32],
                iconAnchor: [20, 40],
                popupAnchor: [0, -40]
            });

            // Marker
            var points = [{
                    lat: 13.689,
                    lng: 100.553,
                    name: "จุดทิ้งขยะมีพิษ"
                },
                {
                    lat: 13.682,
                    lng: 100.547,
                    name: "จุดทิ้งขยะมีพิษ"
                },
                {
                    lat: 13.685,
                    lng: 100.559,
                    name: "จุดทิ้งขยะมีพิษ"
                }
            ];

            points.forEach(p => {
                L.marker([p.lat, p.lng], {
                    icon: customIcon
                }).addTo(map).bindPopup(p.name);
            });

            // แสดงตำแหน่งผู้ใช้
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLat = position.coords.latitude;
                    var userLng = position.coords.longitude;

                    L.marker([userLat, userLng], {
                            icon: userIcon
                        }).addTo(map)
                        .bindPopup("คุณอยู่ที่นี่")
                        .openPopup();

                    map.setView([userLat, userLng], 15);
                }, function(error) {
                    console.error("ไม่สามารถระบุตำแหน่งผู้ใช้ได้:", error);
                });
            } else {
                console.error("เบราว์เซอร์ไม่รองรับ Geolocation");
            }
        });
    </script>

@endsection
