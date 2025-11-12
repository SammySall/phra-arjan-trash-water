<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>รายงานยอดค้างชำระ</title>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        body {
            font-family: 'THSarabunNew';
            font-size: 20px;
            line-height: 1.3;
            margin: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>

<body style="font-family: 'THSarabunNew', sans-serif;">
    <h3>รายงานยอดค้างชำระ</h3>
    <p>ที่อยู่: {{ $location->address }}</p>
    <p>แสดงรายการทั้งหมด</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>ที่อยู่</th>
                <th>เดือน/ปี</th>
                <th>เบอร์โทร</th>
                <th>จำนวนเงิน (บาท)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($location->bills as $index => $bill)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $location->address }}</td>
                    <td>{{ \Carbon\Carbon::parse($bill->due_date)->format('m/Y') }}</td>
                    <td>{{ $location->tel ?? '-' }}</td>
                    <td>{{ number_format($bill->amount, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">รวม</td>
                <td>{{ number_format($totalPending, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
