@extends('layouts.app')

@section('content')
<div class="container col-md-5">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>ค้นหาหนังสือรับรอง</h5>
            </div>
        </div>
        <!-- Form -->
        <form action="{{ route('certificate.search') }}" method="post">
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
                        <!-- ประเภท -->
                        <div class="col-md-12">
                            <label for="ctype" class="col-form-label"><strong>ประเภท</strong></label>
                            <select name="ctype" id="ctype" class="col-md-4 col-form-label form-select">
                                <option selected disabled hidden>เลือกประเภท</option>
                                @foreach ($certificateTypes as $certificateType)
                                <option value="{{ $certificateType->id }}">{{ $certificateType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- ผู้ขอรับรอง -->
                        <div class="col-md-12">
                            <label for="name" class="col-form-label"><strong>ผู้ขอรับรอง</strong></label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <!-- ปุ่มบันทึก -->
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary btn-sm">ค้นหา</button>
                            <a href="{{ route('certificate.index') }}" class="btn btn-danger btn-sm">ยกเลิก</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@if (isset($certificates))
<div class="container table-responsive mt-3">
    <table class="table table-bordered table-primary table-hover text-center align-middle">
        <thead>
            <tr>
                <th>เลขทะเบียน</th>
                <th>ลงวันที่</th>
                <th>การรับรอง</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($certificates as $certificate)
            <tr>
                <td>{{ $certificate->number }}</td>
                <td>{{ datethaitext($certificate->date) }}</td>
                <td class="text-start">
                    {{ $certificate->certificateType->name }}
                    {{ $certificate->name }}
                    @if (!empty($certificate->file))
                    <a href="{{ route('certificate.download', $certificate->id) }}" target="_blank">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </a>
                    @endif
                    @if (!empty($certificate->folder_id))
                    <i class="bi bi-check-circle-fill text-success"></i>
                    @endif
                </td>
                <td>
                    <!-- ปุ่มจัดเก็บ -->
                    <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                        data-bs-target="#folderModal{{ $certificate->id }}">
                        <i class="bi bi-folder"></i>
                    </button>
                    <!-- Modal จัดเก็บ -->
                    <div class="modal fade" id="folderModal{{ $certificate->id }}" tabindex="-1"
                        aria-labelledby="folderModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('certificate.folder') }}" method="post">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class=" modal-title" id="folderModalLabel">แฟ้มเอกสาร</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="certificate" value="{{ $certificate->id }}">
                                        <select class="form-select" name="folder" required>
                                            <option value="" selected disabled hidden>เลือกแฟ้ม</option>
                                            @foreach ($folders as $folder)
                                            <option value="{{ $folder->id }}" {{ $certificate->folder_id ==
                                                $folder->id ? 'selected' : '' }}>{{
                                                $folder->name }}
                                            </option>
                                            @endforeach
                                            @if (!empty($certificate->folder_id))
                                            <option value="">นำออกจากแฟ้ม</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">บันทึก</button>
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            data-bs-dismiss="modal">ปิด</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if (auth()->user()->role == 1 || $certificate->user_id == auth()->user()->id)
                    <!-- ปุ่มแก้ไข -->
                    <a href="{{ route('certificate.edit', $certificate->id) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <!-- ปุ่มลบ -->
                    <a href="{{ route('certificate.destroy', $certificate->id) }}" class="btn btn-danger btn-sm"
                        onclick="return confirm('ยืนยันการลบข้อมูล');">
                        <i class="bi bi-trash"></i>
                    </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
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
@if (session('fail'))
<script>
    Swal.fire({
    icon: "error",
    title: "{{ Session::get('fail') }}",
});
</script>
@endif
@endsection