@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex gap-2">
            <div class="me-auto">
                <h5>สำเนาคำสั่ง</h5>
            </div>
            <div class="ms-auto">
                <!-- ปุ่ม Home -->
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-house-door"></i> หน้าแรก
                </a>
                <!-- ปุ่มสำเนาหนังสือ -->
                <a href="{{ route('copy.present') }}" class="btn btn-danger btn-sm">
                    <i class="bi bi-book"></i> สำเนาหนังสือ
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
                    @foreach ($commands as $command)
                    <tr>
                        <td>{{ $command->initial }}</td>
                        <td>{{ timestampthaitext($command->created_at) }}</td>
                        <td>{{ $command->topic }}</td>
                        <td>
                            <a href="{{ route('command.show', $command->command_id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $commands->links() }}
        </div>
    </div>
</div>
@endsection