@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>จัดการข้อมูลเจ้าหน้าที่</h5>
            </div>
            <div class="ms-auto">
                <!-- ปุ่ม Home -->
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm"><i class="bi bi-house-door"></i> หน้าแรก</a>
                <!-- ปุ่มรอยืนยัน -->
                <button type="button" class="btn btn-primary btn-sm position-relative" data-bs-toggle="modal"
                    data-bs-target="#modalPreUser"><i class="bi bi-people"></i> ตรวจสอบเจ้าหน้าที่
                    @if ($pre_users->count() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $pre_users->count() }}
                    </span>
                    @endif
                </button>
                <!-- ปุ่มเพิ่ม -->
                <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> เพิ่มเจ้าหน้าที่</a>
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table class="table table-bordered table-primary table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อ - สกุล</th>
                        <th>ฝ่าย</th>
                        <th>บทบาท</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @php
                    $i = 1;
                    @endphp
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->department->initial }}</td>
                        @if ($user->role == 0)
                        <td class="text-secondary">รอยืนยัน</td>
                        @elseif ($user->role == 1)
                        <td class="text-danger">ผู้ดูแลระบบ</td>
                        @elseif ($user->role == 2)
                        <td class="text-primary">เจ้าหน้าที่สารบรรณ</td>
                        @elseif ($user->role == 3)
                        <td class="text-success">เจ้าหน้าที่ฝ่ายอำนวยการ</td>
                        @endif
                        <td>
                            <form action="{{ route('user.destroy', $user->id) }}" method="post">
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm"><i
                                        class="bi bi-pencil-square"></i></a>

                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit"
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
<!-- Modal Pre-User -->
<div class="modal fade" id="modalPreUser" tabindex="-1" aria-labelledby="modalPreUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เจ้าหน้าที่รอยืนยัน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($pre_users->count() > 0)
                <div class="table-reponsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อ - สกุล</th>
                                <th>สังกัด</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 1;
                            @endphp
                            @foreach ($pre_users as $pre)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $pre->name }}</td>
                                <td>{{ $pre->department->name }}</td>
                                <td>
                                    <form action="{{ route('user.destroy', $pre->id) }}" method="post">
                                        <a href="{{ route('user.edit', $pre->id) }}" class="btn btn-primary btn-sm"><i
                                                class="bi bi-check-lg"></i></a>

                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit"
                                            onclick="return confirm('ยืนยันการลบข้อมูล!')"><i
                                                class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <span>ไม่มีเจ้าหน้าที่รอยืนยัน</span>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิด</button>
            </div>
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