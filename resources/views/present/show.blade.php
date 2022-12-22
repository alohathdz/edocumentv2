@extends('layouts.app')

@section('content')
<div class="container col-md-6">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>ข้อมูลหนังสือนำเรียน</h5>
            </div>
        </div>
        <!-- Form -->
        <div class="card mt-1">
            <div class="card-body">
                <!-- เลขทะเบียน -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">เลขทะเบียน</strong>
                    <div class="col-md-9">
                        <p class="text-danger">{{ $present->number }}</p>
                    </div>
                </div>
                <!-- วันที่รับ -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">วันที่</strong>
                    <div class="col-md-9">
                        <p class="text-danger">{{ timestampthaitext($present->created_at) }}</p>
                    </div>
                </div>
                <!-- ผู้ลงทะเบียนรับ -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">ผู้ลงทะเบียน</strong>
                    <div class="col-md-9">
                        <p class="text-danger">{{ $present->user->name }}</p>
                    </div>
                </div>
                <!-- หนังสือ -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">ที่</strong>
                    <div class="col-md-9">
                        <p class="text-primary">{{ $present->no }}</p>
                    </div>
                </div>
                <!-- วันที่หนังสือ -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">ลง</strong>
                    <div class="col-md-9">
                        <p class="text-primary">{{ datethaitext($present->date) }}</p>
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
                <!-- เจ้าหน้าที่ -->
                @if (isset($employee))
                <div class="row">
                    <strong class="col-md-3 text-md-end">เจ้าหน้าที่รับผิดชอบ</strong>
                    <div class="col-md-9">
                        <p class="text-danger">{{ $employee->user->name }}
                        </p>
                    </div>
                </div>
                @endif
                <!-- แนบไฟล์ -->
                <div class="row">
                    <strong class="col-md-3 text-md-end">ไฟล์</strong>
                    <div class="col-md-9">
                        <p class="text-success">
                            @if ($present->file)
                            <a href="{{ route('present.download', $present->id) }}"
                                class="btn btn-dark btn-sm @if (empty($present->file)) btn-secondary disabled @endif"
                                target="_blank"><i class="bi bi-download"></i></a> {{ substr($present->file, 13) }}
                            @else
                            ไม่มีไฟล์แนบ
                            @endif
                        </p>
                    </div>
                </div>
                <!-- จำนวนคนดาวน์โหลด -->
                @if ($present->file)
                <div class="row">
                    <strong class="col-md-3 text-md-end">คนดาวน์โหลด</strong>
                    <div class="col-md-9">
                        <p class="text-success">
                            <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                                data-bs-target="#viewModal">
                                <i class="bi bi-eye"></i>
                            </button> จำนวน {{ $views->count() }} คน
                        </p>
                    </div>
                </div>
                <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modaldonwload">รายชื่อผู้ดาวน์โหลด</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
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
                                            @php
                                            $i = 0;
                                            @endphp
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
                @endif
                <!-- ปุ่ม -->
                <div class="row mt-2">
                    <div class="col-md-12 text-center">
                        <form action="{{ route('present.destroy', $present->id) }}" method="post">
                            <!-- ปุ่มจัดเก็บ -->
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#folderModal">
                                <i class="bi bi-folder"></i> จัดเก็บ
                            </button>
                            <!-- ปุ่มแก้ไข -->
                            <a href="{{ route('present.edit', $present->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> แก้ไข
                            </a>

                            @csrf
                            @method('DELETE')
                            <!-- ปุ่มลบ -->
                            <button class="btn btn-danger btn-sm" type="submit"
                                onclick="return confirm('ยืนยันการลบข้อมูล!')">
                                <i class="bi bi-trash"></i> ลบ
                            </button>
                            <!-- ปุ่มย้อนกลับ -->
                            @if (session('success'))
                            <a href="{{ route('present.index') }}" class="btn btn-secondary btn-sm">
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
<!-- แฟ้ม -->
<form action="{{ route('present.folder') }}" method="post">
    <div class="modal fade" id="folderModal" tabindex="-1" aria-labelledby="folderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class=" modal-title" id="folderModalLabel">แฟ้มเอกสาร</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="present" value="{{ $present->id }}">
                    <select class="form-select" name="folder" required>
                        <option value="" selected disabled hidden>เลือกแฟ้ม</option>
                        @foreach ($folders as $folder)
                        <option value="{{ $folder->id }}" {{ ($present->folder_id == $folder->id) ? 'selected' : ''
                            }}>{{ $folder->name }}</option>
                        @endforeach
                        <option value="">นำออกจากแฟ้ม</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">บันทึก</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
</form>

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