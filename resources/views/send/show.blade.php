@extends('layouts.app')

@section('content')
<div class="container col-md-6">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>ข้อมูลหนังสือส่ง</h5>
            </div>
        </div>
        <!-- Form -->
        <div class="card mt-1">
            <div class="card-body">
                <!-- เลขทะเบียน -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">เลขทะบียนส่ง</strong>
                    <div class="col-md-9">
                        <p class="text-danger">{{ $send->number }}</p>
                    </div>
                </div>
                <!-- วันที่รับ -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">วันที่ส่ง</strong>
                    <div class="col-md-9">
                        <p class="text-danger">{{ timestampthaitext($send->created_at) }}</p>
                    </div>
                </div>
                <!-- ผู้ลงทะเบียนรับ -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">ผู้ลงทะเบียนส่ง</strong>
                    <div class="col-md-9">
                        <p class="text-danger">{{ $send->user->name }}</p>
                    </div>
                </div>
                <!-- หนังสือ -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">ที่หนังสือ</strong>
                    <div class="col-md-9">
                        <p class="text-primary">{{ $send->no }}</p>
                    </div>
                </div>
                <!-- วันที่หนังสือ -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">ลง</strong>
                    <div class="col-md-9">
                        <p class="text-primary">{{ datethaitext($send->date) }}</p>
                    </div>
                </div>
                <!-- จาก -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">ถึง</strong>
                    <div class="col-md-9">
                        <p class="text-primary">{{ $send->to }}</p>
                    </div>
                </div>
                <!-- เรื่อง -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">เรื่อง</strong>
                    <div class="col-md-9">
                        <p class="text-primary">{{ $send->topic }}</p>
                    </div>
                </div>
                <!-- ความเร่งด่วน -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">ความเร่งด่วน</strong>
                    <div class="col-md-9">
                        <p class="text-primary">{{ $send->urgency }}</p>
                    </div>
                </div>
                <!-- แนบไฟล์ -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">ไฟล์</strong>
                    <div class="col-md-9">
                        <p class="text-success">
                            @if ($send->file)
                            <a href="{{ route('send.download', $send->id) }}"
                                class="btn btn-dark btn-sm @if (empty($send->file)) btn-secondary disabled @endif"
                                target="_blank"><i class="bi bi-download"></i></a> {{ substr($send->file, 10) }}
                            @else
                            ไม่มีไฟล์แนบ
                            @endif
                        </p>
                    </div>
                </div>
                <!-- ปุ่ม -->
                <div class="row mt-2">
                    <div class="col-md-12 text-center">
                        <form action="{{ route('send.destroy', $send->id) }}" method="post">
                            <!-- ปุ่มแก้ไข -->
                            <a href="{{ route('send.edit', $send->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> แก้ไข
                            </a>

                            @csrf
                            @method('DELETE')
                            <!-- ปุ่มลบ -->
                            <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('ยืนยันการลบข้อมูล!')">
                                <i class="bi bi-trash"></i> ลบ
                            </button>
                            <!-- ปุ่มย้อนกลับ -->
                            @if (session('success'))
                            <a href="{{ route('send.index') }}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-backspace"></i> ย้อนกลับ
                            </a>
                            @else
                            <button type="button" class="btn btn-secondary btn-sm" onclick="history.back()">
                                <i class="bi bi-backspace"></i> ย้อนกลับ
                            </button>
                            @endif
                        </form>
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
});
</script>
@endif
@endsection