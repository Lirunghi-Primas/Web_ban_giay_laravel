@extends('admin.layouts.master')

@section('title', 'Danh sách danh mục')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12 col-lg-3">
                @include('admin.layouts.sidebar')
            </div>
            <div class="col-12 col-lg-9">
                <h1 class="mb-4">Danh sách danh mục
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary float-right mt-2"><i class="fas fa-plus"></i> Tạo</a>
                </h1>
                @if (count($categories) > 0)
                    <div class="table-responsive mt-3">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col">Danh mục cha</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.categories.edit', $category) }}">{{ $category->name }}</a>
                                        </td>
                                        <td>
                                            @php $parent = $category->parent @endphp
                                            @if ($parent)
                                                <a href="{{ route('admin.categories.edit', $parent) }}">{{ $parent->name }}</a>
                                            @else
                                                <p class="text-muted">Không</p>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-light btn-sm"><i class="fas fa-edit"></i> Sửa</a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" class="d-inline-block" method="POST">
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
                @else
                    <div class="jumbotron jumbotron-fluid bg-white text-center">
                        <img src="{{ asset('images/empty-box.png') }}" width="100">
                        <h4 class="mt-3 mb-3">Chưa có dữ liệu nào</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection