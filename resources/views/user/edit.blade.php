@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>แก้ไขข้อมูลเจ้าหน้าที่</h5>
            </div>
        </div>
        <!-- Card -->
        <div class="card text-center mt-1">
            <div class="card-body">
                <form action="{{ route('user.update', $user->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <!-- Name -->
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">ชื่อ - สกุล</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <!-- E-mail -->
                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">E-Mail</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <!-- Password -->
                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" value="{{ old('password') }}" autocomplete="password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <!-- Confirm Password -->
                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirm
                            Password</label>
                        <div class="col-md-5">
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>
                    <!-- Department -->
                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">ฝ่ายอำนวยการ</label>
                        <div class="col-md-5">
                            <select name="department" id="department" class="col-md-4 col-form-label form-select">
                                @foreach ($depts as $dept)
                                <option value="{{ $dept->id }}" @if ($user->department_id == $dept->id)selected
                                    @endif>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- role -->
                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">บทบาท</label>
                        <div class="col-md-5">
                            <select name="role" id="role" class="col-md-4 col-form-label form-select">
                                <option value="0" @if ($user->role == 0)selected @endif>รอยืนยัน</option>
                                <option value="1" @if ($user->role == 1)selected @endif>ผู้ดูแลระบบ</option>
                                <option value="2" @if ($user->role == 2)selected @endif>เจ้าหน้าที่ฝ่ายอำนวยการ
                                </option>
                                <option value="3" @if ($user->role == 3)selected @endif>เจ้าหน้าที่กองร้อย
                                </option>
                            </select>
                        </div>
                    </div>
                    <!-- ปุ่มบันทึก -->
                    <button type="submit" class="btn btn-primary btn-sm">บันทึก</button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="history.back()">ยกเลิก</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection