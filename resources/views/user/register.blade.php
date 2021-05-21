@extends('user.layouts.master')

@section('title', 'Đăng ký')

@section('content')
    <div class="container-fluid py-5 bg-light">
        <div class="row justify-content-center">
            <form class="bg-white shadow-lg border my-5 form__login align-self-center" action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="form__tab row">
                    <div class=" form__tab-item col-6 text-center">
                        <a class=" border-primary text-primary border-bottom form_tab-item-active nav-link d-block" href="#">Đăng ký</a>
                    </div>
                    <div class="form__tab-item col-6 text-center">
                        <a class="nav-link d-block text-dark" href="{{ route('login') }}">Đăng nhập</a>
                    </div>
                </div>

                <div class='p-3'>
                    <div class="form-group">
                        <input type="text" class="form-control" name="fullname" placeholder="Họ và tên" value="{{ old('fullname') }}">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="phone_number" placeholder="Số điện thoại" value="{{ old('phone_number') }}">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Địa chỉ Email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Mật khẩu" value="{{ old('phone_number') }}">
                    </div>

                     <div class="form-group">
                        <input type="text" class="form-control" name="address" placeholder="Địa chỉ giao hàng" value="{{ old('address') }}">
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

                    <button type="submit" class=" form__login-btn btn btn-primary btn-block mx-auto">Đăng ký</button>
                    <p class="mt-3 text-center">Nếu có tài khoản, nhấn <a href="{{ route('login') }}" class="text-primary"> đăng nhập </a></p>
                </div>

            </form>
        </div>
    </div>
@endsection