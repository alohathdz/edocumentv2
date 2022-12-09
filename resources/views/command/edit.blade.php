@extends('layouts.app')

@section('content')
<div class="container col-md-3">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>แก้ไขข้อมูลคำสั่ง</h5>
            </div>
        </div>
        <!-- Card -->
        <div class="card mt-1">
            <div class="card-body">
                <form action="{{ route('command.update', $command->id) }}" method="post" class="row g-2" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- วันที่หนังสือ -->
                    <div class="col-md-12">
                        <label for="date" class="col-form-label"><strong>ลง</strong></label>
                        <input type="text" class="form-control @error('date') is-invalid @enderror" id="date"
                            name="date" value="{{ datethai($command->date) }}" required readonly>

                        @error('date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!-- เรื่อง -->
                    <div class="col-md-12">
                        <label for="topic" class="col-form-label"><strong>เรื่อง</strong></label>
                        <input type="text" class="form-control @error('topic') is-invalid @enderror" id="topic"
                            name="topic" value="{{ $command->topic }}" required autocomplete="topic" autofocus>

                        @error('topic')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!-- แนบไฟล์ -->
                    <div class="col-md-12">
                        <label for="file" class="col-form-label"><strong>แนบไฟล์</strong></label>
                        <input type="file" class="form-control" id="file" name="file" accept="application/pdf">
                    </div>
                    <!-- ปุ่มบันทึก -->
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary btn-sm">บันทึก</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="history.back()">ยกเลิก</button>
                    </div>
                </form>
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
});
</script>
@endif
@endsection