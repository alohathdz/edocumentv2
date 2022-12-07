@extends('layouts.app')

@section('content')
<div class="container col-md-6">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>ข้อมูลหนังสือรับ</h5>
            </div>
        </div>
        <!-- Form -->
        <div class="card mt-1">
            <div class="card-body">
                <!-- เลขทะเบียน -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">เลขทะบียนรับ</strong>
                    <div class="col-md-9">
                        <p class="text-danger">{{ $receive->number }}</p>
                    </div>
                </div>
                <!-- วันที่หนังสือ -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">ลง</strong>
                    <div class="col-md-9">
                        <p class="text-primary">{{ datethaitext($receive->date) }}</p>
                    </div>
                </div>
                <!-- จาก -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">จาก</strong>
                    <div class="col-md-9">
                        <p class="text-primary">{{ $receive->from }}</p>
                    </div>
                </div>
                <!-- ถึง -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">ถึง</strong>
                    <div class="col-md-9">
                        <p class="text-primary">{{ $receive->to }}</p>
                    </div>
                </div>
                <!-- เรื่อง -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">เรื่อง</strong>
                    <div class="col-md-9">
                        <p class="text-primary">{{ $receive->topic }}</p>
                    </div>
                </div>
                <!-- ความเร่งด่วน -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">ความเร่งด่วน</strong>
                    <div class="col-md-9">
                        <p class="text-primary">{{ $receive->urgency }}</p>
                    </div>
                </div>
                <!-- แนบไฟล์ -->
                <div class="row">
                    <label for="file" class="col-md-3 col-form-label text-md-end"><strong>แนบไฟล์</strong></label>
                    <div class="col-md-7">
                        <p class="text-primary">{{ $receive->urgency }}</p>
                    </div>
                </div>
                <!-- ปุ่มบันทึก -->
                <div class="row mt-2">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>
                </div>
            </div>
        </div>
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