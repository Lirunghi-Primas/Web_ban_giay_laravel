@extends('admin.layouts.master')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12 col-lg-3">
                @include('admin.layouts.sidebar')
            </div>
            <div class="col-12 col-lg-9">
                <h1 class="mb-4">Chi tiết đơn hàng <code>{{ $order->code }}</code>
                    <form action="{{ route('admin.orders.destroy', $order) }}" class="d-inline-block float-right" method="POST">
                        @method('DELETE')
                        @csrf
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-light"><i class="fas fa-reply"></i> Trở về</a>
                        <button class="btn btn-link text-danger" type="submit"><i class="fas fa-trash"></i> Xóa</button>
                    </form>
                </h1>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PUT')

                    <label>Trạng thái</label>
                    <div class="input-group">
                        <select name="status" class="custom-select">
                            @foreach (config('order_status') as $status => $label)
                                <option value="{{ $status }}"
                                    @if ($order->status == $status) selected @endif
                                >{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit">Cập nhật</button>
                        </div>
                    </div>
                </form>
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
        </div>
    </div>
@endsection