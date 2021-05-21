@extends('admin.layouts.master')

@section('title', 'Danh sách sản phẩm')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12 col-lg-3">
                @include('admin.layouts.sidebar')
            </div>
            <div class="col-12 col-lg-9">
                <h1 class="mb-4">Danh sách sản phẩm
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary float-right mt-2"><i class="fas fa-plus"></i> Tạo</a>
                </h1>
                @if (request()->has('q') || count($products) > 0)
                    <div id="filter">
                        <form action="{{ url()->full() }}" method="GET">
                            <input type="hidden" name="page" value="{{ $products->currentPage() }}">
                            <div class="row">
                                <div class="col">
                                    <label>Danh mục</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if (request()->query('category_id') == $category->id) selected @endif
                                            >{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col d-flex align-items-end">
                                    <div class="form-group d-inline-block flex-fill mr-2 mb-0">
                                        <label>Tìm kiếm</label>
                                        <input type="text" class="form-control" value="{{ request()->query('q') }}" placeholder="Nhập từ khóa..." name="q">
                                    </div>
                                    <button type="submit" class="btn btn-info">Lọc</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

                @if (count($products) > 0)
                    <div class="table-responsive mt-3">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"></th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Danh mục</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>
                                            <img src="{{ $product->getThumbnail() }}" class="img-fluid img-thumbnail" width="80">
                                        </td>
                                        <td>
                                            @if ($product->is_pinned)
                                                <i class="fas fa-star text-warning"></i>
                                            @endif
                                            <a href="{{ route('admin.products.edit', $product) }}">{{ $product->title }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.categories.edit', $product->category) }}">{{ $product->category->name }}</a>
                                        </td>
                                        <td>
                                            <span class="text-danger d-block font-weight-bold">{{ price($product->price) }}</span>
                                            @isset($product->cost)
                                                <del class="text-muted d-block">{{ price($product->cost) }}</del>
                                            @endisset
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-light btn-sm"><i class="fas fa-edit"></i> Sửa</a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" class="d-inline-block" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-link text-danger btn-sm" type="submit"><i class="fas fa-trash"></i> Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $products->links('admin.components.pagination') }}
                @else   
                    @if (request()->has('q'))
                        <div class="jumbotron jumbotron-fluid bg-white text-center">
                            <img src="{{ asset('images/empty-box.png') }}" width="100">
                            <h4 class="mt-3 mb-3">Không tìm thấy kết quả</h4>
                            <a class="btn btn-light" href="{{ route('admin.products.index') }}"><i class="fas fa-reply"></i> Khôi phục bộ lọc</a>
                        </div>
                    @else
                        <div class="jumbotron jumbotron-fluid bg-white text-center">
                            <img src="{{ asset('images/empty-box.png') }}" width="100">
                            <h4 class="mt-3 mb-3">Chưa có dữ liệu nào</h4>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection