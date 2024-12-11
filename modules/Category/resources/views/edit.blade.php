@extends('layouts.backend')
@section('content')
    {!! showMessage(session('msg'), session('type')) !!}
    <form action="{{ route('admin.categories.update', $category) }}" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Tên danh mục</label>
                    <input type="text" name="name" value="{{ $category->name }}"
                        class="{{ trim('form-control title ' . ($errors->has('name') ? 'is-invalid' : '')) }}"
                        placeholder="Tên...">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="">Slug</label>
                    <input type="text" name="slug" value="{{ $category->slug }}"
                        class="form-control slug @error('slug') is-invalid @enderror" placeholder="Slug...">
                    @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-6 ">
                <div class="mb-3">
                    <label for="">Danh mục cha</label>
                    <select name="parent_id" id="" class="form-select @error('parent_id') is-invalid @enderror">
                        <option value="0">Không</option>
                    </select>
                    @error('parent_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>


        </div>
        <div class="col-2">
            <button type="submit" class="btn btn-primary">Lưu lại</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-danger">Huỷ</a>
        </div>
    </form>
@endsection
