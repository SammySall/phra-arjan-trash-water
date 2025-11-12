@extends('layout.layout-admin-trash')
@section('title', 'Dashboard')

@section('desktop-content')
    <h1 class="text-center px-2 mb-4">รายละเอียดข้อมูลการติดตั้งถังขยะ</h1>

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
        <div id="map-desktop" style="height: 400px; border-radius: 15px; overflow: hidden;"></div>

        {{-- Bills Table --}}
        <div class="mt-4">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>จำนวนเงิน</th>
                            <th>สถานะการชำระ</th>
                            <th>วันครบกำหนด</th>
                            <th>วันที่ชำระ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($location->bills as $index => $bill)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ number_format($bill->amount, 2) }} บาท</td>
                                <td>
                                    @if ($bill->status == 'ชำระแล้ว')
                                        <span class="badge bg-success">{{ $bill->status }}</span>
                                    @elseif ($bill->status == 'รอการตรวจสอบ')
                                        <span class="badge bg-warning text-dark">{{ $bill->status }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $bill->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $bill->due_date ? \Carbon\Carbon::parse($bill->due_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $bill->paid_date ? \Carbon\Carbon::parse($bill->paid_date)->format('d/m/Y') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">ไม่มีข้อมูล</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const lat = {{ $location->lat ?? 13.736717 }};
            const lng = {{ $location->lng ?? 100.523186 }};

            const map = L.map("map-desktop").setView([lat, lng], 15);

            L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);

            const trashIcon = L.icon({
                iconUrl: "{{ asset('img/trash-installer/1.png') }}",
                iconSize: [30, 55],
                iconAnchor: [22, 45],
                popupAnchor: [0, -40]
            });

            const marker = L.marker([lat, lng], {
                    icon: trashIcon
                })
                .addTo(map)
                .bindPopup("{{ $location->name ?? 'ตำแหน่งติดตั้งถังขยะ' }}")
                .openPopup();
        });
    </script>
@endsection

@section('mobile-content')
    <h3 class="text-center px-2 mb-4">รายละเอียดข้อมูลการติดตั้งถังขยะ</h3>

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
    <div id="map-mobile" style="height: 400px; border-radius: 15px; overflow: hidden;"></div>

    {{-- Bills Table --}}
    <div class="mt-4">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>จำนวนเงิน</th>
                        <th>สถานะการชำระ</th>
                        <th>วันครบกำหนด</th>
                        <th>วันที่ชำระ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($location->bills as $index => $bill)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ number_format($bill->amount, 2) }} บาท</td>
                            <td>
                                @if ($bill->status == 'ชำระแล้ว')
                                    <span class="badge bg-success">{{ $bill->status }}</span>
                                @elseif ($bill->status == 'รอการตรวจสอบ')
                                    <span class="badge bg-warning text-dark">{{ $bill->status }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $bill->status }}</span>
                                @endif
                            </td>
                            <td>{{ $bill->due_date ? \Carbon\Carbon::parse($bill->due_date)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $bill->paid_date ? \Carbon\Carbon::parse($bill->paid_date)->format('d/m/Y') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">ไม่มีข้อมูล</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Leaflet --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const lat = {{ $location->lat ?? 13.736717 }};
            const lng = {{ $location->lng ?? 100.523186 }};

            const map = L.map("map-mobile").setView([lat, lng], 15);

            L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);

            const trashIcon = L.icon({
                iconUrl: "{{ asset('img/trash-installer/1.png') }}",
                iconSize: [30, 55],
                iconAnchor: [22, 45],
                popupAnchor: [0, -40]
            });

            const marker = L.marker([lat, lng], {
                    icon: trashIcon
                })
                .addTo(map)
                .bindPopup("{{ $location->name ?? 'ตำแหน่งติดตั้งถังขยะ' }}")
                .openPopup();
        });
    </script>
@endsection
