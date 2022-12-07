@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>จัดการข้อมูลฝ่ายอำนวยการ</h5>
            </div>
            <div class="ms-auto">
                <!-- ปุ่ม Home -->
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm"><i class="bi bi-house-door"></i> หน้าแรก</a>
                <!-- ปุ่มเพิ่ม -->
                <a href="{{ route('department.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> เพิ่มส่วนราชการ</a>
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table class="table table-primary table-bordered table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อเต็ม</th>
                        <th>ชื่อย่อ</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @php
                    $i = 1;
                    @endphp
                    @foreach ($depts as $dept)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $dept->name }}</td>
                        <td>{{ $dept->initial }}</td>
                        <td>
                            <form action="{{ route('department.destroy', $dept->id) }}" method="post">
                                <a href="{{ route('department.edit', $dept->id) }}" class="btn btn-warning btn-sm"><i
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
    showConfirmButton: false,
    timer: 1500
});
</script>
@endif
@endsection