@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>หนังสือรับรอง</h5>
            </div>
            <div class="ms-auto">
                <!-- ปุ่ม Home -->
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm"><i class="bi bi-house-door"></i> หน้าแรก</a>
                <!-- ปุ่มค้นหา -->
                <a href="{{ route('certificate.search.home') }}" class="btn btn-secondary btn-sm"><i
                        class="bi bi-search"></i> ค้นหา</a>
                <!-- ปุ่มเพิ่ม -->
                <a href="{{ route('certificate.create') }}" class="btn btn-primary btn-sm"><i
                        class="bi bi-plus-lg"></i> ออกที่หนังสือรับรอง</a>
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table class="table table-bordered table-primary table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>เลขทะเบียน</th>
                        <th>ลงวันที่</th>
                        <th>ประเภท</th>
                        <th>ผู้ขอรับรอง</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($certificates as $certificate)
                    <tr>
                        <td>{{ $certificate->number }}</td>
                        <td>{{ datethaitext($certificate->date) }}</td>
                        <td>{{ $certificate->certificateType->name }}</td>
                        <td>{{ $certificate->name }}</td>
                        <td>
                            <form action="{{ route('certificate.destroy', $certificate->id) }}" method="post">
                                <a href="{{ route('certificate.show', $certificate->id) }}"
                                    class="btn btn-primary btn-sm @if (empty($certificate->file)) btn-secondary disabled @endif"
                                    target="_blank"><i class="bi bi-download"></i></a>
                                <a href="{{ route('certificate.edit', $certificate->id) }}"
                                    class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>

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
            {{ $certificates->links() }}
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
        text: "เลขทะบียนรับรอง {{ Session::get('register') }}"
    })
</script>
@endif
@endsection