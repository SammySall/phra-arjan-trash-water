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
                    <div class="col-9 d-flex flex-column align-items-center">
                        <div class="mb-1 w-100 d-flex justify-content-end">
                            <img src="../../img/GarbageCarStatus/Banner-2.png" alt="ถังขยะ" class="trash-toxic-banner">
                        </div>
                        <div class="w-100 d-flex justify-content-end">
                            <img src="../../img/GarbageCarStatus/Banner-3.png" alt="ตำแหน่งของคุณ"
                                class="trash-toxic-banner">
                        </div>
                    </div>

                    <div class="col-3 d-flex justify-content-center align-items-center">
                        <img src="../../img/GarbageCarStatus/Arrow.png" alt="ลูกศร" class="trash-arrow">
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div id="map" style="height: 400px; border-radius: 15px; overflow: hidden;"></div>
            </div>
        </div>
    </div>

    {{-- Google Maps --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvHH0EByocwPJmp4Gi6oUjCNxWJ7XS5kM"></script>

    <script>
        function initMap() {
            // พิกัดเริ่มต้น
            const center = {
                lat: 13.6840,
                lng: 100.5500
            };

            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 13,
                center: center,
                mapTypeId: "roadmap"
            });

            // ไอคอนถังขยะ
            const trashIcon = {
                url: "../../img/GarbageCarStatus/Icon-1.png",
                scaledSize: new google.maps.Size(28, 32)
            };

            // ไอคอนผู้ใช้
            const userIcon = {
                url: "../../img/GarbageCarStatus/Icon-2.png",
                scaledSize: new google.maps.Size(30, 40)
            };

            // จุดทิ้งขยะ
            const points = [{
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

            // วาด Marker ถังขยะ
            points.forEach(p => {
                const marker = new google.maps.Marker({
                    position: {
                        lat: p.lat,
                        lng: p.lng
                    },
                    map: map,
                    icon: trashIcon,
                    title: p.name
                });

                // เมื่อคลิก Marker ให้เปิด Google Maps สำหรับนำทาง
                marker.addListener("click", () => {
                    const url = `https://www.google.com/maps/dir/?api=1&destination=${p.lat},${p.lng}`;
                    window.open(url, "_blank"); // เปิดในแท็บใหม่
                });
            });


            // แสดงตำแหน่งผู้ใช้
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        const user = {
                            lat: pos.coords.latitude,
                            lng: pos.coords.longitude
                        };

                        new google.maps.Marker({
                            position: user,
                            map: map,
                            icon: userIcon,
                            title: "คุณอยู่ที่นี่"
                        });

                        map.setCenter(user);
                        map.setZoom(15);
                    },
                    (err) => {
                        console.warn("ไม่สามารถระบุตำแหน่งผู้ใช้:", err);
                    }
                );
            }
        }

        document.addEventListener("DOMContentLoaded", initMap);
    </script>

@endsection
