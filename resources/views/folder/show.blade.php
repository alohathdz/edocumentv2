@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>แฟ้ม : {{ $folder->name }}</h5>
            </div>
            <div class="ms-auto">
                <!-- ปุ่ม Home -->
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm"><i class="bi bi-house-door"></i> หน้าแรก</a>
                <a href="{{ route('folder.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-backspace-fill"></i> ย้อนกลับ</a>
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table class="table table-primary table-bordered table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>ประเภท</th>
                        <th>ที่</th>
                        <th>เรื่อง</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($receives as $receive)
                    <tr>
                        <td>หนังสือรับ</td>
                        <td>{{ $receive->no }}</td>
                        <td class="text-start">
                            {{ Str::limit($receive->topic, 100) }}
                            @if ($receive->urgency != "ไม่มี")
                            <span style="color:red">({{ $receive->urgency }})</span>
                            @endif
                            @if (!empty($receive->file))
                            <a href="{{ route('receive.download', $receive->id) }}" target="_blank">
                                <i class="bi bi-file-earmark-text-fill"></i>
                            </a>
                            @endif
                        </td>
                        <td>
                            <!-- ปุ่มแก้ไข -->
                            <a href="{{ route('receive.edit', $receive->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <!-- ปุ่มลบ -->
                            <a href="{{ route('receive.destroy', $receive->id) }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('ยืนยันการลบข้อมูล');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @foreach ($sends as $send)
                    <tr>
                        <td>หนังสือส่ง</td>
                        <td>{{ $send->no }}</td>
                        <td class="text-start">
                            {{ Str::limit($send->topic, 100) }}
                            @if ($send->urgency != "ไม่มี")
                            <span style="color:red">({{ $send->urgency }})</span>
                            @endif
                            @if (!empty($send->file))
                            <a href="{{ route('send.download', $send->id) }}" target="_blank">
                                <i class="bi bi-file-earmark-text-fill"></i>
                            </a>
                            @endif
                        </td>
                        <td>
                            <!-- ปุ่มแก้ไข -->
                            <a href="{{ route('send.edit', $send->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <!-- ปุ่มลบ -->
                            <a href="{{ route('send.destroy', $send->id) }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('ยืนยันการลบข้อมูล');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @foreach ($presents as $present)
                    <tr>
                        <td>หนังสือนำเรียน</td>
                        <td>{{ $present->no }}</td>
                        <td class="text-start">
                            {{ Str::limit($present->topic, 100) }}
                            @if ($present->urgency != "ไม่มี")
                            <span style="color:red">({{ $present->urgency }})</span>
                            @endif
                            @if (!empty($present->file))
                            <a href="{{ route('present.download', $present->id) }}" target="_blank">
                                <i class="bi bi-file-earmark-text-fill"></i>
                            </a>
                            @endif
                        </td>
                        <td>
                            <!-- ปุ่มแก้ไข -->
                            <a href="{{ route('present.edit', $present->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <!-- ปุ่มลบ -->
                            <a href="{{ route('present.destroy', $present->id) }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('ยืนยันการลบข้อมูล');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @foreach ($commands as $command)
                    <tr>
                        <td>คำสั่ง</td>
                        <td>{{ $command->no }}</td>
                        <td class="text-start">
                            {{ Str::limit($command->topic, 100) }}
                            @if (!empty($command->file))
                            <a href="{{ route('command.download', $command->id) }}" target="_blank">
                                <i class="bi bi-file-earmark-text-fill"></i>
                            </a>
                            @endif
                        </td>
                        <td>
                            <!-- ปุ่มแก้ไข -->
                            <a href="{{ route('command.edit', $command->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <!-- ปุ่มลบ -->
                            <a href="{{ route('command.destroy', $command->id) }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('ยืนยันการลบข้อมูล');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @foreach ($certificates as $certificate)
                    <tr>
                        <td>หนังสือรับรอง</td>
                        <td class="text-start">
                            {{ $certificate->certificateType->name }}
                            {{ $certificate->name }}
                            @if (!empty($certificate->file))
                            <a href="{{ route('certificate.download', $certificate->id) }}" target="_blank">
                                <i class="bi bi-file-earmark-text-fill"></i>
                            </a>
                            @endif
                        </td>
                        <td>
                            <!-- ปุ่มแก้ไข -->
                            <a href="{{ route('certificate.edit', $certificate->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <!-- ปุ่มลบ -->
                            <a href="{{ route('certificate.destroy', $certificate->id) }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('ยืนยันการลบข้อมูล');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
@if (session('success'))
<script>
    Swal.fire({
    icon: "success",
    title: "{{ Session::get('success') }}",
});
</script>
@endif
@endsection