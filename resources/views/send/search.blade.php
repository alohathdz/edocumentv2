@extends('layouts.app')

@section('content')
<div class="container col-md-5">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>ค้นหาหนังสือส่ง</h5>
            </div>
        </div>
        <!-- Form -->
        <form action="{{ route('send.search') }}" method="post">
            @csrf
            <div class="card mt-1">
                <div class="card-body">
                    <div class="row g-2">
                        <!-- ที่หนังสือ -->
                        <div class="col-md-4">
                            <label for="no" class="col-form-label"><strong>ที่</strong></label>
                            <input type="text" class="form-control" id="no" name="no">
                        </div>
                        <!-- วันที่หนังสือ -->
                        <div class="col-md-4">
                            <label for="date" class="col-form-label"><strong>ลง</strong></label>
                            <input type="text" class="form-control" id="date" name="date" readonly>
                        </div>
                        <!-- จาก -->
                        <div class="col-md-4">
                            <label for="to" class="col-form-label"><strong>จาก</strong></label>
                            <input type="text" class="form-control" id="to" name="to">
                        </div>
                        <!-- เรื่อง -->
                        <div class="col-md-12">
                            <label for="topic" class="col-form-label"><strong>เรื่อง</strong></label>
                            <input type="text" class="form-control" id="topic" name="topic">
                        </div>
                        <!-- ปุ่มบันทึก -->
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary btn-sm">ค้นหา</button>
                            <a href="{{ route('send.index') }}" class="btn btn-danger btn-sm">ยกเลิก</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@if (isset($sends))
<div class="container mt-3">
    <div class="table-responsive mt-1">
        <table class="table table-bordered table-primary table-hover text-center align-middle">
            <thead>
                <tr>
                    <th>ที่</th>
                    <th>ลงวันที่</th>
                    <th>จาก</th>
                    <th>เรื่อง</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($sends as $send)
                <tr>
                    <td>{{ $send->number }}</td>
                    <td>{{ datethaitext($send->date) }}</td>
                    <td class="text-start">{{ $send->to }}</td>
                    <td class="text-start">
                        {{ Str::limit($send->topic, 100) }}
                        @if ($send->urgency != "ไม่มี")
                        <span style="color:red">({{ $send->urgency }})</span>
                        @endif
                        @if (!empty($send->file))
                        <a href="{{ route('send.download', $send->id) }}" target="_blank">
                            <i class="bi bi-file-earmark-text-fill"></i>
                        </a>
                        @endif
                        @if (!empty($send->folder_id))
                        <i class="bi bi-check-circle-fill text-success"></i>
                        @endif
                    </td>
                    <td>
                        <!-- ปุ่มจัดเก็บ -->
                        <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                            data-bs-target="#folderModal{{ $send->id }}">
                            <i class="bi bi-folder"></i>
                        </button>
                        <!-- Modal จัดเก็บ -->
                        <div class="modal fade" id="folderModal{{ $send->id }}" tabindex="-1"
                            aria-labelledby="folderModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('send.folder') }}" method="post">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class=" modal-title" id="folderModalLabel">แฟ้มเอกสาร</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="send" value="{{ $send->id }}">
                                            <select class="form-select" name="folder" required>
                                                <option value="" selected disabled hidden>เลือกแฟ้ม</option>
                                                @foreach ($folders as $folder)
                                                <option value="{{ $folder->id }}" {{ $send->folder_id ==
                                                    $folder->id ? 'selected' : '' }}>{{
                                                    $folder->name }}
                                                </option>
                                                @endforeach
                                                @if (!empty($send->folder_id))
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
                        @if (auth()->user()->role == 1 || $send->user_id == auth()->user()->id)
                        <!-- ปุ่มแก้ไข -->
                        <a href="{{ route('send.edit', $send->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <!-- ปุ่มลบ -->
                        <a href="{{ route('send.destroy', $send->id) }}" class="btn btn-danger btn-sm"
                            onclick="return confirm('ยืนยันการลบข้อมูล');">
                            <i class="bi bi-trash"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $sends->links() }}
    </div>
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