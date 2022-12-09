@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>คำสั่ง</h5>
            </div>
            <div class="ms-auto">
                <!-- ปุ่ม Home -->
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm"><i class="bi bi-house-door"></i> หน้าแรก</a>
                <!-- ปุ่มค้นหา -->
                <a href="{{ route('command.search.home') }}" class="btn btn-secondary btn-sm"><i
                        class="bi bi-search"></i> ค้นหา</a>
                <!-- ปุ่มเพิ่ม -->
                <a href="{{ route('command.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> ออกที่คำสั่ง</a>
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table class="table table-bordered table-primary table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th style="width: 8%">เลขทะเบียน</th>
                        <th style="width: 10%">ลงวันที่</th>
                        <th>เรื่อง</th>
                        <th style="width: 10%">Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($commands as $command)
                    <tr>
                        <td>{{ $command->number }}</td>
                        <td>{{ datethaitext($command->date) }}</td>
                        <td>{{ Str::limit($command->topic, 100) }}</td>
                        <td>
                            <form action="{{ route('command.destroy', $command->id) }}" method="post">
                                <a href="{{ route('command.show', $command->id) }}"
                                    class="btn btn-primary btn-sm @if (empty($command->file)) btn-secondary disabled @endif"
                                    target="_blank"><i class="bi bi-download"></i></a>
                                <a href="{{ route('command.edit', $command->id) }}" class="btn btn-warning btn-sm"><i
                                        class="bi bi-pencil-square"></i></a>

                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit"
                                    onclick="return confirm('ยืนยันการลบข้อมูล!')"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
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
        title: "ทำรายการสำเร็จ",
        text: "เลขทะบียนคำสั่ง {{ Session::get('register') }}"
    })
</script>
@endif
@endsection