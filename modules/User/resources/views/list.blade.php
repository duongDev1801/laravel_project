@extends('layouts.backend')

@section('title', 'Quản lý người dùng')

@section('content')
    {!! showMessage(session('msg'), session('type')) !!}
    <div class="col-2 mb-3"><a href="{{ route('admin.users.create') }}" class="btn btn-primary">Thêm mới</a></div>
    <table id="datatable" class="table table-bordered">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Email</th>
                <th>Nhóm</th>
                <th>Thời gian</th>
                <th style="width:5%">Sửa</th>
                <th style="width:5%">Xoá</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Tên</th>
                <th>Email</th>
                <th>Nhóm</th>
                <th>Thời gian</th>
                <th style="width:5%">Sửa</th>
                <th style="width:5%">Xoá</th>

            </tr>
        </tfoot>
        {{-- <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->group_id }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td><button class="btn btn-warning">Sửa</button></td>
                    <td><button class="btn btn-danger">Xoá</button></td>
                </tr>
            @endforeach
        </tbody> --}}
    </table>
    @include('parts.backend.delete')
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#datatable").DataTable({
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.users.data') }}",
                columns: [{
                        data: 'name',
                    },
                    {
                        data: 'email',
                    },
                    {
                        data: 'group_id',
                    },
                    {
                        data: 'created_at',
                    },
                    {
                        data: 'edit',
                    },
                    {
                        data: 'delete',
                    }
                ]
            });
        });
    </script>
@endsection
