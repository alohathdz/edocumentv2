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
        body {
            font-family: "THSarabunNew";
        }
        table {
            border-collapse: collapse;
        }
    </style>
    <title>Receive - Export</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td>#</td>
                <td>ลง</td>
                <td>จาก</td>
                <td>เรื่อง</td>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($receives as $receive)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ datethaitext($receive->date) }}</td>
                <td>{{ $receive->from }}</td>
                <td>{{ $receive->topic }}</td>
            </tr> 
            @endforeach
        </tbody>
    </table>
</body>
</html>