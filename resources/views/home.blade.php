@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('role'))
    <div class="row justify-content-center">
        <div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ Session::get('role') }} (กรุณา Click ปุ่ม <a href="{{ route('home') }}" class="btn btn-primary btn-sm"><i class="bi bi-house-door-fill"></i></a> เพื่อกลับหน้าแรก)
        </div>
    </div>
    @else
    @admin
    <!-- Menu จัดการข้อมูลพื้นฐาน -->
    <div class="row justify-content-center text-center">
        <div class="col-sm-4">
            <div class="card border-primary">
                <div class="card-header">
                    <strong>ข้อมูลพื้นฐาน</strong>
                </div>
                <div class="card-body">
                    <a href="{{ route('department.index') }}" class="btn btn-primary btn-sm"><i
                            class="bi bi-building"></i> ฝ่ายอำนวยการ</a>
                    <a href="{{ route('user.index') }}" class="btn btn-success btn-sm"><i class="bi bi-person"></i>
                        เจ้าหน้าที่</a>
                    <a href="{{ route('certificateType.index') }}" class="btn btn-danger btn-sm"><i
                            class="bi bi-card-checklist"></i> ประเภทการรับรอง</a>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="card border-primary">
                <div class="card-header">
                    <strong>หนังสือราชการ</strong>
                </div>
                <div class="card-body">
                    <a href="{{ route('receive.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-file-earmark-text"></i> หนังสือรับ</a>
                    <a href="{{ route('send.index') }}" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-text"></i> หนังสือส่ง</a>
                    <a href="{{ route('present.index') }}" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-text"></i> หนังสือนำเรียน</a>
                    <a href="{{ route('command.index') }}" class="btn btn-warning btn-sm"><i class="bi bi-file-earmark-text"></i> คำสั่ง</a>
                    <a href="{{ route('certificate.index') }}" class="btn btn-info btn-sm"><i class="bi bi-file-earmark-text"></i> หนังสือรับรอง</a>
                </div>
            </div>
        </div>
    </div>
    @endadmin
    @saraban
    <!-- Menu จัดการข้อมูลหนังสือ -->
    <div class="row justify-content-center text-center">
        <div class="col-sm-5">
            <div class="card border-primary">
                <div class="card-header">
                    <strong>หนังสือราชการ</strong>
                </div>
                <div class="card-body">
                    <a href="{{ route('receive.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-file-earmark-text"></i> หนังสือรับ</a>
                    <a href="{{ route('send.index') }}" class="btn btn-success btn-sm"><i class="bi bi-pencil-square"></i> หนังสือส่ง</a>
                    <a href="{{ route('present.index') }}" class="btn btn-danger btn-sm"><i class="bi bi-pencil-square"></i> หนังสือนำเรียน</a>
                    <a href="{{ route('command.index') }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i> คำสั่ง</a>
                    <a href="{{ route('certificate.index') }}" class="btn btn-info btn-sm"><i class="bi bi-pencil-square"></i> หนังสือรับรอง</a>
                </div>
            </div>
        </div>
    </div>
    @endsaraban
    @employee
    <!-- Menu จัดการข้อมูลหนังสือ -->
    <div class="row justify-content-center text-center">
        <div class="col-sm-4">
            <div class="card border-primary">
                <div class="card-header">
                    <strong>หนังสือราชการ</strong>
                </div>
                <div class="card-body">
                    <a href="{{ route('send.index') }}" class="btn btn-success btn-sm"><i class="bi bi-pencil-square"></i> หนังสือส่ง</a>
                    <a href="{{ route('present.index') }}" class="btn btn-danger btn-sm"><i class="bi bi-pencil-square"></i> หนังสือนำเรียน</a>
                    <a href="{{ route('command.index') }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i> คำสั่ง</a>
                    <a href="{{ route('certificate.index') }}" class="btn btn-info btn-sm"><i class="bi bi-pencil-square"></i> หนังสือรับรอง</a>
                </div>
            </div>
        </div>
    </div>
    @endemployee
    @user
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">สถานะ</div>
                <div class="card-body">
                    รอยืนยันการลงทะเบียน
                </div>
            </div>
        </div>
    </div>
    @enduser
    @endif
</div>
@endsection