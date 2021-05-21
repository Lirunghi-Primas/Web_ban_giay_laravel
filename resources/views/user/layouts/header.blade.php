{{-- Muốn lấy ảnh logo dùng cú pháp <img src="{{ asset('images/flipper.jpg') }}"> --}}
<nav id="header" class="navbar navbar-expand-xl navbar-light ">
        <div class="container-fluid">
            <a class="navbar-brand order-1" href="{{ route('home') }}">
                <img class="navbar-logo" src="{{ asset('images/2.png') }}" ">
            </a>
          
            <div class="order-2 order-xl-3 d-flex">
                @include('user.components.search', ['class' => 'd-none d-md-flex'])
                <a href="{{ route('cart') }}"  class="navbar-icon d-inline-block p-2 text-decoration-none">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    @if (session('cart') && count(session('cart')) > 0)
                        <span class="badge badge-danger">{{ count(session('cart')) }}</span>
                    @endif
                </a>
                @auth
                    <a href="{{ route('profile') }}" class="navbar-icon d-inline-block p-2 text-dark">
                        <i class="nav-icon fas fa-user"></i> <span class="d-none d-sm-inline-block">{{ auth()->user()->fullname }}</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="navbar-icon d-inline-block p-2">
                        <i class="nav-icon fas fa-user"></i>
                    </a>
                @endauth
                <button class="navbar-toggler ml-3" type="button" data-toggle="collapse" data-target="#menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
          
            <div class="collapse navbar-collapse order-3 order-xl-2" id="menu">
                @include('user.components.search', ['class' => 'd-flex d-md-none my-3'])
                <ul class="navbar-nav my-2">
                    @foreach (primary_menu() as $item)
                        <li class="nav-item ml-0 ml-lg-4">
                            <a class="nav-link" href="{{ route('product_list', ['slug' => $item->slug]) }}">{{ $item->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
</nav>

@guest
<div class="bg-dark text-white text-center p-2">
    Hãy trở thành thành viên của Lirunghi để có thể theo dõi các đơn hàng đã đặt, đăng ký ngay <a class='text-warning' href="{{ route('register') }}"><ins>tại đây</ins> </a>
</div>
@endguest

@auth
<div class="bg-dark text-white text-center p-2">
    Bạn đang sử dụng địa chỉ giao hàng là <span class="text-warning">{{ auth()->user()->address }}</span>, để thay đổi hãy nhấn <a class='text-warning' href="{{ route('profile') }}"><ins>tại đây</ins> </a>
</div>
@endauth