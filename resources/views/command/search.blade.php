@extends('layouts.app')

@section('content')
<div class="container col-md-5">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>ค้นหาคำสั่ง</h5>
            </div>
        </div>
        <!-- Form -->
        <form action="{{ route('command.search') }}" method="post">
            @csrf
            <div class="card mt-1">
                <div class="card-body">
                    <div class="row g-2">
                        <!-- ที่หนังสือ -->
                        <div class="col-md-6">
                            <label for="no" class="col-form-label"><strong>ที่</strong></label>
                            <input type="text" class="form-control" id="no" name="no">
                        </div>
                        <!-- วันที่หนังสือ -->
                        <div class="col-md-6">
                            <label for="date" class="col-form-label"><strong>ลง</strong></label>
                            <input type="text" class="form-control" id="date" name="date" readonly>
                        </div>
                        <!-- เรื่อง -->
                        <div class="col-md-12">
                            <label for="topic" class="col-form-label"><strong>เรื่อง</strong></label>
                            <input type="text" class="form-control" id="topic" name="topic">
                        </div>
                        <!-- ปุ่มบันทึก -->
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary btn-sm">ค้นหา</button>
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
@if (session('fail'))
<script>
    Swal.fire({
    icon: "error",
    title: "{{ Session::get('fail') }}",
});
</script>
@endif
@endsection