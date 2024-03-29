@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>สำเนาหนังสือ</h5>
            </div>
            <div class="ms-auto">
                <!-- ปุ่ม Home -->
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-house-door"></i> หน้าแรก
                </a>
                <!-- ปุ่มสำเนาคำสั่ง -->
                <a href="{{ route('copy.command') }}" class="btn btn-danger btn-sm">
                    <i class="bi bi-book"></i> สำเนาคำสั่ง
                </a>
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table class="table table-primary table-bordered table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>จาก</th>
                        <th>สำเนาเมื่อ</th>
                        <th>เรื่อง</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($presents as $present)
                    <tr>
                        <td>{{ $present->dept }}</td>
                        <td>{{ timestampthaitext($present->created_at) }}</td>
                        <td class="text-start">{{ $present->topic }}</td>
                        <td>
                            <!-- ปุ่มดาวน์โหลด -->
                            <a href="{{ route('present.download', $present->present_id) }}"
                                class="btn btn-primary btn-sm" target="_blank">
                                <i class="bi bi-download"></i>
                            </a>
                            <!-- ปุ่มดูคนดาวน์โหลด -->
                            <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                                data-bs-target="#viewModal{{ $present->present_id }}">
                                <i class="bi bi-eye"></i>
                            </button>
                            <!-- Modal เช็คคนดาวน์โหลด -->
                            <div class="modal fade" id="viewModal{{ $present->present_id }}" tabindex="-1"
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
                                            ->where('present_id', $present->present_id)->get();
                                            $i = 0;
                                            @endphp
                                            @if (!$views->first())
                                            ยังไม่มีผู้ดาวน์โหลด
                                            @else
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>ลำดับ</th>
                                                        <th>ชื่อผู้ดาวน์โหลด</th>
                                                        <th>เวลาดาวน์โหลด</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($views as $user)
                                                    <tr>
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