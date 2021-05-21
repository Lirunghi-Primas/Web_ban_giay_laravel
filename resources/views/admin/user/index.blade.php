@extends('admin.layouts.master')

@section('title', 'Danh sách khách hàng')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12 col-lg-3">
                @include('admin.layouts.sidebar')
            </div>
            <div class="col-12 col-lg-9">
                <h1 class="mb-4">Danh sách khách hàng
                    
                </h1>
                @if (request()->has('q') || count($users) > 0)
                    <div id="filter">
                        <form action="{{ url()->full() }}" method="GET">
                            <input type="hidden" name="page" value="{{ $users->currentPage() }}">
                            <div class="row">
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
                @if (count($users) > 0) 
                    <div class="table-responsive mt-3">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Họ và tên</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Số điện thoại</th>
                                    <th scope="col">Địa chỉ</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $user) }}">{{ $user->fullname }}</a>
                                        </td>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            <code>{{ $user->phone_number }}</code>
                                        </td>
                                        <td>
                                            {{ $user->address }}
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-light btn-sm"><i class="fas fa-eye"></i> Xem</a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" class="d-inline-block" method="POST">
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
                    {{ $users->links('admin.components.pagination') }}
                @else
                    @if (request()->has('q'))
                        <div class="jumbotron jumbotron-fluid bg-white text-center">
                            <img src="{{ asset('images/empty-box.png') }}" width="100">
                            <h4 class="mt-3 mb-3">Không tìm thấy kết quả</h4>
                            <a class="btn btn-light" href="{{ route('admin.users.index') }}"><i class="fas fa-reply"></i> Khôi phục bộ lọc</a>
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