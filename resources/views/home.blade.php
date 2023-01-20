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
        <div class="col-sm-3">
            <div class="card border-primary mb-2">
                <div class="card-header">
                    <strong>ผู้ดูแลระบบ</strong>
                </div>
                <div class="card-body">
                    <a href="/phpmyadmin" class="btn btn-primary btn-sm mb-1 col-md-5" target="_blank"><i class="bi bi-building"></i> MySQL</a><br>
                    <a href="https://ns31.hostinglotus.net:2222/" class="btn btn-success btn-sm mb-1 col-md-5" target="_blank"><i class="bi bi-person"></i> Directadmin</a><br>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card border-primary mb-2">
                <div class="card-header">
                    <strong>ข้อมูลพื้นฐาน</strong>
                </div>
                <div class="card-body">
                    <a href="{{ route('department.index') }}" class="btn btn-primary btn-sm mb-1 col-md-6"><i class="bi bi-building"></i> ฝ่ายอำนวยการ</a><br>
                    <a href="{{ route('user.index') }}" class="btn btn-success btn-sm mb-1 col-md-6"><i class="bi bi-person"></i> เจ้าหน้าที่</a><br>
                    <a href="{{ route('folder.index') }}" class="btn btn-warning btn-sm mb-1 col-md-6"><i class="bi bi-tags"></i> แฟ้มเอกสาร</a><br>
                    <a href="{{ route('certificateType.index') }}" class="btn btn-danger btn-sm mb-1 col-md-6"><i class="bi bi-card-checklist"></i> ประเภทการรับรอง</a>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card border-primary mb-2">
                <div class="card-header">
                    <strong>หนังสือราชการ</strong>
                </div>
                <div class="card-body">
                    <a href="{{ route('receive.index') }}" class="btn btn-primary btn-sm mb-1 col-md-6"><i class="bi bi-file-earmark-text"></i> หนังสือรับ</a><br>
                    <a href="{{ route('send.index') }}" class="btn btn-success btn-sm mb-1 col-md-6"><i class="bi bi-file-earmark-text"></i> หนังสือส่ง</a><br>
                    <a href="{{ route('present.index') }}" class="btn btn-danger btn-sm mb-1 col-md-6"><i class="bi bi-file-earmark-text"></i> หนังสือนำเรียน</a><br>
                    <a href="{{ route('command.index') }}" class="btn btn-warning btn-sm mb-1 col-md-6"><i class="bi bi-file-earmark-text"></i> คำสั่ง</a><br>
                    <a href="{{ route('certificate.index') }}" class="btn btn-info btn-sm mb-1 col-md-6"><i class="bi bi-file-earmark-text"></i> หนังสือรับรอง</a><br>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card border-primary">
                <div class="card-header">
                    <strong>สำเนา</strong>
                </div>
                <div class="card-body">
                    <a href="{{ route('copy.present') }}" class="btn btn-dark btn-sm mb-1 col-md-6"><i class="bi bi-file-earmark-text"></i> สำเนาหนังสือ</a><br>
                    <a href="{{ route('copy.command') }}" class="btn btn-secondary btn-sm mb-1 col-md-6"><i class="bi bi-file-earmark-text"></i> สำเนาคำสั่ง</a>
                </div>
            </div>
        </div>
    </div>
    @endadmin
    @saraban
    <!-- Menu จัดการข้อมูลพื้นฐาน -->
    <div class="row justify-content-center text-center">
        <div class="col-sm-4">
            <div class="card border-primary mb-2">
                <div class="card-header">
                    <strong>ข้อมูลพื้นฐาน</strong>
                </div>
                <div class="card-body">
                    <a href="{{ route('folder.index') }}" class="btn btn-warning btn-sm mb-1 col-sm-5"><i class="bi bi-tags"></i> แฟ้มเอกสาร</a><br>
                    <a href="{{ route('certificateType.index') }}" class="btn btn-danger btn-sm mb-1 col-sm-5"><i class="bi bi-card-checklist"></i> ประเภทการรับรอง</a>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="card border-primary mb-2">
                <div class="card-header">
                    <strong>หนังสือราชการ</strong>
                </div>
                <div class="card-body">
                    <a href="{{ route('receive.index') }}" class="btn btn-primary btn-sm mb-1 col-sm-4"><i class="bi bi-file-earmark-text"></i> หนังสือรับ</a><br>
                    <a href="{{ route('send.index') }}" class="btn btn-success btn-sm mb-1 col-sm-4"><i class="bi bi-file-earmark-text"></i> หนังสือส่ง</a><br>
                    <a href="{{ route('present.index') }}" class="btn btn-danger btn-sm mb-1 col-sm-4"><i class="bi bi-file-earmark-text"></i> หนังสือนำเรียน</a><br>
                    <a href="{{ route('command.index') }}" class="btn btn-warning btn-sm mb-1 col-sm-4"><i class="bi bi-file-earmark-text"></i> คำสั่ง</a><br>
                    <a href="{{ route('certificate.index') }}" class="btn btn-info btn-sm mb-1 col-sm-4"><i class="bi bi-file-earmark-text"></i> หนังสือรับรอง</a><br>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card border-primary">
                <div class="card-header">
                    <strong>สำเนา</strong>
                </div>
                <div class="card-body">
                    <a href="{{ route('copy.present') }}" class="btn btn-dark btn-sm mb-1 col-sm-6"><i class="bi bi-file-earmark-text"></i> สำเนาหนังสือ</a><br>
                    <a href="{{ route('copy.command') }}" class="btn btn-secondary btn-sm mb-1 col-sm-6"><i class="bi bi-file-earmark-text"></i> สำเนาคำสั่ง</a>
                </div>
            </div>
        </div>
    </div>
    @endsaraban
    @employee
    <!-- Menu จัดการข้อมูลหนังสือ -->
    <div class="row justify-content-center text-center">
        <div class="col-sm-3">
            <div class="card border-primary mb-2">
                <div class="card-header">
                    <strong>หนังสือราชการ</strong>
                </div>
                <div class="card-body">
                    <a href="{{ route('receive.saraban') }}" class="btn btn-primary btn-sm mb-1 col-sm-6"><i class="bi bi-file-earmark-text"></i> หนังสือรับ</a><br>
                    <a href="{{ route('present.index') }}" class="btn btn-danger btn-sm mb-1 col-sm-6"><i class="bi bi-file-earmark-text"></i> หนังสือนำเรียน</a><br>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card border-primary">
                <div class="card-header">
                    <strong>สำเนา</strong>
                </div>
                <div class="card-body">
                    <a href="{{ route('copy.present') }}" class="btn btn-dark btn-sm mb-1 col-sm-6"><i class="bi bi-file-earmark-text"></i> สำเนาหนังสือ</a><br>
                    <a href="{{ route('copy.command') }}" class="btn btn-secondary btn-sm mb-1 col-sm-6"><i class="bi bi-file-earmark-text"></i> สำเนาคำสั่ง</a>
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