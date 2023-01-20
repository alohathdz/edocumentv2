<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receive - Export</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>ลงวันที่</th>
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