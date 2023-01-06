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
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-house-door"></i>
                    หน้าแรก
                </a>
                <!-- ปุ่มเพิ่ม -->
                <a href="{{ route('present.create') }}" class="btn btn-danger btn-sm">
                    <i class="bi bi-plus-lg"></i>
                    เพิ่ม
                </a>
                <!-- ปุ่มค้นหา -->
                @saraban
                <a href="{{ route('present.search.home') }}" class="btn btn-info btn-sm">
                    <i class="bi bi-search"></i>
                    ค้นหา
                </a>
                @endsaraban
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table class="table table-bordered table-primary table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>ที่</th>
                        <th>ลงวันที่</th>
                        <th>เรื่อง</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($presents as $present)
                    <tr>
                        <td>{{ $present->number }}</td>
                        <td>{{ datethaitext($present->date) }}</td>
                        <td class="text-start">
                            {{ Str::limit($present->topic, 100) }}
                            @if ($present->urgency != "ไม่มี")
                            <span style="color:red">({{ $present->urgency }})</span>
                            @endif
                            @if (!empty($present->file))
                            <a href="{{ route('present.download', $present->id) }}" target="_blank">
                                <i class="bi bi-file-earmark-text-fill"></i>
                            </a>
                            @endif
                            @if (!empty($present->folder_id))
                            <i class="bi bi-check-circle-fill text-success"></i>
                            @endif
                        </td>
                        <td>
                            <!-- ปุ่มดูคนดาวน์โหลด -->
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#viewModal{{ $present->id }}">
                                <i class="bi bi-eye"></i>
                            </button>
                            <!-- Modal เช็คคนดาวน์โหลด -->
                            <div class="modal fade" id="viewModal{{ $present->id }}" tabindex="-1"
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
                                            $views = ('App\Models\PresentUser')::select('name',
                                            'present_user.created_at')
                                            ->join('users', 'present_user.user_id', '=', 'users.id')
                                            ->where('present_id', $present->id)->get();
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
                                data-bs-target="#folderModal{{ $present->id }}">
                                <i class="bi bi-folder"></i>
                            </button>
                            <!-- Modal จัดเก็บ -->
                            <div class="modal fade" id="folderModal{{ $present->id }}" tabindex="-1"
                                aria-labelledby="folderModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('present.folder') }}" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class=" modal-title" id="folderModalLabel">แฟ้มเอกสาร</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="present" value="{{ $present->id }}">
                                                <select class="form-select" name="folder" required>
                                                    <option value="" selected disabled hidden>เลือกแฟ้ม</option>
                                                    @foreach ($folders as $folder)
                                                    <option value="{{ $folder->id }}" {{ $present->folder_id ==
                                                        $folder->id ? 'selected' : '' }}>{{
                                                        $folder->name }}
                                                    </option>
                                                    @endforeach
                                                    @if (!empty($present->folder_id))
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
                            @if (auth()->user()->role == 1 || $present->user_id == auth()->user()->id)
                            <!-- ปุ่มแก้ไข -->
                            <a href="{{ route('present.edit', $present->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <!-- ปุ่มลบ -->
                            <a href="{{ route('present.destroy', $present->id) }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('ยืนยันการลบข้อมูล');">
                                <i class="bi bi-trash"></i>
                            </a>
                            @endif
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