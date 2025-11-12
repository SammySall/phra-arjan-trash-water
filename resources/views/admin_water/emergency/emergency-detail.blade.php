@extends('layout.layout-admin-water')
@section('title', 'รายละเอียดเหตุฉุกเฉิน')

@section('desktop-content')
    <h3 class="text-center px-2 mb-4">รายละเอียดเหตุ</h3>
    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">

        <div class="mb-3"><strong>ชื่อ :</strong> {{ $location->name ?? '-' }}</div>
        <div class="mb-3"><strong>เบอร์โทรศัพท์ :</strong> {{ $location->tel ?? '-' }}</div>
        <div class="mb-3"><strong>รายละเอียด :</strong> {{ $location->description ?? '-' }}</div>

        {{-- ลิงก์ไปยังรูปเหตุฉุกเฉิน --}}
        <div class="mb-3">
            <strong>รูปเหตุ:</strong>
            @if ($location->picture)
                <a href="{{ asset('storage/' . $location->picture) }}" target="_blank">
                    ดูรูปเหตุ
                </a>
            @else
                <span>ไม่มีรูปเหตุ</span>
            @endif
        </div>

        <div class="mb-3"><strong>แผนที่ตำแหน่ง:</strong></div>
        <div id="map" style="height: 400px; border-radius: 15px; overflow: hidden;"></div>
    </div>

    {{-- โหลด Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- สร้าง icon แบบรูปภาพ และหมุนด้วย class -->
    <style>
        .rotated-marker img {
            transform: rotate(45deg);
            /* หมุน 45 องศา */
            transform-origin: center center;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const lat = {{ $location->lat ?? 13.736717 }};
            const lng = {{ $location->lng ?? 100.523186 }};

            const map = L.map("map", {
                center: [lat, lng],
                zoom: 15,
                tap: false
            });

            L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);

            // สร้าง icon แบบรูปภาพ
            const customIcon = L.icon({
                iconUrl: '{{ asset('img/admin-water/1.png') }}',
                iconSize: [50, 50],
                iconAnchor: [25, 25],
                popupAnchor: [0, -25],
                className: 'rotated-marker' // ใส่ class สำหรับหมุน
            });

            // ปักหมุด
            L.marker([lat, lng], {
                    icon: customIcon
                })
                .addTo(map)
                .bindPopup("{{ $location->name ?? 'ตำแหน่งเหตุฉุกเฉิน' }}")
                .openPopup();
        });
    </script>

@endsection
