@extends('admin.layouts.master')

@section('title', 'Tạo sản phẩm')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12 col-lg-3">
                @include('admin.layouts.sidebar')
            </div>
            <div class="col-12 col-lg-9">
                <h1 class="mb-4">Tạo sản phẩm
                
                </h1>
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                    </div>

                    <div class="form-group">
                        <label>Danh mục <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    @if (old('category_id') == $category->id) selected @endif
                                >{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label>Giá bán <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="price" value="{{ old('price') }}">
                        </div>
                        <div class="col">
                            <label>Giá gốc</label>
                            <input type="text" class="form-control" name="cost" value="{{ old('cost') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="description" name="description" class="form-control" cols="30" rows="3">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Thumbnail</label>
                        <input type="file" class="form-control-file" name="thumbnail" accept="image/*">
                    </div>

                     <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="is_pinned" id="pin-product" @if (old('is_pinned')) checked @endif>
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
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Tạo</button>
                </form>
            </div>
        </div>
    </div>
@endsection