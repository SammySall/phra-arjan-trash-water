@extends('layout.layout-user')
@section('title', 'Water Usage Detail')
@section('body-class', 'body-waterworks-bg')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/statistics-water.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="container py-4">
        <div class="row">
            <div class="col-md-2">
                <a href="{{ route('user.water_payment.statistics') }}">
                    <img src="../../../img/water-menu-page/Back-Button.png" alt="ปุ่มกลับ" class="back-garbage-btn mb-4">
                </a>
            </div>

            <div class="col-md-10 bg-body-secondary text-black p-4 rounded shadow-sm">
                <div class="d-flex align-items-center mb-4">
                    <img src="../../../img/statistics-water/Image.png" alt="banner"
                        class="img-fluid rounded shadow-sm me-2" style="width:60px;">
                    <h1 class="fw-bold me-4 text-title-color mb-0">สถิติใช้น้ำ</h1>
                    <div class="text-title d-flex flex-wrap">
                        <div class="me-5">
                            <div class="text-title-top">เลขทะเบียนลูกค้า</div>
                            <div class="text-title-content">{{ $location->water_user_no ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-title-top">ชื่อผู้ใช้น้ำ</div>
                            <div class="text-title-content">{{ $user->name ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                {{-- ปุ่ม toggle --}}
                <div class="d-flex justify-content-center my-3">
                    <button id="btnAmount" class="btn btn-primary px-4 me-3">จำนวนเงิน</button>
                    <button id="btnUsage" class="btn btn-outline-primary px-4">จำนวนการใช้น้ำ</button>
                </div>


                {{-- แถวสำหรับกราฟและตาราง --}}
                <div class="row">
                    {{-- กราฟ --}}
                    <div class="col-md-6">
                        <div class="bg-white rounded p-3 shadow-sm mb-4">
                            <canvas id="waterChart" height="200"></canvas>
                        </div>
                    </div>

                    {{-- ตาราง --}}
                    <div class="col-md-6">
                        <span id="tableTitle" style="display:none;"></span>
                        <table id="dataTable" class="table table-striped text-center align-middle">
                            <thead class="table-info">
                                <tr>
                                    <th>รอบบิล</th>
                                    <th id="colTitle">ค่าน้ำ (ปีปัจจุบัน)</th>
                                    <th>ส่วนต่างระหว่างเดือน</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <!-- ข้อมูลจะถูกเติมโดย JavaScript -->
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('waterChart').getContext('2d');
        const btnAmount = document.getElementById('btnAmount');
        const btnUsage = document.getElementById('btnUsage');
        const tableBody = document.getElementById('tableBody');
        const colTitle = document.getElementById('colTitle');

        // ดึงข้อมูลจาก Laravel
        const billData = @json($billData);
        const usageData = @json($usageData);

        // เตรียมข้อมูลสำหรับกราฟ
        const billMonths = billData.map(item => item.month);
        const billAmounts = billData.map(item => item.amount);

        const usageMonths = usageData.map(item => item.month);
        const usageAmounts = usageData.map(item => item.usage);

        // ฟังก์ชันสร้างตาราง
        function renderTable(data, type = 'amount') {
            tableBody.innerHTML = '';
            colTitle.textContent = type === 'amount' ? 'ค่าน้ำ (บาท)' : 'ปริมาณการใช้น้ำ (ลบ.ม.)';

            for (let i = 0; i < data.length; i++) {
                const current = data[i].value;
                const prev = i < data.length - 1 ? data[i + 1].value : null;

                // ✅ เนื่องจากข้อมูลเรียงใหม่ → เก่า
                // ส่วนต่างควรเป็น (current - prev) โดย prev คือเดือนก่อนหน้า
                let diff = prev !== null ? current - prev : 0;

                const diffText = diff > 0 ? `+${diff.toFixed(2)}` : diff.toFixed(2);

                const tr = document.createElement('tr');
                tr.innerHTML = `
            <td>${data[i].month}</td>
            <td>${current}</td>
            <td class="${diff > 0 ? 'text-danger' : 'text-success'}">${diffText}</td>
        `;

                // ✅ ใช้ appendChild ปกติ (ไม่ prepend)
                tableBody.appendChild(tr);
            }
        }




        // แปลงเป็นโครงสร้างที่ใช้เหมือนกัน
        const amountTable = billData.map(b => ({
            month: b.month,
            value: b.amount
        }));
        const usageTable = usageData.map(u => ({
            month: u.month,
            value: u.usage
        }));

        // เริ่มต้น: แสดงจำนวนเงิน
        renderTable(amountTable, 'amount');

        let chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: billMonths,
                datasets: [{
                    label: 'จำนวนเงิน (บาท)',
                    data: billAmounts,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#0d6efd'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Toggle ปุ่ม
        btnAmount.addEventListener('click', () => {
            chart.data.labels = billMonths;
            chart.data.datasets[0].label = 'จำนวนเงิน (บาท)';
            chart.data.datasets[0].data = billAmounts;
            chart.update();
            renderTable(amountTable, 'amount');

            btnAmount.classList.add('btn-primary');
            btnAmount.classList.remove('btn-outline-primary');
            btnUsage.classList.remove('btn-primary');
            btnUsage.classList.add('btn-outline-primary');
        });

        btnUsage.addEventListener('click', () => {
            chart.data.labels = usageMonths;
            chart.data.datasets[0].label = 'ปริมาณการใช้น้ำ (ลบ.ม.)';
            chart.data.datasets[0].data = usageAmounts;
            chart.update();
            renderTable(usageTable, 'usage');

            btnUsage.classList.add('btn-primary');
            btnUsage.classList.remove('btn-outline-primary');
            btnAmount.classList.remove('btn-primary');
            btnAmount.classList.add('btn-outline-primary');
        });
    </script>

@endsection
