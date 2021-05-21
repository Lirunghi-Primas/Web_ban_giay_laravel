@extends('user.layouts.master')

@section('title', 'Kiểm tra đơn hàng')

@section('content')

<main class="bg-light">
    <div class="container-fluid py-5">
        <div class="row" style="min-height: calc(100vh - 300px)">
            <div class="col-12 col-lg-3 mb-4">
                <div class="list-group">
                    <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-user-edit"></i> Hồ sơ
                    </a>
                    <a href="{{ route('order') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-clipboard-list"></i> Kiểm tra đơn hàng
                    </a>
                    <a href="{{ route('logout') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                </div>
            </div>
        
            <div class="col-12 col-lg-9">
               <h1 class="mb-4">Chi tiết đơn hàng <code>{{ $order->code }}</code>
                    <form action="{{ route('cancel_order', $order) }}" class="d-inline-block float-right" method="POST">
                        @csrf
                        <a href="{{ route('order') }}" class="btn btn-light"><i class="fas fa-reply"></i> Trở về</a>
                        <button class="btn btn-link text-danger" type="submit"
                            @if ($order->status != 'pending') disabled @endif
                        ><i class="fas fa-ban"></i> Hủy đơn hàng</button>
                    </form>
                </h1>

                <label>Trạng thái</label>
                @switch ($order->status)
                    @case('pending')
                        <span class="badge badge-secondary">Chờ xử lý</span>
                        @break
                    @case('sending')
                        <span class="badge badge-primary">Đang giao</span>
                        @break
                    @case('success')
                        <span class="badge badge-success">Đã giao hàng</span>
                        @break
                    @case('cancel')
                        <span class="badge badge-danger">Hủy đơn</span>
                        @break
                @endswitch
                    
                <div class="jumbotron py-4">  
                    <h4 class="mb-3">Thông tin khách hàng</h4>
                    <p>Họ và tên: {{ $order->fullname }}</p>
                    <p>Số điện thoại: <code>{{ $order->phone_number }}</code></p>
                    <p>Địa chỉ email: <a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
                    <p>Địa chỉ nhận hàng: <a href="https://www.google.com/maps/search/?api=1&query={{ $order->address }}" target="_blank">{{ $order->address }}</a> <i class="fas fa-map-marker-alt text-danger"></i></p>
                </div>

                <div class="row">
                    <div class="col-12 col-md-8 mb-5 pr-3 pr-md-5">
                        @foreach ($items as $item)
                            <div class="d-flex flex-row mb-3">
                                <div class=" align-items-start">
                                    <img src="data:image/jpg;base64, {{ $item->thumbnail }}" width="100"/>
                                </div>

                                <div class="align-self-start ml-3">
                                    {{ $item->title }}
                                    <div class="mt-2">
                                        <label class="badge badge-secondary">Size: {{ $item->size }}</label>
                                    </div>
                                </div>
                            
                                <div class="align-self-start ml-auto">
                                    <p class="text-right">{{ price($item->price) }}</p>
                                    <p class="text-right">Số lượng: <span class="badge badge-warning">{{ $item['qty'] }}</span></p>
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
                                {{ price($order->bill) }}
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
                                <strong class="text-danger">{{ price($order->bill) }}</strong>
                            </div>
                        </div>
                    
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
</main>


@endsection