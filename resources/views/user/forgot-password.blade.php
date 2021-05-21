@extends('user.layouts.master')

@section('title', 'Quên mật khẩu')

@section('content')
    <div class="container-fluid py-5 bg-light">
        <div class="row justify-content-center" style="min-height: calc(100vh - 300px)">
            <form class="bg-white shadow-lg border my-5 form__login align-self-center" method="POST" action="{{ route('send_forgot_password_request') }}">
                @csrf
                <div class="form__tab">
                    <div class=" form__tab-item pt-2 text-center">
                        <a class="h5 border-primary text-primary form_tab-item-active nav-link d-block" href="#">Quên mật khẩu</a>
                    </div>
                </div>

                <div class='p-3'>
                    <div class="form-group">
                        <input type="text" class="form-control" name="email" placeholder="Nhập địa chỉ email ..." value="{{ old("email") }}">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Gửi yêu cầu</button>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if (session('message'))
                        <div class="alert alert-success mt-3">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class='text-center mt-3'>
                        <a href="{{ route('login') }}">Trở về đăng nhập</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection