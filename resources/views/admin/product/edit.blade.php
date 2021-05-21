@extends('admin.layouts.master')

@section('title', 'Sửa sản phẩm')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12 col-lg-3">
                @include('admin.layouts.sidebar')
            </div>
            <div class="col-12 col-lg-9">
                <h1 class="mb-4">Sửa sản phẩm
                    <form action="{{ route('admin.products.destroy', $product) }}" class="d-inline-block float-right" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-link text-danger" type="submit"><i class="fas fa-trash"></i> Xóa</button>
                    </form>
                </h1>
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" value="{{ old('title', $product->title) }}">
                    </div>

                    <div class="form-group">
                        <label>Danh mục <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    @if (old('category_id', $product->category_id) == $category->id) selected @endif
                                >{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label>Giá bán <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="price" value="{{ old('price', $product->price) }}">
                        </div>
                        <div class="col">
                            <label>Giá gốc</label>
                            <input type="text" class="form-control" name="cost" value="{{ old('cost', $product->cost) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="description" name="description" class="form-control" cols="30" rows="3">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Thumbnail</label>
                        <input type="file" class="form-control-file" name="thumbnail" accept="image/*">
                        @isset($product->thumbnail_path)
                            <img src="{{ $product->getThumbnail() }}" width="150" class="img-thumbnail img-fluid mt-2">
                        @endisset
                    </div>

                     <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="is_pinned" id="pin-product" @if (old('is_pinned', $product->is_pinned)) checked @endif>
                            <label class="custom-control-label" for="pin-product">Ghim sản phẩm</label>
                        </div>
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
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light"><i class="fas fa-reply"></i> Trở về</a>
                    <button type="submit" class="btn btn-success"><i class="fas fa-edit"></i> Sửa</button>
                </form>
            </div>
        </div>
    </div>
@endsection