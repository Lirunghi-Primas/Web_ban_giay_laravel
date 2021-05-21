@extends('user.layouts.master')

@section('title', 'Khôi phục mật khẩu')

@section('content')
<div class="container-fluid py-5 bg-light">
    <div class="row justify-content-center" style="min-height: calc(100vh - 300px)">
        <form class="bg-white shadow-lg border my-5 form__login align-self-center" method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form__tab">
                <div class=" form__tab-item pt-2 text-center">
                    <a class="h5 border-primary text-primary form_tab-item-active nav-link d-block" href="#">Khôi phục mật khẩu</a>
                </div>
            </div>

            <div class='p-3'>
                <div class="form-group">
                    <input type="text" readonly class="form-control" name="email" value="{{ request()->query('email') }}">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu mới ...">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Nhập lại mật khẩu mới ...">
                </div>
                
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success mt-3">
                        {{ session('status') }}
                    </div>
                @endif
                <button type="submit" class=" form__login-btn btn btn-primary btn-block mx-auto">Xác nhận</button>
            </div>

           

        </form>
    </div>
</div>
@endsection
