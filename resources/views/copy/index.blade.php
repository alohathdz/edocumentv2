@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>สำเนา</h5>
            </div>
            <div class="ms-auto">
                <!-- ปุ่ม Home -->
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm"><i class="bi bi-house-door"></i>
                    หน้าแรก</a>
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table class="table table-primary table-bordered table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>ที่</th>
                        <th>สำเนาเมื่อ</th>
                        <th>เรื่อง</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($copys as $copy)
                    <tr>
                        <td>{{ $copy->no }}</td>
                        <td>{{ timestampthaitext($copy->created_at) }}</td>
                        <td>{{ $copy->topic }}</td>
                        <td>
                            <a href="#"
                                class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $copys->links() }}
        </div>
    </div>
</div>
@endsection