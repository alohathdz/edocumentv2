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
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-house-door"></i>
                    หน้าแรก
                </a>
                <!-- ปุ่ม index -->
                @adminsaraban
                <a href="{{ route('receive.index') }}" class="btn btn-dark btn-sm">
                    <i class="bi bi-file-text"></i>
                    {{ auth()->user()->department->initial }}
                </a>
                @endadminsaraban
                <!-- ปุ่มเพิ่ม -->
                <a href="{{ route('receive.create') }}" class="btn btn-danger btn-sm">
                    <i class="bi bi-plus-lg"></i>
                    เพิ่ม
                </a>
                <!-- ปุ่มค้นหา -->
                @adminsaraban
                <a href="{{ route('receive.search.home') }}" class="btn btn-info btn-sm">
                    <i class="bi bi-search"></i>
                    ค้นหา
                </a>
                @endadminsaraban
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table class="table table-bordered table-primary table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>ที่</th>
                        <th>วันที่รับ</th>
                        <th>จาก</th>
                        <th>เรื่อง</th>
                        <th>ฝ่าย</th>
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
                            <a href="{{ route('receive.download', $receive->id) }}" target="_blank"><i
                                    class="bi bi-file-earmark-text-fill"></i></a>
                            @endif
                            @if (!empty($receive->folder_id))
                            <i class="bi bi-check-circle-fill text-success"></i>
                            @endif
                        </td>
                        <td>{{ $receive->department->initial }}</td>
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
                                            <h6 class="modal-title text-danger ms-1">(ผู้รับ {{ $receive->user->name }})</h6>
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

                            @if (auth()->user()->role == 1 || $receive->user_id == auth()->user()->id)
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
        title: "รับหนังสือสำเร็จ",
        text: "เลขทะบียนรับ {{ Session::get('number') }} วันที่ {{ Session::get('date') }} เวลา {{ Session::get('time') }}"
    })
</script>
@endif
@endsection