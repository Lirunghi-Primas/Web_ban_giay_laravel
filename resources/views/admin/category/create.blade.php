@extends('admin.layouts.master')

@section('title', 'Tạo danh mục')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12 col-lg-3">
                @include('admin.layouts.sidebar')
            </div>
            <div class="col-12 col-lg-9">
                <h1 class="mb-4">Tạo danh mục</h1>
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label>Danh mục cha</label>
                        <select name="parent_id" class="form-control">
                            <option value="">-- Không --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if ($category->id == old('parent_id')) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light"><i class="fas fa-reply"></i> Trở về</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Tạo</button>
                </form>
            </div>
        </div>
    </div>
@endsection