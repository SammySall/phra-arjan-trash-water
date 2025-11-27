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
                    {{-- <img src="{{ public_path('img/menuuser/LOGO.png') }}" alt="LOGO" style="width:150px; margin-bottom:10px;"> --}}
                    <div class="title_doc">ใบเสร็จรับเงินค่าประปา</div>
                </div>


                <div class="box_text" style="text-align: right;">
                    <span>วันที่</span>
                    <span class="dotted-line" style="width: 10%; text-align: center;">
                        {{ $fields['field_20'] ?? '-' }}</span>
                    <span>เดือน</span>
                    <span class="dotted-line" style="width: 13%; text-align: center;">
                        {{ $fields['field_20'] ?? '-' }}</span>
                    <span>พ.ศ.</span>
                    <span class="dotted-line" style="width: 10%; text-align: center;">
                        {{ $fields['field_20'] ?? '-' }}</span>
                </div>

                <div class="box_text" style="text-align: left; margin-left:1rem;">
                    <span>ผู้ใช้น้ำเลขที่</span>
                    <span class="dotted-line" style="width: 20%;">
                        {{ $fields['field_8'] ?? '-' }}</span>
                    <span>ชื่อผู้ใช้น้ำ</span>
                    <span class="dotted-line" style="width: 57%;">{{ $fields['field_2'] ?? '' }}
                        {{ $fields['field_1'] ?? '-' }}</span>
                </div>

                <div class="box_text" style="text-align: left; margin-left:1rem;">
                    <span>ที่อยู่</span>
                    <span class="dotted-line" style="width: 95%;">
                        {{ $fields['field_7'] ?? '-' }}
                    </span>
                    <br>
                    <span>ประเภท</span>
                    <span class="dotted-line" style="width: 36%; text-align: left;">
                        {{ $fields['field_20'] ?? '' }}</span>
                    <span>เส้นทางการเก็บเงิน</span>
                    <span class="dotted-line" style="width: 36%; text-align: left;">
                        {{ $fields['field_20'] ?? '' }}</span>
                    <br>
                    <span>ค่าน้ำประปาประจำเดือน</span>
                    <span class="dotted-line" style="width: 76%; text-align: left;">
                        {{ $fields['field_3'] ?? '-' }}</span>
                    <br>

                    <table style="width:100%; border-collapse: collapse; font-family: 'THSarabunNew', sans-serif;">
                        <thead>
                            <tr>
                                <th style="border:1px solid #000; padding:5px; width:30%; text-align:center;">รายการ
                                </th>
                                <th style="border:1px solid #000; padding:5px; width:10%; text-align:center;">
                                    จำนวนหน่วยของมาตราวัดน้ำ</th>
                                <th style="border:1px solid #000; padding:5px; width:30%; text-align:center;">จำนวนเงิน
                                    (บาท)
                                </th>
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
                                <td
                                    style="border:1px solid #000; padding:5px; vertical-align: center; text-align:right;">
                                    {{-- <span class="dotted-line" style="width: 100%; text-align: left;">
                                        {{ $fields['field_4'] ?? '' }}.{{ $fields['field_15'] ?? '' }}</span> --}}
                                </td>
                            </tr>
                            <tr>
                                <!-- คอลัมน์ซ้าย -->
                                <td colspan="2" style="text-align:right;">
                                    <span><strong><u>คูณ</u></strong> อัตราค่าน้ำหน่วยละ</span>
                                    <span class="dotted-line" style="width: 10%; text-align: center;">
                                        {{ $fields['field_10'] ?? '-' }}
                                    </span>
                                    <span>บาท เป็นจำนวนเงินค่าน้ำ</span>
                                    <br>
                                    <span><strong><u>บวก</u></strong> ค่ารักษามาตรวัดน้ำ</span><br>
                                    <span>รวมเป็นเงินทั้งสิ้น</span><br>
                                </td>

                                <!-- คอลัมน์ขวา -->
                                <td style="border:1px solid #000; padding:5px; text-align:left;">
                                    <span class="dotted-line" style="width: 100%; text-align: left;">
                                        {{ $fields['field_4'] - 10 ?? '' }}.{{ $fields['field_15'] ?? '' }}</span><br>
                                    <span class="dotted-line" style="width: 100%; text-align: left;">
                                        {{ $fields['field_4'] ? '10' : '-' }}</span><br>
                                    <span class="dotted-line" style="width: 100%; text-align: left;">
                                        {{ $fields['field_4'] ?? '' }}.{{ $fields['field_15'] ?? '' }}
                                    </span><br>
                                </td>
                            </tr>
                            <!-- แถวรวม -->

                        </tbody>
                    </table>
                </div>

                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <!-- ฝั่งซ้าย: ผู้เก็บเงิน -->
                        <td style="width: 50%; vertical-align: bottom;">
                            <div class="signature-item" style="text-align: left;">
                                <span>(ลงนาม)</span>
                                <span class="dotted-line"
                                    style="width: 80%; display: inline-block; text-align: center;">
                                    @if ($fields['field_12'] !== null && ($fields['status'] === 'รออนุมัติ' || $fields['status'] === 'ชำระแล้ว'))
                                        <img src="{{ public_path('img/signature/' . $fields['field_12'] . '.jpg') }}"
                                            alt="signature1" style="width:50%; margin-top:1.5rem;">
                                    @endif
                                </span>
                                <div>
                                    <span style="margin-left:2.5rem;">(</span>
                                    <span class="dotted-line"
                                        style="width: 75%; display: inline-block; text-align: center;">
                                        {{ $fields['field_12'] && ($fields['status'] === 'รออนุมัติ' || $fields['status'] === 'ชำระแล้ว') ? $fields['field_12'] : '' }}
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
                                    @if ($fields['field_12'] !== null && $fields['status'] === 'ชำระแล้ว')
                                        <img src="{{ public_path('img/signature/1.jpg') }}" alt="signature2"
                                            style="width:50%; ">
                                    @endif
                                </span>
                                <div>
                                    <span style="margin-left:2.5rem;">(</span>
                                    <span class="dotted-line"
                                        style="width: 75%; display: inline-block; text-align: center;">
                                        {{ $fields['field_12'] && $fields['status'] === 'ชำระแล้ว' ? 'นางสาวสมยา จันทร์ฟัก' : '' }}
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
                <h3 style="text-align: left; margin:0px;">
                    ยังมิได้ชำระเงินค่าน้ำประปา
                </h3>
                <div class="box_text" style="text-align: left;">
                    <span style="margin-left:1rem; font-size:16px; font-weight: bold; text-align: justify;">
                        ให้กับองค์การบริหารส่วนตำบลพระอาจารย์
                        ฉะนั้นให้นำเงินตำนวนดังกล่าวชำระต่อ
                        กองคลังองค์การบริหารส่วนตำบลพระอาจารย์
                        ภายใน 7 วัน นับถัดจากวันที่ได้รับใบแจ้งนี้
                        หากพ้นกำหนดการประปา องค์การบริหาร
                        ส่วนตำบลพระอาจารย์จะดำเนินการตามที่
                        เห็นสมควรต่อไป
                    </span>
                </div>
                <div class="signature-item" style="text-align: left;">
                    <span>(ลงนาม)</span>
                    <span class="dotted-line" style="width: 75%; display: inline-block; text-align: center;">
                                    @if ($fields['field_12'] !== null && ($fields['status'] === 'รออนุมัติ' || $fields['status'] === 'ชำระแล้ว'))
                            <img src="{{ public_path('img/signature/' . $fields['field_12'] . '.jpg') }}"
                                alt="signature1" style="width:50%; margin-top:1.5rem;">
                        @endif
                    </span>
                    <div>
                        <span style="margin-left:2.3rem;">(</span>
                        <span class="dotted-line" style="width: 73%; display: inline-block; text-align: center;">
                            {{ $fields['field_12'] && ($fields['status'] === 'รออนุมัติ' || $fields['status'] === 'ชำระแล้ว') ? $fields['field_12'] : '' }}
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
