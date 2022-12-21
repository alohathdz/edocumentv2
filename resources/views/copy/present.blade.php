@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>สำเนาหนังสือ</h5>
            </div>
            <div class="ms-auto">
                <!-- ปุ่ม Home -->
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-house-door"></i> หน้าแรก
                </a>
                <!-- ปุ่มสำเนาคำสั่ง -->
                <a href="{{ route('copy.command') }}" class="btn btn-danger btn-sm">
                    <i class="bi bi-book"></i> สำเนาคำสั่ง
                </a>
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table class="table table-primary table-bordered table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>จาก</th>
                        <th>สำเนาเมื่อ</th>
                        <th>เรื่อง</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($presents as $present)
                    <tr>
                        <td>{{ $present->initial }}</td>
                        <td>{{ timestampthaitext($present->created_at) }}</td>
                        <td>{{ $present->topic }}</td>
                        <td>
                            <a href="{{ route('present.show', $present->present_id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $presents->links() }}
        </div>
    </div>
</div>
@endsection