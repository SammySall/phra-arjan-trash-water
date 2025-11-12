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
    <div style="text-align: center">๕</div>
    <div style="text-align: right; font-weight: bold;">สม.4</div>
    <div class="title_doc">คำร้องขออนุญาตลงถังขยะ</div>

    <div class="box_text" style="text-align: right;">
        <span>เขียนที่เทศบาลตำบลท่าข้าม <br>112 หมู่ 3 ตำบลท่าข้าม <br>อำเภอบางปะกง จังหวัดฉะเชิงเทรา</span>
        <div style="margin-top: 10px;">
            <span>วันที่</span>
            <span class="dotted-line" style="width: 5%; text-align: center;">{{ $day ?: '-' }}</span>
            <span>เดือน</span>
            <span class="dotted-line" style="width: 15%; text-align: center;">{{ $month ?: '-' }}</span>
            <span>พ.ศ.</span>
            <span class="dotted-line" style="width: 10%; text-align: center;">{{ $year ?: '-' }}</span>
        </div>
    </div>

    <div class="box_text" style="text-align: right;">
        <span>ข้าพเจ้า</span>
        <span class="dotted-line" style="width: 40%; text-align: left;">
            {{ $fields['field_2'] ?? '-' }} {{ $fields['field_1'] ?? '-' }}
        </span>
        <span>อายุ</span>
        <span class="dotted-line" style="width: 15%; text-align: left;">{{ $fields['field_5'] ?? '-' }}</span>
        <span>สัญชาติ</span>
        <span class="dotted-line" style="width: 17%; text-align: left;">{{ $fields['field_6'] ?? '-' }}</span>
    </div>

    <div class="box_text" style="text-align: left;">
        <span>อยู่บ้านเลขที่</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_7'] ?? '-' }}</span>
        <span>หมู่ที่</span>
        <span class="dotted-line" style="width: 10%;">{{ $fields['field_8'] ?? '-' }}</span>
        <span>ตรอก/ซอย</span>
        <span class="dotted-line" style="width: 22%;">{{ $fields['field_13'] ?? '-' }}</span>
        <span>ถนน</span>
        <span class="dotted-line" style="width: 22%;">{{ $fields['field_14'] ?? '-' }}</span>
        <span>ตำบล/แขวง</span>
        <span class="dotted-line" style="width: 24%;">{{ $fields['field_9'] ?? '-' }}</span>
        <span>.อำเภอ/เขต</span>
        <span class="dotted-line" style="width: 24%;">{{ $fields['field_10'] ?? '-' }}</span>
        <span>จังหวัด</span>
        <span class="dotted-line" style="width: 24%;">{{ $fields['field_11'] ?? '-' }}</span>
        <span>เบอร์โทรศัพท์</span>
        <span class="dotted-line" style="width: 25%;">{{ $fields['field_3'] ?? '-' }}</span>
        <span>โทรสาร</span>
        <span class="dotted-line" style="width: 25%;">{{ $fields['field_'] ?? '-' }}</span>
    </div>

    <div class="box_text" style="text-align: left; margin-left:5rem;margin-top:10px;">
        <span>มีความประสงค์</span>
        <span class="dotted-line" style="min-width: 50%; margin-left: 10px;">{{ $fields['field_12'] ?? '-' }}</span>
    </div>

    <div class="box_text" style="text-align: left;">
        <span>เอกสารหลักฐานที่แนบ ดังนี้</span>
    </div>

    <div class="box_text" style="text-align: left; margin-top:10px;">

        <div style="margin-left:5rem;">
            <label>
                <input type="checkbox" {{ in_array('files1', $uploadedFiles ?? []) ? 'checked' : '' }}>
                สำเนาบัตรประจำตัว (ประชาชน/ข้าราชการ/พนักงานรัฐวิสาหกิจ/อื่น ๆ)
            </label>
        </div>

        <div style="margin-left:5rem; margin-top:5px;">
            <label>
                <input type="checkbox" {{ in_array('files2', $uploadedFiles ?? []) ? 'checked' : '' }}>
                สำเนาหนังสือรับรองการจดทะเบียนนิติบุคคล พร้อมสำเนาบัตรประจำตัวประชาชนของผู้แทนนิติบุคคล
                (ในกรณีที่ผู้ขออนุญาตเป็นนิติบุคคล)
            </label>
        </div>

        <div style="margin-left:5rem; margin-top:5px;">
            <label>
                <input type="checkbox" {{ in_array('files3', $uploadedFiles ?? []) ? 'checked' : '' }}>
                หนังสือรับรองอำนาจ ในกรณีที่เจ้าของกิจการไม่มายื่นขออนุญาตด้วยตนเอง
            </label>
        </div>

        <div style="margin-left:5rem; margin-top:5px;">
            <label>
                <input type="checkbox" {{ in_array('files4', $uploadedFiles ?? []) ? 'checked' : '' }}>
                เอกสารหลักฐานอื่น ๆ
            </label>
        </div>

        <div style="margin-left:5rem; margin-top:10px;">
            <label>
                ขอรับรองว่าข้อความตามแบบคำขอนี้เป็นความจริงทุกประการ
            </label>
        </div>

    </div>



    <div class="box_text" style="text-align: center; margin-top:0.5rem; margin-bottom:1.5rem;">
        <span>ลงชื่อ</span>
        <span class="dotted-line" style="width: 35%;">{{ $fields['field_1'] ?? '-' }}</span>
        <span>ผู้ขออนุญาต</span>
        <div style="margin-left: -30px;">
            <span>(</span>
            <span class="dotted-line" style="width: 35%;">{{ $fields['field_2'] ?? '-' }}
                {{ $fields['field_1'] ?? '-' }}</span>
            <span>)</span>
        </div>
    </div>

</body>

</html>
