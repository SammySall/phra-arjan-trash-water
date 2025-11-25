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
            font-size: 16px;
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
            font-size: 18px;
            margin-bottom: 20px;
        }

        .checkbox-item {
            display: block;
            position: relative;
            padding-left: 25px;
            /* margin-bottom: 5px; */
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
    <table style="width: 100%; border-collapse: collapse; table-layout: fixed; margin-top:1rem; margin-bottom:1.5rem;">
        <tr>
            <!-- คอลัมน์ซ้าย 70% -->
            <td style="width: 70%; vertical-align: top;">
                <table width="100%">
                    <tr>
                        <td style="width:70px; vertical-align:top;">
                            <img src="{{ public_path('img/icon/อบต.png') }}" alt="LOGO" style="width:64px;">
                        </td>

                        <td style="vertical-align:middle;">
                            <div>
                                <span style="font-size: 18px; font-weight: bold;">
                                    องค์การบริหารส่วนตำบลพระอาจารย์
                                </span><br>

                                <span>
                                    ม.5 ถ.คลองหกวา ต.พระอาจารย์ อ.องค์รักษ์ จ.นครนายก 26120
                                </span><br>

                                <span>
                                    โทร.037-610559
                                </span>
                            </div>
                        </td>
                    </tr>
                </table>


                <div class="box_text" style="text-align: right;">
                    <span>เล่มที่
                        <span class="dotted-line" style="width: 10%; text-align: center;">
                            {{ $fields['field_20'] ?? '-' }}</span>
                        <span>เลขที่
                            <span class="dotted-line" style="width: 10%; text-align: center;">
                                {{ $fields['field_20'] ?? '-' }}</span>
                </div>

                <div style="text-align: center;">
                    <div class="title_doc">ใบเสร็จรับเงินค่ามูลฝอย</div>
                </div>
                <div class="box_text" style="text-align: left;">
                    <span>ผู้ใช้ขยะเลขที่</span>
                    <span class="dotted-line" style="width: 28%;">
                        {{ $fields['field_20'] ?? '-' }}</span>
                    <span>ชื่อ</span>
                    <span class="dotted-line" style="width: 55%;">{{ $fields['field_2'] ?? '' }}
                        {{ $fields['field_1'] ?? '-' }}</span>
                </div>

                <div class="box_text" style="text-align: left;">
                    <span>ที่อยู่</span>
                    <span class="dotted-line" style="width: 95%;">
                        {{ $fields['field_5'] ?? '' }}
                        {{ $fields['field_6'] ?? '' }}
                        {{ $fields['field_7'] ?? '' }}
                        {{ $fields['field_8'] ?? '' }}
                    </span>
                    <br>
                    <span>ประเภท</span>
                    <span class="dotted-line" style="width:40%; text-align: left;">
                        {{ $fields['field_20'] ?? '-' }}</span>
                    <span>ประจำเดือน</span>
                    <span class="dotted-line" style="width: 39%; text-align: left;">
                        {{ $fields['field_3'] ?? '-' }}</span>
                    <br>


                    <span>เป็นเงิน</span>
                    <span class="dotted-line"
                        style="width: 33%;">{{ $fields['field_4'] ?? '-' }}.{{ $fields['field_15'] ?? '00' }}</span>
                    <span>บาท (</span>
                    <span class="dotted-line" style="width: 50%;">{{ $fields['field_20'] ?? '' }}</span>
                    <span>)</span>
                </div>

                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <!-- ฝั่งซ้าย: ผู้เก็บเงิน -->
                        <td style="width: 50%; vertical-align: bottom;">
                            <div class="signature-item" style="text-align: left;">
                                <span>(ลงนาม)</span>
                                <span class="dotted-line"
                                    style="width: 80%; display: inline-block; text-align: center;">
                                    @if ($fields['field_31'] !== null && ($fields['status'] === 'รออนุมัติ' || $fields['status'] === 'ชำระแล้ว'))
                                        <img src="{{ public_path('img/signature/' . $fields['field_31'] . '.jpg') }}"
                                            alt="signature1" style="width:50%; margin-top:1.5rem;">
                                    @endif
                                </span>
                                <div>
                                    <span style="margin-left:2.5rem;">(</span>
                                    <span class="dotted-line"
                                        style="width: 75%; display: inline-block; text-align: center;">
                                        {{ $fields['field_31'] && ($fields['status'] === 'รออนุมัติ' || $fields['status'] === 'ชำระแล้ว') ? $fields['field_31'] : '' }}
                                    </span>
                                    <span>)</span>
                                </div>
                                <span style=" margin-left:7rem;">ผู้เก็บเงิน</span>
                            </div>
                        </td>

                        <!-- ฝั่งขวา: ผู้อำนวยการกองคลัง -->
                        <td style="width: 50%; vertical-align: bottom;">
                            <div class="signature-item" style="text-align: left;">
                                <span>(ลงนาม)</span>
                                <span class="dotted-line"
                                    style="width: 80%; display: inline-block; text-align: center;">
                                    @if ($fields['field_31'] !== null && $fields['status'] === 'ชำระแล้ว')
                                        <img src="{{ public_path('img/signature/1.jpg') }}" alt="signature2"
                                            style="width:50%; ">
                                    @endif
                                </span>
                                <div>
                                    <span style="margin-left:2.5rem;">(</span>
                                    <span class="dotted-line"
                                        style="width: 75%; display: inline-block; text-align: center;">
                                        {{ $fields['field_31'] && $fields['status'] === 'ชำระแล้ว' ? 'นางสาวสมยา จันทร์ฟัก' : '' }}
                                    </span>
                                    <span>)</span>
                                </div>
                                <span style=" margin-left:6rem;">ผู้อำนวยการกองคลัง</span>
                            </div>
                        </td>
                    </tr>
                </table>

            </td>

            <!-- คอลัมน์ขวา 30% -->
            <td style="width: 30%; vertical-align: top; padding-left:1rem">

                <table width="100%">
                    <tr>
                        <td style="vertical-align:top;">
                            <img src="{{ public_path('img/icon/อบต.png') }}" alt="LOGO" style="width:64px;">
                        </td>

                        <td style="vertical-align:middle;">
                            <div>
                                <span style="font-size: 18px; font-weight: bold;">
                                    ใบแจ้งหนี้<br>
                                    (ไม่ใช่ใบเสร็จรับเงิน)
                                </span>
                            </div>
                        </td>
                    </tr>
                </table>
                <div>
                    องค์การบริหารส่วนตำบลพระอาจารย์<br>
                    โทร.037-610559
                </div>

                <div class="box_text" style="text-align: right;">
                    <span>เล่มที่
                        <span class="dotted-line" style="width: 35%; text-align: center;">
                            {{ $fields['field_20'] ?? '-' }}</span>
                        <span>เลขที่
                            <span class="dotted-line" style="width: 35%; text-align: center;">
                                {{ $fields['field_20'] ?? '-' }}</span>
                </div>

                <div class="box_text" style="text-align: left;">
                    <span>ผู้ใช้น้ำเลขที่</span>
                    <span class="dotted-line" style="width: 70%;">
                        {{ $fields['field_8'] ?? '-' }}</span>
                    <span>ชื่อผู้ใช้น้ำ</span>
                    <span class="dotted-line" style="width: 75%;">{{ $fields['field_2'] ?? '' }}
                        {{ $fields['field_1'] ?? '-' }}</span>
                </div>
                <hr>
                <div class="box_text" style="text-align: left;">
                    <span style="margin-left:1rem; font-size:16px; font-weight: bold; text-align: justify;">
                        ยังมิได้ชำระเงินค่าขยะให้กับองค์การ
                        บริหารส่วนตำบลพระอาจารย์ ฉะนั้น
                        ให้นำเงินตำนวนดังกล่าวชำระต่อ กองคลัง
                        องค์การบริหารส่วนตำบลพระอาจารย์
                        ภายใน 7 วัน นับถัดจากวันที่ได้รับใบแจ้งนี้
                        หากพ้นกำหนด องค์การบริหารส่วนตำบล
                        พระอาจารย์จะดำเนินการตามที่เห็นสมควร
                        ต่อไป
                    </span>
                </div>
                <div class="signature-item" style="text-align: left;">
                    <span>(ลงนาม)</span>
                    <span class="dotted-line" style="width: 75%; display: inline-block; text-align: center;">
                        @if (isset($fields['field_99']) && ($fields['status'] === 'รออนุมัติ' || $fields['status'] === 'ชำระแล้ว'))
                            <img src="{{ public_path('img/signature/1.jpg') }}" alt="signature2" style="width:50%; ">
                        @endif
                    </span>
                    <div>
                        <span style="margin-left:2.3rem;">(</span>
                        <span class="dotted-line" style="width: 73%; display: inline-block; text-align: center;">
                            {{ isset($fields['field_99'], $fields['status']) && $fields['status'] === 'ชำระแล้ว' ? 'นางสาวสมยา จันทร์ฟัก' : '' }}
                        </span>
                        <span>)</span>
                    </div>
                    <span style=" margin-left:3rem;">พนักงานเก็บเงินค่าประปา</span>

                </div>
            </td>
        </tr>
    </table>

</body>

</html>
