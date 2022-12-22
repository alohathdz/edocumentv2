@extends('layouts.app')

@section('content')
<div class="container col-md-6">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>แนบไฟล์หนังสือนำเรียน</h5>
            </div>
        </div>
        <!-- Form -->
        <form action="{{ route('present.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card mt-1">
                <div class="card-body">
                    <input type="hidden" name="id" value="{{ $present->id }}">
                    <!-- เลขทะเบียน -->
                    <div class="row">
                        <strong class="col-md-3 text-md-end">เลขทะบียนนำเรียน</strong>
                        <div class="col-md-9">
                            <p class="text-danger">{{ $present->number }}</p>
                        </div>
                    </div>
                    <!-- วันที่หนังสือ -->
                    <div class="row">
                        <strong class="col-md-3 text-md-end">ลง</strong>
                        <div class="col-md-9">
                            <p class="text-primary">{{ datethai($present->date) }}</p>
                        </div>
                    </div>
                    <!-- เรื่อง -->
                    <div class="row">
                        <strong class="col-md-3 text-md-end">เรื่อง</strong>
                        <div class="col-md-9">
                            <p class="text-primary">{{ $present->topic }}</p>
                        </div>
                    </div>
                    <!-- ความเร่งด่วน -->
                    <div class="row">
                        <strong class="col-md-3 text-md-end">ความเร่งด่วน</strong>
                        <div class="col-md-9">
                            <p class="text-primary">{{ $present->urgency }}</p>
                        </div>
                    </div>
                    <!-- แนบไฟล์ -->
                    <div class="row">
                        <label for="file" class="col-md-3 col-form-label text-md-end"><strong>แนบไฟล์</strong></label>
                        <div class="col-md-7">
                            <input type="file" class="form-control" id="file" name="file" accept="application/pdf">
                        </div>
                    </div>
                    <!-- สำเนา -->
                    @saraban
                    <hr class="my-3">
                    <div class="row">
                        <label for="file" class="col-md-3 col-form-label text-md-end"><strong>สำเนาให้</strong></label>
                        <div class="col-md-7">
                            @foreach ($departments as $dept)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" value="{{ $dept->id }}" name="copy[]"
                                    id="deptCheck{{ $dept->id }}">
                                <label for="deptCheck{{ $dept->id }}" class="form-check-label">{{ $dept->name
                                    }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endsaraban
                    <!-- ปุ่มบันทึก -->
                    <div class="row mt-2">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary btn-sm" onclick="classList.add('disabled')">บันทึก</button>
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