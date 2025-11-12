@extends('layout.layout-admin-trash')
@section('title', 'Dashboard')

@section('desktop-content')
    <h3 class="text-center px-2 mb-4">รายละเอียดข้อมูลการติดตั้งถังขยะ</h3>

    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">

        <div class="mb-3"><strong>ชื่อ :</strong> {{ $location->name ?? '-' }}</div>
        <div class="mb-3"><strong>ที่อยู่ :</strong> {{ $location->address ?? '-' }}</div>
        <div class="mb-3"><strong>เบอร์โทรศัพท์ :</strong> {{ $location->tel ?? '-' }}</div>

        <div class="mb-3">
            <strong>สถานะ :</strong>
            @if ($location->status == 'เสร็จสิ้น')
                <span class="badge bg-success">ติดตั้งถังขยะแล้ว</span>
            @else
                <span class="badge bg-warning">รอติดตั้ง</span>
            @endif
        </div>

        <div class="mb-3">
            <img src="{{ url('../img/trash-installer/2.png') }}" alt="icon-5" class="img-fluid logo-img">
            <strong>แผนที่ตำแหน่งติดตั้ง:</strong>
        </div>


        <!-- Desktop map -->
        <div id="map-desktop" style="height: 400px; border-radius: 15px; overflow: hidden;"></div>
    </div>
    {{-- โหลด Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const lat = {{ $location->lat ?? 13.736717 }};
            const lng = {{ $location->lng ?? 100.523186 }};

            const mapDesktop = L.map("map-desktop").setView([lat, lng], 15);

            const googleMap = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(mapDesktop);

            const trashIcon = L.icon({
                iconUrl: "{{ asset('img/trash-installer/1.png') }}",
                iconSize: [30, 55],
                iconAnchor: [22, 45],
                popupAnchor: [0, -40]
            });

            const markerDesktop = L.marker([lat, lng], {
                    icon: trashIcon
                })
                .addTo(mapDesktop)
                .bindPopup("{{ $location->name ?? 'ตำแหน่งติดตั้งถังขยะ' }}")
                .openPopup();

            mapDesktop.on('click', function(e) {
                if (confirm("ต้องการเปลี่ยนตำแหน่งหมุดหรือไม่?")) {
                    markerDesktop.setLatLng(e.latlng)
                        .bindPopup("ตำแหน่งใหม่")
                        .openPopup();
                }
            });

            // รีคำนวณขนาดเมื่อ window resize
            window.addEventListener('resize', () => mapDesktop.invalidateSize());
        });
    </script>
@endsection

@section('mobile-content')
    <h3 class="text-center px-2 mb-4">รายละเอียดข้อมูลการติดตั้งถังขยะ</h3>

    <div class="container bg-white bg-opacity-75 p-5 rounded-3 shadow-sm">

        <div class="mb-3"><strong>ชื่อ :</strong> {{ $location->name ?? '-' }}</div>
        <div class="mb-3"><strong>ที่อยู่ :</strong> {{ $location->address ?? '-' }}</div>
        <div class="mb-3"><strong>เบอร์โทรศัพท์ :</strong> {{ $location->tel ?? '-' }}</div>

        <div class="mb-3">
            <strong>สถานะ :</strong>
            @if ($location->status == 'เสร็จสิ้น')
                <span class="badge bg-success">ติดตั้งถังขยะแล้ว</span>
            @else
                <span class="badge bg-warning">รอติดตั้ง</span>
            @endif
        </div>

        <div class="mb-3">
            <img src="{{ url('../img/trash-installer/2.png') }}" alt="icon-5" class="img-fluid logo-img">
            <strong>แผนที่ตำแหน่งติดตั้ง:</strong>
        </div>

        <!-- Mobile map -->
        <div id="map-mobile" style="height: 400px; border-radius: 15px; overflow: hidden;"></div>

    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const lat = {{ $location->lat ?? 13.736717 }};
            const lng = {{ $location->lng ?? 100.523186 }};

            const mapMobile = L.map("map-mobile").setView([lat, lng], 15);

            const googleMap = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(mapMobile);

            const trashIcon = L.icon({
                iconUrl: "{{ asset('img/trash-installer/1.png') }}",
                iconSize: [30, 55],
                iconAnchor: [22, 45],
                popupAnchor: [0, -40]
            });

            const markerMobile = L.marker([lat, lng], {
                    icon: trashIcon
                })
                .addTo(mapMobile)
                .bindPopup("{{ $location->name ?? 'ตำแหน่งติดตั้งถังขยะ' }}")
                .openPopup();

            mapMobile.on('click', function(e) {
                if (confirm("ต้องการเปลี่ยนตำแหน่งหมุดหรือไม่?")) {
                    markerMobile.setLatLng(e.latlng)
                        .bindPopup("ตำแหน่งใหม่")
                        .openPopup();
                }
            });

            window.addEventListener('resize', () => mapMobile.invalidateSize());
        });
    </script>
@endsection
