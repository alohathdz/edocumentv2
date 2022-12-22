@extends('layouts.app')

@section('content')
<div class="container col-md-3">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>ออกที่หนังสือส่ง</h5>
            </div>
        </div>
        <!-- Form -->
        <form action="{{ route('send.store') }}" method="post">
            @csrf
            <div class="card mt-1">
                <div class="card-body">
                    <div class="row g-2">
                        <!-- วันที่หนังสือ -->
                        <div class="col-md-6">
                            <label for="date" class="col-form-label"><strong>ลง</strong></label>
                            <input type="text" class="form-control @error('date') is-invalid @enderror" id="date"
                                name="date" value="{{ old('date') }}" placeholder="วัน/เดือน/ปี" required readonly>

                            @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- จาก -->
                        <div class="col-md-6">
                            <label for="to" class="col-form-label"><strong>ถึง</strong></label>
                            <input type="text" class="form-control @error('to') is-invalid @enderror" id="to" name="to"
                                value="{{ old('to') }}" required autocomplete="to" autofocus>

                            @error('to')
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
                        <div class="col-md-12">
                            <label for="urgency" class="col-form-label"><strong>ความเร่งด่วน</strong></label>
                            <select name="urgency" id="urgency" class="col-md-4 col-form-label form-select" required>
                                <option selected disabled hidden>เลือกความเร่งด่วน</option>
                                <option value="ไม่มี">ไม่มี</option>
                                <option value="ด่วน">ด่วน</option>
                                <option value="ด่วนมาก">ด่วนมาก</option>
                                <option value="ด่วนที่สุด">ด่วนที่สุด</option>
                            </select>
                        </div>
                        <!-- ปุ่มบันทึก -->
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary btn-sm" onclick="classList.add('disabled')">บันทึก</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="history.back()">ยกเลิก</button>
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
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
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
});
</script>
@endif
@endsection