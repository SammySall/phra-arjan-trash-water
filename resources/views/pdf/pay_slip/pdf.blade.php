<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>PDF Report</title>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew-Bold.ttf') }}") format('truetype');
        }

        body {
            font-family: 'THSarabunNew', sans-serif;
            font-weight: bold;
            font-size: 20px;
            line-height: 1;
        }

        .dotted-line {
            border-bottom: 2px dotted blue;
            display: inline-block;
        }

        .box_text {
            margin: 5px 0;
        }

        .title_doc {
            text-align: center;
            font-weight: bold;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .checkbox-item {
            display: block;
            position: relative;
            padding-left: 25px;
            margin-bottom: 5px;
        }

        .checkbox-item::before {
            content: " ";
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid black;
            position: absolute;
            left: 0;
            top: 0;
        }

        .checkbox-item.checked::before {
            content: "✓";
            font-weight: bold;
            text-align: center;
            line-height: 16px;
        }
    </style>
</head>

<body>
    <div style="margin-top: 20%; text-align: center;">
        {{-- <img src="{{ public_path('img/menuuser/LOGO.png') }}" alt="LOGO" style="width:150px; margin-bottom:10px;"> --}}
        <div class="title_doc">ใบเสร็จรับเงินค่าประปา</div>
    </div>


    <div class="box_text" style="text-align: right;">
        <span>เล่มที่
            <span class="dotted-line" style="width: 10%; text-align: center;">
                {{ $fields['field_20'] ?? '-' }}</span>
            <span>เลขที่
                <span class="dotted-line" style="width: 10%; text-align: center;">
                    {{ $fields['field_20'] ?? '-' }}</span>
    </div>

    <div class="box_text" style="text-align: left; margin-left:5rem;">
        <span>ผู้ใช้น้ำเลขที่</span>
        <span class="dotted-line" style="width: 20%;">
            {{ $fields['field_8'] ?? '-' }}</span>
        <span>ชื่อ</span>
        <span class="dotted-line" style="width: 47%;">{{ $fields['field_2'] ?? '' }}
            {{ $fields['field_1'] ?? '-' }}</span>
    </div>

    <div class="box_text" style="text-align: left; margin-left:5rem;">
        <span>ที่อยู่</span>
        <span class="dotted-line" style="width: 78%;">
            {{ $fields['field_7'] ?? '-' }}
        </span>
        <br>
        <span>ประเภท</span>
        <span class="dotted-line" style="width: 28%; text-align: left;">
            {{ $fields['field_20'] ?? '' }}</span>
        <span>เส้นทางการเก็บเงิน</span>
        <span class="dotted-line" style="width: 29%; text-align: left;">
            {{ $fields['field_20'] ?? '' }}</span>
        <br>
        <span>ค่าน้ำประปาประจำเดือน</span>
        <span class="dotted-line" style="width: 60%; text-align: left;">
            {{ $fields['field_3'] ?? '-' }}</span>
        <br>

        <table style="width:83%; border-collapse: collapse; font-family: 'THSarabunNew', sans-serif;">
            <thead>
                <tr>
                    <th style="border:1px solid #000; padding:5px; width:30%; text-align:center;">รายการ</th>
                    <th style="border:1px solid #000; padding:5px; width:10%; text-align:center;">
                        จำนวนหน่วยของมาตราวัดน้ำ</th>
                    <th style="border:1px solid #000; padding:5px; width:30%; text-align:center;">จำนวนเงิน (บาท)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border:1px solid #000; padding:5px; vertical-align: top; text-align: right;">
                        จดครั้งนี้วันที่ <span class="dotted-line" style="width: 63%; text-align: left;">
                            {{ $fields['field_20'] ?? '' }}</span><br>
                        จดครั้งก่อนวันที่ <span class="dotted-line" style="width: 55%; text-align: left;">
                            {{ $fields['field_20'] ?? '' }}</span><br>
                        <label style="text-align: right;">จำนวนหน่วยที่ใช้</label>
                    </td>
                    <td style="border:1px solid #000; padding:5px; vertical-align: top;">
                        <span class="dotted-line" style="width: 100%; text-align: left;">
                            {{ $fields['field_6'] ?? '-' }}</span><br>
                        <span class="dotted-line" style="width: 100%; text-align: left;">
                            {{ $fields['field_5'] ?? '-' }}</span><br>
                        <span class="dotted-line" style="width: 100%; text-align: left;">
                            {{ $fields['field_6'] - $fields['field_5'] ?? '-' }}</span><br>
                    </td>
                    <td style="border:1px solid #000; padding:5px; vertical-align: center; text-align:right;">
                        <span class="dotted-line" style="width: 100%; text-align: left;">
                            {{ $fields['field_4'] ?? '' }}.{{ $fields['field_15'] ?? '' }}</span>
                    </td>
                </tr>
                <!-- แถวรวม -->

            </tbody>
        </table>
        {{-- 
        <span>เป็นเงิน</span>
        <span class="dotted-line"
            style="width: 30%;">{{ $fields['field_4'] ?? '-' }}.{{ $fields['field_15'] ?? '00' }}</span>
        <span>บาท (</span>
        <span class="dotted-line" style="width: 28%;">{{ $fields['field_20'] ?? '' }}</span>
        <span>)</span> --}}
    </div>

    <div class="signature-section"
        style="display: flex; flex-direction: column; align-items: flex-end; gap: 2rem; margin-right: 5rem; margin-top:1rem; margin-bottom:1.5rem;">

        {{-- <div class="signature-item" style="text-align: right; margin-top: 3rem;">
            <div style="position: relative; display: inline-block;">
                <!-- รูป trash_1 -->
                <img src="{{ public_path('img/signature/trash_1.png') }}" alt="signature1"
                    style="width:30%; display: block;">
                <!-- รูป stamp ทับ trash_1 -->
                <img src="{{ public_path('img/signature/stamp.png') }}" alt="stamp"
                    style="width:20%; position: absolute; top: 0; right: 25%; opacity: 0.9;">
            </div>

            <div>
                <img src="{{ public_path('img/signature/trash_2.png') }}" alt="signature2" style="width:30%;">
            </div>
        </div> --}}


        <div class="signature-item" style="text-align: right;">
            <span>(ลงนาม)</span>
            <span class="dotted-line"
                style="width: 40%; display: inline-block; text-align: center;  margin-right:1.5rem;">
                <img src="{{ public_path('img/signature/' . $fields['field_12'] . '.jpg') }}" alt="signature1"
                    style="width:50%;">
            </span>
            <div>
                <span>(</span>
                <span class="dotted-line" style="width: 35%; display: inline-block; text-align: center;">
                    {{ $fields['field_12'] ?? '' }}
                </span>
                <span style=" margin-right:1.6rem;">)</span>
            </div>
            <span style=" margin-right:8rem;">ผู้เก็บเงิน</span>
        </div>

        <div class="signature-item" style="text-align: right; margin-top:1.5rem;">
            <span>(ลงนาม)</span>
            <span class="dotted-line"
                style="width: 40%; display: inline-block; text-align: center;  margin-right:1.5rem;">
                @if ($fields['field_12']!==null)
                    <img src="{{ public_path('img/signature/1.jpg') }}" alt="signature1"
                        style="width:50%;">
                @endif
            </span>
            <div>
                <span>(</span>
                <span class="dotted-line" style="width: 35%; display: inline-block; text-align: center;">
                    {{ $fields['field_12'] ? 'นางสาวสมยา จันทร์ฟัก' : '' }}
                </span>
                <span style=" margin-right:1.6rem;">)</span>
            </div>
            <span style=" margin-right:5rem;">ผู้อำนวยการกองคลัง</span>
        </div>

    </div>


</body>

</html>
