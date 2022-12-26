@extends('layouts.app')

@section('content')
<div class="container col-md-5">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>ค้นหาหนังสือรับ</h5>
            </div>
        </div>
        <!-- Form -->
        <form action="{{ route('receive.search') }}" method="post">
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
                            <label for="from" class="col-form-label"><strong>จาก</strong></label>
                            <input type="text" class="form-control" id="from" name="from">
                        </div>
                        <!-- เรื่อง -->
                        <div class="col-md-12">
                            <label for="topic" class="col-form-label"><strong>เรื่อง</strong></label>
                            <input type="text" class="form-control" id="topic" name="topic">
                        </div>
                        <!-- ปุ่มบันทึก -->
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary btn-sm">ค้นหา</button>
                            <a href="{{ route('receive.index') }}" class="btn btn-danger btn-sm">ยกเลิก</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="container mt-3">
    @if (isset($receives))
    <div class="table-responsive mt-1">
        <table class="table table-bordered table-primary table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>ที่</th>
                    <th>วันที่รับ</th>
                    <th>จาก</th>
                    <th>เรื่อง</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($receives as $receive)
                <tr>
                    <td>{{ $receive->number }}</td>
                    <td>{{ timestampthaitext($receive->created_at) }}</td>
                    <td class="text-start">{{ $receive->from }}</td>
                    <td class="text-start">
                        {{ Str::limit($receive->topic, 100) }}
                        @if ($receive->urgency != "ไม่มี")
                        <span style="color:red">({{ $receive->urgency }})</span>
                        @endif
                        @if (!empty($receive->file))
                        <a href="{{ route('receive.download', $receive->id) }}" target="_blank">
                            <i class="bi bi-file-earmark-text-fill"></i>
                        </a>
                        @endif
                        @if (!empty($receive->folder_id))
                        <i class="bi bi-check-circle-fill text-success"></i>
                        @endif
                    </td>
                    <td>
                        <!-- ปุ่มดูคนดาวน์โหลด -->
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#viewModal{{ $receive->id }}">
                            <i class="bi bi-eye"></i>
                        </button>
                        <!-- Modal เช็คคนดาวน์โหลด -->
                        <div class="modal fade" id="viewModal{{ $receive->id }}" tabindex="-1"
                            aria-labelledby="viewModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modaldonwload">รายชื่อผู้ดาวน์โหลด</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        @php
                                        $views = ('App\Models\ReceiveUser')::select('name',
                                        'receive_user.created_at')
                                        ->join('users', 'receive_user.user_id', '=', 'users.id')
                                        ->where('receive_id', $receive->id)->get();
                                        $i = 0;
                                        @endphp
                                        @if (!$views->first())
                                        ยังไม่มีผู้ดาวน์โหลด
                                        @else
                                        <table class="table">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">ชื่อผู้ดาวน์โหลด</th>
                                                    <th class="text-center">เวลาดาวน์โหลด</th>
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
                        <!-- ปุ่มจัดเก็บ -->
                        <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                            data-bs-target="#folderModal{{ $receive->id }}">
                            <i class="bi bi-folder"></i>
                        </button>
                        <!-- Modal จัดเก็บ -->
                        <div class="modal fade" id="folderModal{{ $receive->id }}" tabindex="-1"
                            aria-labelledby="folderModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('receive.folder') }}" method="post">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class=" modal-title" id="folderModalLabel">แฟ้มเอกสาร</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="receive" value="{{ $receive->id }}">
                                            <select class="form-select" name="folder" required>
                                                <option value="" selected disabled hidden>เลือกแฟ้ม</option>
                                                @foreach ($folders as $folder)
                                                <option value="{{ $folder->id }}" {{ $receive->folder_id ==
                                                    $folder->id ? 'selected' : '' }}>{{
                                                    $folder->name }}
                                                </option>
                                                @endforeach
                                                @if (!empty($receive->folder_id))
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

                        @if (auth()->user()->role == 1 || $receive->user_id == auth()->user()->id)
                        <!-- ปุ่มแก้ไข -->
                        <a href="{{ route('receive.edit', $receive->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <!-- ปุ่มลบ -->
                        <a href="{{ route('receive.destroy', $receive->id) }}" class="btn btn-danger btn-sm"
                            onclick="return confirm('ยืนยันการลบข้อมูล');">
                            <i class="bi bi-trash"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $receives->links() }}
    </div>
    @endif
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
@if (session('fail'))
<script>
    Swal.fire({
    icon: "error",
    title: "{{ Session::get('fail') }}",
});
</script>
@endif
@endsection