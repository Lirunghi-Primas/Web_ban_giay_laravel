@extends('user.layouts.master')

@section('title', 'Giỏ hàng')


@section('content')
<div class="container-fluid container-lg py-5">
    @if (count($cart) > 0)
        <div class="row">
            <div class="col-12 col-md-8 mb-5 pr-3 pr-md-5">
                <h4 class="mb-3">Giỏ hàng</h4>
                @foreach ($cart as $item)
                    <div class="d-flex flex-row mb-3">
                        <div class=" align-items-start">
                            <a href="{{ route('product_detail', ['slug' => $item['product']->slug]) }}">
                                <img src="{{ $item['product']->getThumbnail() }}" width="100"/>
                            </a>
                        </div>

                        <div class="align-self-start ml-3">
                            <a class="text-dark" href="{{ route('product_detail', ['slug' => $item['product']->slug]) }}">{{ $item['product']->title }}</a>
                            <div class="mt-2">
                                <label class="badge badge-secondary">Size: {{ $item['size'] }}</label>
                            </div>
                            <a href="{{ route('remove_to_cart', ['product_id' => $item['product_id'], 'size' => $item['size']]) }}" class="btn btn-light">Xóa</a>     
                        </div>
                    
                        <div class="align-self-start ml-auto">
                            <p class="text-right">{{ price($item['product']->price) }}</p>
                            <div class="input-group mb-3 input-group-sm ml-auto">
                                <a href="{{ route('update_cart', ['product_id' => $item['product_id'], 'size' => $item['size'], 'action' => 'minus']) }}" class="btn btn-outline-secondary rounded-0">
                                    <i class="fas fa-minus"></i>
                                </a>

                                <span class="input-group-text rounded-0 bg-white border-secondary" >{{ $item['qty'] }}</span>

                                <a href="{{ route('update_cart', ['product_id' => $item['product_id'], 'size' => $item['size'], 'action' => 'plus']) }}" class="btn btn-outline-secondary rounded-0">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-12 col-md-4">
                <h4 class="mb-3">Hóa đơn</h4>
                <div class="d-flex flex-row mb-3 mt-2">
                    <div class="align-self-start font-weight-bold">
                        Tạm tính
                    </div>
                    
                    <div class="align-self-start ml-auto">
                        {{ price($bill) }}
                    </div>
                </div>

                <div class="d-flex flex-row mb-3">
                    <div class="align-self-start font-weight-bold">
                        Phí vận chuyển
                    </div>
                    
                    <div class="align-self-start ml-auto">
                        Miễn phí
                    </div>
                </div>

                <div class="pb-2 border-bottom text-muted">
                    Thuế VAT đã bao gồm trong giá sản phẩm
                </div>

                <div class="pb-2 border-bottom d-flex flex-row mt-2">
                    <div class="align-self-start font-weight-bold">
                        Tổng đơn
                    </div>

                    <div class="align-self-start ml-auto">
                        <strong class="text-danger">{{ price($bill) }}</strong>
                    </div>
                </div>
                <h4 class="mt-4 mb-3">Thông tin khách hàng</h4>
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Họ và tên</label>
                        <input type="text" class="form-control" name="fullname"
                            @auth readonly @endauth value="{{ auth()->user()->fullname ?? '' }}"
                        >
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" class="form-control" name="phone_number"
                            @auth readonly @endauth value="{{ auth()->user()->phone_number ?? '' }}"
                        >
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ Email</label>
                        <input type="text" class="form-control" name="email"
                            @auth readonly @endauth value="{{ auth()->user()->email ?? '' }}"
                        >
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ giao hàng</label>
                        <input type="text" class="form-control" name="address"
                            @auth readonly @endauth value="{{ auth()->user()->address ?? '' }}"
                        >
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger my-3">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <button type="submit" class="btn btn-dark text-warning btn-block btn-lg">Đặt hàng</button>
                </form>
              
            </div>
        </div>
    @else
        <div class="row py-5">
            <div class="col-12">
                @include('user.components.empty-product', [
                    'title' => 'Oops! Giỏ hàng trống',
                    'caption' => 'Hiện tại giỏ hàng của bạn chưa có bất kỳ sản phẩm nào',
                    'action' => route('home'),
                    'action_caption' => 'Trở về trang chủ'
                ])
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
@if (session('just_payment'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Đã đặt đơn hàng thành công',
            showConfirmButton: false,
            timer: 1500
        })
    </script>
@endif
@endpush