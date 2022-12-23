@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>คำสั่ง</h5>
            </div>
            <div class="ms-auto">
                <!-- ปุ่ม Home -->
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm"><i class="bi bi-house-door"></i>
                    หน้าแรก</a>
                <!-- ปุ่มเพิ่ม -->
                <a href="{{ route('command.create') }}" class="btn btn-danger btn-sm"><i class="bi bi-plus-lg"></i>
                    เพิ่ม</a>
            </div>
        </div>
        <hr class="my-2">
        <div class="table-responsive mt-1">
            <table id="myTable" class="table table-bordered table-primary table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th class="text-center">ที่</th>
                        <th class="text-center">ลงวันที่</th>
                        <th class="text-center">เรื่อง</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($commands as $command)
                    <tr>
                        <td>{{ $command->number }}</td>
                        <td>{{ datethaitext($command->date) }}</td>
                        <td class="text-start">
                            {{ Str::limit($command->topic, 100) }}
                            @if (!empty($command->file))
                            <a href="{{ route('command.download', $command->id) }}"><i
                                    class="bi bi-file-earmark-text-fill"></i></a>
                            @endif
                            @if (!empty($command->folder_id))
                            <i class="bi bi-check-circle-fill text-success"></i>
                            @endif
                        </td>
                        <td>
                            <!-- ปุ่มจัดเก็บ -->
                            <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                                data-bs-target="#folderModal{{ $command->id }}">
                                <i class="bi bi-folder"></i>
                            </button>
                            <!-- Modal จัดเก็บ -->
                            <div class="modal fade" id="folderModal{{ $command->id }}" tabindex="-1"
                                aria-labelledby="folderModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('command.folder') }}" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class=" modal-title" id="folderModalLabel">แฟ้มเอกสาร</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="command" value="{{ $command->id }}">
                                                <select class="form-select" name="folder" required>
                                                    <option value="" selected disabled hidden>เลือกแฟ้ม</option>
                                                    @foreach ($folders as $folder)
                                                    <option value="{{ $folder->id }}" {{ $command->folder_id ==
                                                        $folder->id ? 'selected' : '' }}>{{
                                                        $folder->name }}
                                                    </option>
                                                    @endforeach
                                                    @if (!empty($command->folder_id))
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
                            @if (auth()->user()->role == 1 || $command->user_id == auth()->user()->id)
                            <!-- ปุ่มแก้ไข -->
                            <a href="{{ route('command.edit', $command->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <!-- ปุ่มลบ -->
                            <a href="{{ route('command.destroy', $command->id) }}" class="btn btn-danger btn-sm"
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
    </div>
</div>
@endsection
@section('script')
<!-- DataTables -->
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.css" />
<script src="{{ asset('js/datatables.js') }}"></script>
<script>
    $(document).ready(function () {
    $('#myTable').DataTable({
        'ordering': false
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
        text: "เลขทะบียนคำสั่ง {{ Session::get('register') }}"
    })
</script>
@endif
@endsection