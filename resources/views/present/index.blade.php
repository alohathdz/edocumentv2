@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>หนังสือนำเรียน [ {{ auth()->user()->department->initial }} ]</h5>
            </div>
            <div class="ms-auto">
                <!-- ปุ่ม Home -->
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm"><i class="bi bi-house-door"></i>
                    หน้าแรก</a>
                <!-- ปุ่มค้นหา -->
                <a href="{{ route('present.search.home') }}" class="btn btn-secondary btn-sm"><i
                        class="bi bi-search"></i> ค้นหา</a>
                <!-- ปุ่มเพิ่ม -->
                <a href="{{ route('present.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i>
                    ออกที่หนังสือนำเรียน</a>
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table class="table table-bordered table-primary table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th style="width: 4%">ที่</th>
                        <th style="width: 10%">ลงวันที่</th>
                        <th>เรื่อง</th>
                        <th style="width: 12%">Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($presents as $present)
                    <tr>
                        <td>{{ $present->number }}</td>
                        <td>{{ datethaitext($present->date) }}</td>
                        <td class="text-start">{{ Str::limit($present->topic, 100) }} @if ($present->urgency != "ไม่มี") <span
                                style="color:red">({{ $present->urgency }})</span> @endif</td>
                        <td>
                            <form action="{{ route('present.destroy', $present->id) }}" method="post">
                                <!-- ดาวน์โหลด -->
                                <a href="{{ route('present.show', $present->id) }}" class="btn btn-primary btn-sm @if (empty($present->file)) btn-secondary disabled @endif" target="_blank">
                                    <i class="bi bi-download"></i>
                                </a>
                                <!-- ดูคนดาวน์โหลด -->
                                <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $present->id }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="modal fade" id="viewModal{{ $present->id }}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modaldonwload">รายชื่อผู้ดาวน์โหลด</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                @php
                                                    $i = 0;
                                                    $views = ('App\Models\PresentUser')::select('name', 'present_user.created_at')->join('users', 'present_user.user_id', '=', 'users.id')->where('present_id', $present->id)->get();
                                                @endphp
                                                @if (!$views->first())
                                                ยังไม่มีผู้ดาวน์โหลด
                                                @else
                                                <table class="table">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>ลำดับ</th>
                                                            <th>ชื่อผู้ดาวน์โหลด</th>
                                                            <th>เวลาดาวน์โหลด</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($views as $user)
                                                        <tr class="text-center">
                                                            <td>{{ ++$i }}</td>
                                                            <td>{{ $user->name }}</td>
                                                            <td>{{ timestampthaitext($user->created_at) }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <!-- ปุ่มปิด -->
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-bs-dismiss="modal">ปิด</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('present.edit', $present->id) }}" class="btn btn-warning btn-sm"><i
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
            {{ $presents->links() }}
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
        text: "เลขทะบียนส่ง {{ Session::get('register') }}"
    })
</script>
@endif
@endsection