@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>รายชื่อผู้เข้าดู หนังสือ {{ $receive->from . ' ที่ ' . $receive->no . ' ลง ' . datethaitext($receive->date) }}</h5>
            </div>
            <div class="ms-auto">
                <!-- ปุ่ม Home -->
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm"><i class="bi bi-house-door"></i></a>
                <!-- ปุ่มย้อนกลับ -->
                <button class="btn btn-secondary btn-sm" onclick="history.back()">Back</button>
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table class="table table-bordered table-primary table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อ - สกุล</th>
                        <th>เวลา</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($views as $view)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $view->name }}</td>
                        <td>{{ timestampthaitext($view->created_at) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
<!-- Alert -->
@if (session('success'))
<script>
    Swal.fire({
        icon: "success",
        title: "{{ Session::get('success') }}",
    });
</script>
@elseif (session('register'))
<script>
    Swal.fire({
        icon: "success",
        title: "รับหนังสือสำเร็จ",
        text: "เลขทะบียนรับ {{ Session::get('number') }} วันที่ {{ Session::get('date') }} เวลา {{ Session::get('time') }}"
    })
</script>
@endif
@endsection