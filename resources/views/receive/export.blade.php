<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ asset('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ asset('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";
        }

        table {
            width: 100%;
            font-size: 14pt;
        }

        th {
            text-align: left;
        }

        p {
            font-size: 16pt;
            font-weight: bold;
            margin-top: 0;
            margin-bottom: 0;
        }

    </style>
    <title>หนังสือรับ</title>
</head>

<body>
    <p>รายการหนังสือรับ</p>
    <p>ระยะห้วง {{ $dateFrom }} - {{ $dateTo }}</p>
    <p>ออกรายงานโดย {{ Auth::user()->name }}</p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>ลง</th>
                <th>จาก</th>
                <th>เรื่อง</th>
            </tr>
        </thead>
        <tbody>
            @php
            $i = 1;
            @endphp
            @foreach ($receives as $receive)
            <tr>
                <td style="font-weight: bold">{{ $i++ }}</td>
                <td>{{ datethaitext($receive->date) }}</td>
                <td>{{ Str::limit($receive->from, 20) }}</td>
                <td>{{ Str::limit($receive->topic, 80) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>