@extends('layouts.backend')

@section('title', 'Quản lý người dùng')

@section('content')
    {!! showMessage(session('msg'), session('type')) !!}
    <div class="col-2 mb-3"><a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Thêm mới</a></div>
    <table id="datatable" class="table table-bordered">
        <thead>
            <tr>
                <th>Tên danh mục</th>
                <th>Slug</th>
                <th>Danh mục cha</th>
                <th>Thời gian</th>
                <th style="width:5%">Sửa</th>
                <th style="width:5%">Xoá</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Tên danh mục</th>
                <th>Slug</th>
                <th>Danh mục cha</th>
                <th>Thời gian</th>
                <th style="width:5%">Sửa</th>
                <th style="width:5%">Xoá</th>
            </tr>
        </tfoot>

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
                ajax: "{{ route('admin.categories.data') }}",
                columns: [{
                        data: 'name',
                    },
                    {
                        data: 'slug',
                    },
                    {
                        data: 'parent_id',
                        // render: function(data, type, row, meta) {
                        //     return '<strong>' + data + '</strong>';
                        // }
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
