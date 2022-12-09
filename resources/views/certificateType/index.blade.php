@extends('layouts.app')

@section('content')
<div class="container col-md-4">
    <div class="row justify-content-center">
        <div class="d-flex gap2">
            <div class="me-auto">
                <h5>ประเภทการรับรอง</h5>
            </div>
            <div class="ms-auto">
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm"><i class="bi bi-house-door"></i> หน้าแรก</a>
                <a href="{{ route('certificateType.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> เพิ่มประเภท</a>
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table class="table table-bordered table-primary table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ประเภทการรับรอง</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($ctypes as $ctype)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $ctype->name }}</td>
                        <td>
                            <form action="{{ route('certificateType.destroy', $ctype->id) }}" method="post">
                                <a href="{{ route('certificateType.edit', $ctype->id) }}" class="btn btn-warning btn-sm"><i
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