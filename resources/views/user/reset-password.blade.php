@extends('user.layouts.master')

@section('title', 'Khôi phục mật khẩu')

@section('content')
    <div class="container-fluid py-5 bg-light">
        <div class="row justify-content-center">
            <form class="bg-white shadow-lg border my-5 form__login align-self-center">
                <div class="form__tab">
                    <div class=" form__tab-item pt-2 text-center">
                        <a class="h5 border-primary text-primary form_tab-item-active nav-link d-block" href="#">Khôi phục mật khẩu</a>
                    </div>
                </div>

                <div class='p-3'>
                    <div class="form-group">
                        <input type="password" class="form-control" id="exampleDropdownFormPassword2" placeholder="Nhập mật khẩu mới ...">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="exampleDropdownFormPassword2" placeholder="Nhập lại mật khẩu mới ...">
                    </div>
                    <button type="submit" class=" form__login-btn btn btn-primary btn-block mx-auto">Gửi</button>
                </div>

            </form>
        </div>
    </div>
@endsection