@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>แก้ไขข้อมูลฝ่ายอำนวยการ</h5>
            </div>
            <!-- ปุ่มย้อนกลับ -->
            <div class="ms-auto">
                <a href="{{ route('department.index') }}" class="btn btn-secondary btn-sm">Back</a>
            </div>
        </div>
        <!-- Card -->
        <div class="card text-center mt-1">
            <div class="card-body">
                <form action="{{ route('department.update', $dept->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <!-- ชื่อเต็ม -->
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">ชื่อเต็ม</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ $dept->name }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <!-- ชื่อย่อ -->
                    <div class="row mb-3">
                        <label for="initial" class="col-md-4 col-form-label text-md-end">ชื่อย่อ</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control @error('initial') is-invalid @enderror" id="initial"
                                name="initial" value="{{ $dept->initial }}" required autocomplete="initial" autofocus>

                            @error('initial')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <!-- Line Token -->
                    <div class="row mb-3">
                        <label for="line_token" class="col-md-4 col-form-label text-md-end">Line Token</label>
                        <div class="col-md-5">
                            <input id="line_token" type="text"
                                class="form-control @error('line_token') is-invalid @enderror" name="line_token"
                                value="{{ $dept->line_token }}" autocomplete="line_token" autofocus>

                            @error('line_token')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <!-- ปุ่มบันทึก -->
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection