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
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-house-door"></i>
                    หน้าแรก
                </a>
                <!-- ปุ่มเพิ่ม -->
                <a href="{{ route('certificate.create') }}" class="btn btn-danger btn-sm">
                    <i class="bi bi-plus-lg"></i>
                    เพิ่ม
                </a>
                <!-- ปุ่มค้นหา -->
                <a href="{{ route('certificate.search.home') }}" class="btn btn-info btn-sm">
                    <i class="bi bi-search"></i>
                    เพิ่ม
                </a>
            </div>
        </div>
        <div class="table-responsive mt-1">
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
            {{ $certificates->links() }}
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
        text: "เลขทะบียนรับรอง {{ Session::get('register') }}"
    })
</script>
@endif
@endsection