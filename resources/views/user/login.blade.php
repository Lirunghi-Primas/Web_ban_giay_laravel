@extends('user.layouts.master')

@section('title', 'Đăng nhập')

@section('content')
    <div class="container-fluid py-5 bg-light">
        <div class="row justify-content-center">
            <form class="bg-white shadow-lg border my-5 form__login align-self-center" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form__tab row">
                    <div class="form__tab-item col-6 text-center">
                        <a class="nav-link d-block text-dark" href="{{ route('register') }}">Đăng ký</a>
                    </div>
                    <div class="form__tab-item col-6 text-center">
                        <a class="border-warning border-bottom form_tab-item-active nav-link d-block text-dark" href="#">Đăng nhập</a>
                    </div>
                </div>

                <div class='p-3'>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Địa chỉ Email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Mật khẩu">
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label id="form-check-text" class="form-check-label" for="remember">
                                Nhớ mật khẩu? 
                            </label>
                        </div>
                    </div>
                    <button type="submit" class=" form__login-btn btn btn-dark text-warning btn-block mx-auto btn">Đăng nhập</button>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3 mb-0">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    
                    <div id='form__login-forget' class='border-light border-bottom text-center'>
                        <a href="{{ route('forgot_password') }}">Quên mật khẩu?</a>
                    </div>
                    
                    <a href="{{ route('register') }}" id='form__login-btn-create' class=" form__login-btn btn btn-light btn-block mx-auto">Tạo tài khoản mới</a>
                </div>
                
            </form>
        </div>
    </div>
@endsection