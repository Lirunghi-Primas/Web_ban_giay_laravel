@extends('admin.layouts.master')

@section('title', 'Chi tiết khách hàng')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12 col-lg-3">
                @include('admin.layouts.sidebar')
            </div>
            <div class="col-12 col-lg-9">
                <h1 class="mb-4">Chi tiết khách hàng
                    <form action="{{ route('admin.users.destroy', $user) }}" class="d-inline-block float-right" method="POST">
                        @method('DELETE')
                        @csrf
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light"><i class="fas fa-reply"></i> Trở về</a>
                        <button class="btn btn-link text-danger" type="submit"><i class="fas fa-trash"></i> Xóa</button>
                    </form>
                </h1>
                <div class="jumbotron lead py-4">
                    <p>Họ và tên: {{ $user->fullname }}</p>
                    <p>Số điện thoại: <code>{{ $user->phone_number }}</code></p>
                    <p>Địa chỉ email: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
                    <p>Địa chỉ nhận hàng: <a href="https://www.google.com/maps/search/?api=1&query={{ $user->address }}" target="_blank">{{ $user->address }}</a> <i class="fas fa-map-marker-alt text-danger"></i></p>
                    <p>Ngày tạo: {{ $user->created_at }}</p>
                    <p>Ngày cập nhật: {{ $user->updated_at }}</p>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
@endsection