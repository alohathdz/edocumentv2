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
                        <td>{{ $receive->topic }}</td>
                        <td>
                            <form action="{{ route('receive.destroy', $receive->id) }}" method="post">
                                <a href="{{ route('receive.show', $receive->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('receive.edit', $receive->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>

                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('ยืนยันการลบข้อมูล!')"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @foreach ($sends as $send)
                    <tr>
                        <td>หนังสือส่ง</td>
                        <td>{{ $send->no }}</td>
                        <td>{{ $send->topic }}</td>
                        <td>
                            <form action="{{ route('send.destroy', $send->id) }}" method="post">
                                <a href="{{ route('send.show', $send->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('send.edit', $send->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>

                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('ยืนยันการลบข้อมูล!')"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @foreach ($presents as $present)
                    <tr>
                        <td>หนังสือนำเรียน</td>
                        <td>{{ $present->no }}</td>
                        <td>{{ $present->topic }}</td>
                        <td>
                            <form action="{{ route('present.destroy', $present->id) }}" method="post">
                                <a href="{{ route('present.show', $present->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('present.edit', $present->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>

                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('ยืนยันการลบข้อมูล!')"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @foreach ($commands as $command)
                    <tr>
                        <td>คำสั่ง</td>
                        <td>{{ $command->no }}</td>
                        <td>{{ $command->topic }}</td>
                        <td>
                            <form action="{{ route('command.destroy', $command->id) }}" method="post">
                                <a href="{{ route('command.show', $command->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('command.edit', $command->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>

                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('ยืนยันการลบข้อมูล!')"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @foreach ($certificates as $certificate)
                    <tr>
                        <td>หนังสือรับรอง</td>
                        <td>{{ $certificate->certificateType->name }}</td>
                        <td>{{ $certificate->name }}</td>
                        <td>
                            <form action="{{ route('certificate.destroy', $certificate->id) }}" method="post">
                                <a href="{{ route('certificate.show', $certificate->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('certificate.edit', $certificate->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>

                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('ยืนยันการลบข้อมูล!')"><i class="bi bi-trash"></i></button>
                            </form>
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