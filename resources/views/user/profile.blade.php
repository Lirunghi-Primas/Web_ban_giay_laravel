@extends('user.layouts.master')

@section('title', 'Hồ sơ')

@section('content')

<main class="bg-light">
    <div class="container py-5">
    <div class="row">
        <div class="col-12 col-lg-4 mb-4">
            @include('user.components.user-sidebar')
        </div>
    
        <div class="col-12 col-lg-8">
            <form class='mb-5' method="POST" action="{{ route('profile.update') }}">
                @csrf
                <h1 class="mb-3">Hồ sơ</h1>
                <div class="form-group">
                    <label for="">Địa chỉ Email</label>
                    <input type="email" disabled class="form-control" value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <label for="">Họ và tên</label>
                    <input type="text" class="form-control" name="fullname" value="{{ old('fullname', $user->fullname) }}">
                </div>
                <div class="form-group">
                    <label for="">Địa chỉ giao hàng</label>
                    <input type="text" class="form-control" name="address" value="{{ old('address', $user->address) }}">
                </div>
                <div class="form-group">
                    <label for="">Số điện thoại</label>
                    <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number', $user->phone_number)}}">  
                </div>
                @if ($errors->any() && (! $errors->has('old_password') && ! $errors->has('password') && ! $errors->has('password_confirmation')))
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('profile_message'))
                    <div class="alert alert-success">
                        {{ session('profile_message') }}
                    </div>
                @endif

                <button type="submit" class="btn btn-success btn-block mx-auto">Cập nhật</button>
            </form>

            <form method="POST" action="{{ route('change_password') }}">
                @csrf
                <h1 class="mb-3">Đổi mật khẩu</h1>
                <div class="form-group">
                    <input type="password" class="form-control" name="old_password" placeholder="Nhập mật khẩu cũ ...">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu mới ...">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Nhập lại mật khẩu mới ...">
                </div>

                @if ($errors->any() && ($errors->has('old_password') || $errors->has('password') || $errors->has('password_confirmation')))
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('password_message'))
                    <div class="alert alert-success">
                        {{ session('password_message') }}
                    </div>
                @endif

                <button type="submit" class="btn btn-primary btn-block mx-auto">Lưu thay đổi</button>
            </form>
        </div>
    </div>
    </div>
</main>


@endsection