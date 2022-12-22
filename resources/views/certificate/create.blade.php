@extends('layouts.app')

@section('content')
<div class="container col-md-3">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>ออกที่หนังสือรับรอง</h5>
            </div>
        </div>
        <!-- Form -->
        <form action="{{ route('certificate.store') }}" method="post">
            @csrf
            <div class="card mt-1">
                <div class="card-body">
                    <div class="row g-2">
                        <!-- วันที่หนังสือ -->
                        <div class="col-md-12">
                            <label for="date" class="col-form-label"><strong>ลง</strong></label>
                            <input type="text" class="form-control @error('date') is-invalid @enderror" id="date"
                                name="date" value="{{ old('date') }}" placeholder="วัน/เดือน/ปี" required readonly>

                            @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- ประเภท -->
                        <div class="col-md-12">
                            <label for="ctype" class="col-form-label"><strong>ประเภท</strong></label>
                            <select name="ctype" id="ctype" class="col-md-4 col-form-label form-select" required>
                                <option selected disabled hidden>เลือกประเภท</option>
                                @foreach ($certificateTypes as $certificateType)
                                <option value="{{ $certificateType->id }}">{{ $certificateType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- ผู้ขอรับรอง -->
                        <div class="col-md-12">
                            <label for="name" class="col-form-label"><strong>ผู้ขอรับรอง</strong></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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
});
</script>
@endif
@endsection