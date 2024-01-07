@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>แก้ไขข้อมูลแฟ้ม</h5>
            </div>
        </div>
        <!-- Card -->
        <div class="card text-center mt-1">
            <div class="card-body">
                <form action="{{ route('folder.update', $folder->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <!-- ชื่อเต็ม -->
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">ชื่อแฟ้ม</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ $folder->name }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <!-- เลือกเจ้าของแฟ้ม -->
                    <div class="row mb-3">
                        <label for="user_id" class="col-md-4 col-form-label text-md-end">เจ้าของแฟ้ม</label>
                        <div class="col-md-5">
                            <select name="user_id" id="user_id" class="form-select">
                                @foreach ($users as $row)
                                <option value="{{ $row->id }}" @if ($row->id == $folder->user_id)selected @endif>{{ $row->name }}</option>
                                @endforeach
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