@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>เพิ่มข้อมูลฝ่ายอำนวยการ</h5>
            </div>
        </div>
        <!-- Form -->
        <form action="{{ route('department.store') }}" method="post">
            @csrf
            <div class="card mt-1">
                <div class="card-body">
                    <!-- ชื่อแผนก -->
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">ชื่อเต็ม</label>
                        <div class="col-md-5">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <!-- ชื่อย่อแผนก -->
                    <div class="row mb-3">
                        <label for="initial" class="col-md-4 col-form-label text-md-end">ชื่อย่อ</label>
                        <div class="col-md-5">
                            <input id="initial" type="text" class="form-control @error('initial') is-invalid @enderror"
                                name="initial" value="{{ old('initial') }}" required autocomplete="initial" autofocus>

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
                            <input id="line_token" type="text" class="form-control @error('line_token') is-invalid @enderror"
                                name="line_token" value="{{ old('line_token') }}" autocomplete="line_token" autofocus>

                            @error('line_token')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <!-- ปุ่มบันทึก -->
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary btn-sm">บันทึก</button>
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