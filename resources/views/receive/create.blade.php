@extends('layouts.app')

@section('content')
<div class="container col-md-5">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>รับหนังสือ</h5>
            </div>
            <!-- ปุ่มย้อนกลับ -->
            <div class="ms-auto">
                <a href="{{ route('receive.index') }}" class="btn btn-secondary btn-sm">Back</a>
            </div>
        </div>
        <!-- Form -->
        <form action="{{ route('receive.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card mt-1">
                <div class="card-body">
                    <div class="row g-2">
                        <!-- ที่หนังสือ -->
                        <div class="col-md-4">
                            <label for="no" class="col-form-label"><strong>ที่</strong></label>
                            <input type="text" class="form-control @error('no') is-invalid @enderror" id="no" name="no"
                                value="{{ old('no') }}" required autocomplete="no" autofocus>

                            @error('no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- วันที่หนังสือ -->
                        <div class="col-md-4">
                            <label for="date" class="col-form-label"><strong>ลง</strong></label>
                            <input type="text" class="form-control @error('date') is-invalid @enderror" id="date"
                                name="date" value="{{ old('date') }}" required readonly>

                            @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- จาก -->
                        <div class="col-md-4">
                            <label for="from" class="col-form-label"><strong>จาก</strong></label>
                            <input type="text" class="form-control @error('from') is-invalid @enderror" id="from"
                                name="from" value="{{ old('from') }}" required autocomplete="from" autofocus>

                            @error('from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- เรื่อง -->
                        <div class="col-md-12">
                            <label for="topic" class="col-form-label"><strong>เรื่อง</strong></label>
                            <input type="text" class="form-control @error('topic') is-invalid @enderror" id="topic"
                                name="topic" value="{{ old('topic') }}" required autocomplete="topic" autofocus>

                            @error('topic')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- ความเร่งด่วน -->
                        <div class="col-md-6">
                            <label for="urgency" class="col-form-label"><strong>ความเร่งด่วน</strong></label>
                            <select name="urgency" id="urgency" class="col-md-4 col-form-label form-select" required>
                                <option selected disabled hidden>เลือกความเร่งด่วน</option>
                                <option value="ไม่มี">ไม่มี</option>
                                <option value="ด่วน">ด่วน</option>
                                <option value="ด่วนมาก">ด่วนมาก</option>
                                <option value="ด่วนที่สุด">ด่วนที่สุด</option>
                            </select>
                        </div>
                        <!-- ฝ่ายอำนวยการ -->
                        <div class="col-md-6">
                            <label for="department" class="col-form-label"><strong>การปฏิบัติ</strong></label>
                            <select name="department" id="department" class="col-md-4 col-form-label form-select"
                                required>
                                <option selected disabled hidden>เลือกฝ่ายอำนวยการ</option>
                                @foreach ($depts as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- แนบไฟล์ -->
                        <div class="col-md-12">
                            <label for="file" class="col-form-label"><strong>แนบไฟล์</strong></label>
                            <input type="file" class="form-control" id="file" name="file" accept="application/pdf">
                        </div>
                        <!-- ปุ่มบันทึก -->
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@section('script')
<!-- Date Time Picker Thai -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<link href="{{ asset('bootstrap-datepicker-thai/css/datepicker.css') }}" rel="stylesheet">
<script src="{{ asset('bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
<script src="{{ asset('bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>
<script>
    $(function() {
            $("#date").datepicker({
                language: 'th-th',
                format: 'dd/mm/yyyy',
                autoclose: true
            });
        });
</script>
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