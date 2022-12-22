@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>หนังสือส่ง</h5>
            </div>
            <div class="ms-auto">
                <!-- ปุ่ม Home -->
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm"><i class="bi bi-house-door"></i>
                    หน้าแรก</a>
                <!-- ปุ่มค้นหา -->
                <a href="{{ route('send.search.home') }}" class="btn btn-secondary btn-sm"><i class="bi bi-search"></i>
                    ค้นหา</a>
                <!-- ปุ่มเพิ่ม -->
                <a href="{{ route('send.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i>
                    ออกที่หนังสือส่ง</a>
            </div>
        </div>
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
                            @if (!empty($send->folder_id))
                            <i class="bi bi-check-circle-fill text-success"></i>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('send.destroy', $send->id) }}" method="post">
                                <a href="{{ route('send.show', $send->id) }}" class="btn btn-primary btn-sm"><i
                                        class="bi bi-eye"></i></a>

                                @if (auth()->user()->role == 1 || $send->user_id == auth()->user()->id)
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
            {{ $sends->links() }}
        </div>
    </div>
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