@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>แก้ไขข้อมูลประเภทการรับรอง</h5>
            </div>
        </div>
        <!-- Card -->
        <div class="card text-center mt-1">
            <div class="card-body">
                <form action="{{ route('certificateType.update', $ctype->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <!-- ชื่อประเภทการรับรอง -->
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">ประเภทการรับรอง</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ $ctype->name }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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