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
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm"><i class="bi bi-house-door"></i>
                    หน้าแรก</a>
                <!-- ปุ่มค้นหา -->
                <a href="{{ route('certificate.search.home') }}" class="btn btn-secondary btn-sm"><i
                        class="bi bi-search"></i> ค้นหา</a>
                <!-- ปุ่มเพิ่ม -->
                <a href="{{ route('certificate.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i>
                    ออกที่หนังสือรับรอง</a>
            </div>
        </div>
        <hr class="my-2">
        <div class="table-responsive mt-1">
            <table class="table table-bordered table-primary table-hover text-center align-middle" id="myTable">
                <thead>
                    <tr>
                        <th class="text-center">เลขทะเบียน</th>
                        <th class="text-center">ลงวันที่</th>
                        <th class="text-center">ประเภท</th>
                        <th class="text-center">ผู้ขอรับรอง</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($certificates as $certificate)
                    <tr>
                        <td>{{ $certificate->number }}</td>
                        <td>{{ datethaitext($certificate->date) }}</td>
                        <td>{{ $certificate->certificateType->name }}</td>
                        <td>
                            {{ $certificate->name }}
                            @if (!empty($certificate->folder_id))
                            <i class="bi bi-check-circle-fill text-success"></i>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('certificate.destroy', $certificate->id) }}" method="post">
                                <a href="{{ route('certificate.show', $certificate->id) }}"
                                    class="btn btn-primary btn-sm"><i class="bi bi-eye"></i></a>

                                @if (auth()->user()->role == 1 || $certificate->user_id == auth()->user()->id)
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit"
                                    onclick="return confirm('ยืนยันการลบข้อมูล!')"><i class="bi bi-trash"></i></button>
                                @endif
                            </form>
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
        text: "เลขทะบียนรับรอง {{ Session::get('register') }}"
    })
</script>
@endif
@endsection