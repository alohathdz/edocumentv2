@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>หนังสือที่ลงทะเบียนรับ</h5>
            </div>
            <div class="ms-auto">
                <!-- ปุ่ม Home -->
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm"><i class="bi bi-house-door"></i> หน้าแรก</a>
                <!-- ปุ่ม index -->
                <a href="{{ route('receive.index') }}" class="btn btn-warning btn-sm"><i
                        class="bi bi-file-text"></i> หนังสือรับในฝ่ายอำนวยการ</a>
                <!-- ปุ่มค้นหา -->
                <a href="{{ route('receive.search.home') }}" class="btn btn-secondary btn-sm"><i
                        class="bi bi-search"></i> ค้นหา</a>
                <!-- ปุ่มเพิ่ม -->
                <a href="{{ route('receive.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> รับหนังสือ</a>
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table class="table table-bordered table-primary table-hover align-middle">
                <thead class="text-center">
                    <tr>
                        <th style="width: 4%">ที่</th>
                        <th style="width: 10%">วันที่รับ</th>
                        <th>จาก</th>
                        <th>เรื่อง</th>
                        <th style="width: 7%">ฝ่าย</th>
                        <th style="width: 15%">Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($receives as $receive)
                    <tr>
                        <td class="text-center">{{ $receive->number }}</td>
                        <td class="text-center">{{ timestampthaitext($receive->created_at) }}</td>
                        <td>{{ $receive->from }}</td>
                        <td>{{ Str::limit($receive->topic, 100) }} @if ($receive->urgency != "ไม่มี") <span
                                style="color:red">({{ $receive->urgency }})</span> @endif</td>
                        <td class="text-center">{{ $receive->department->initial }}</td>
                        <td class="text-center">
                            <form action="{{ route('receive.destroy', $receive->id) }}" method="post">
                                <!-- ปุ่มดูไฟล์แนบ -->
                                @if ($receive->file)
                                <a href="{{ route('receive.show', $receive->id) }}"
                                    class="btn btn-primary btn-sm @if (empty($receive->file)) btn-secondary disabled @endif"
                                    target="_blank"><i class="bi bi-download"></i></a>
                                <!-- ปุ่มตรวจคนดูไฟล์แนบ -->
                                <a href="{{ route('receive.view', $receive->id) }}" class="btn btn-success btn-sm"><i
                                        class="bi bi-eye"></i></a>
                                @endif
                                <!-- ปุ่มแก้ไข -->
                                <a href="{{ route('receive.edit', $receive->id) }}" class="btn btn-warning btn-sm"><i
                                        class="bi bi-pencil-square"></i></a>

                                @csrf
                                @method('DELETE')
                                <!-- ปุ่มลบ -->
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
        showConfirmButton: false,
        timer: 1500
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