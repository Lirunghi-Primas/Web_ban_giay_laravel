@extends('admin.layouts.master')

@section('title', 'Đăng nhập')

@push('style')
<style>
</style>
@endpush

@section('content')
    <div class="container-fluid bg-dark">
        <div class="row vh-100 justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4 align-self-center">
                <h1 class="text-white mb-3">
                    ADMIN
                </h1>
                <form action="{{ route('admin.login.post') }}" method="POST">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Tên đăng nhập" value="{{ old('username') }}">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Mật khẩu">
                    </div>
                   
                    <button class="btn btn-info">Đăng nhập</button>
                </form>
            </div>
        </div>
    </div>
@endsection