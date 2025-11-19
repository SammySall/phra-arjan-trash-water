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
        <div class="title_doc">ใบเสร็จรับเงินค่ามูลฝอย</div>
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
        <span>ผู้ใช้ขยะเลขที่</span>
        <span class="dotted-line" style="width: 20%;">
            {{ $fields['field_20'] ?? '-' }}</span>
        <span>ชื่อ</span>
        <span class="dotted-line" style="width: 47%;">{{ $fields['field_2'] ?? '' }}
            {{ $fields['field_1'] ?? '-' }}</span>
    </div>

    <div class="box_text" style="text-align: left; margin-left:5rem;">
        <span>ที่อยู่</span>
        <span class="dotted-line" style="width: 79%;">
            {{ $fields['field_5'] ?? '-' }}
            {{ $fields['field_6'] ?? '' }}
            {{ $fields['field_7'] ?? '' }}
            {{ $fields['field_8'] ?? '' }}
        </span>
        <br>
        <span>ประเภท</span>
        <span class="dotted-line" style="width: 32%; text-align: left;">
            {{ $fields['field_20'] ?? '-' }}</span>
        <span>ประจำเดือน</span>
        <span class="dotted-line" style="width: 32%; text-align: left;">
            {{ $fields['field_3'] ?? '-' }}</span>
        <br>


        <span>เป็นเงิน</span>
        <span class="dotted-line"
            style="width: 30%;">{{ $fields['field_4'] ?? '-' }}.{{ $fields['field_15'] ?? '00' }}</span>
        <span>บาท (</span>
        <span class="dotted-line" style="width: 28%;">{{ $fields['field_20'] ?? '' }}</span>
        <span>)</span>
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
                @if ($fields['field_31'] !== null && ($fields['status'] === 'รออนุมัติ' || $fields['status'] === 'ชำระแล้ว'))
                    <img src="{{ public_path('img/signature/' . $fields['field_31'] . '.jpg') }}" alt="signature1"
                        style="width:50%; margin-top:1.5rem;">
                @endif
            </span>
            <div>
                <span>(</span>
                <span class="dotted-line" style="width: 35%; display: inline-block; text-align: center;">
                    {{ $fields['field_31'] && ($fields['status'] === 'รออนุมัติ' || $fields['status'] === 'ชำระแล้ว') ? $fields['field_31'] : '' }}
                </span>
                <span style=" margin-right:1.6rem;">)</span>
            </div>
            <span style=" margin-right:8rem;">ผู้เก็บเงิน</span>
        </div>

        <div class="signature-item" style="text-align: right; margin-top:1.5rem;">
            <span>(ลงนาม)</span>
            <span class="dotted-line"
                style="width: 40%; display: inline-block; text-align: center;  margin-right:1.5rem;">
                @if ($fields['field_31'] !== null && $fields['status'] === 'ชำระแล้ว')
                    <img src="{{ public_path('img/signature/1.jpg') }}" alt="signature1" style="width:50%;">
                @endif
            </span>
            <div>
                <span>(</span>
                <span class="dotted-line" style="width: 35%; display: inline-block; text-align: center;">
                    {{ $fields['field_31'] && $fields['status'] === 'ชำระแล้ว' ? 'นางสาวสมยา จันทร์ฟัก' : '' }}
                </span>
                <span style=" margin-right:1.6rem;">)</span>
            </div>
            <span style=" margin-right:5rem;">ผู้อำนวยการกองคลัง</span>
        </div>

    </div>


</body>

</html>
