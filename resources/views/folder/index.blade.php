@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>จัดการข้อมูลแฟ้ม</h5>
            </div>
            <div class="ms-auto">
                <!-- ปุ่ม Home -->
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm"><i class="bi bi-house-door"></i> หน้าแรก</a>
                <!-- ปุ่มเพิ่ม -->
                <a href="{{ route('folder.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> เพิ่มแฟ้ม</a>
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table class="table table-primary table-bordered table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อแฟ้ม</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @php
                    $i = 1;
                    @endphp
                    @foreach ($folders as $folder)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $folder->name }}</td>
                        <td>
                            <form action="{{ route('folder.destroy', $folder->id) }}" method="post">
                                <a href="{{ route('folder.edit', $folder->id) }}" class="btn btn-warning btn-sm"><i
                                        class="bi bi-pencil-square"></i></a>

                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูล!')"><i class="bi bi-trash"></i></a>
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