@extends('layouts.backend')
@section('content')
    {!! showMessage(session('msg'), session('type')) !!}
    <form action="{{ route('admin.users.update', $user) }}" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Tên</label>
                    <input type="text" name="name" value="{{ $user->name }}"
                        class="form-control @error('name') is-invalid @enderror" placeholder="Tên...">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Email</label>
                    <input type="text" name="email" value="{{ $user->email }}"
                        class="form-control @error('email') is-invalid @enderror" placeholder="Email...">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Nhóm</label>
                    <select name="group_id" id="" class="form-select @error('group_id') is-invalid @enderror">
                        <option value="0">Chọn nhóm</option>
                        <option value="1" @if ($user->group_id == '1') selected @endif>Administrator</option>
                    </select>
                    @error('group_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Mật khẩu</label>
                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password...">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary">Lưu lại</button>
                <a href="{{ route('admin.user.index') }}" class="btn btn-danger">Huỷ</a>
            </div>
        </div>
    </form>
@endsection
