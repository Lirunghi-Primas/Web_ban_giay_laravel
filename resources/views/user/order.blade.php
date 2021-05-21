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
                <h1 class="mb-3">Kiểm tra đơn hàng</h1>
                @if (request()->has('q') || count($orders) > 0)
                    <div id="filter">
                        <form action="{{ url()->full() }}" method="GET">
                            <input type="hidden" name="page" value="{{ $orders->currentPage() }}">
                            <div class="row">
                                <div class="col">
                                    <label>Trạng thái</label>
                                    <select name="status" class="form-control">
                                        <option value="">Tất cả</option>
                                        @foreach (config('order_status') as $status => $label)
                                            <option value="{{ $status }}"
                                                @if (request()->query('status') == $status) selected @endif
                                            >{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col d-flex align-items-end">
                                    <div class="form-group d-inline-block flex-fill mr-2 mb-0">
                                        <label>Tìm kiếm</label>
                                        <input type="text" class="form-control" value="{{ request()->query('q') }}" placeholder="Nhập từ khóa..." name="q">
                                    </div>
                                    <button type="submit" class="btn btn-info">Lọc</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

                @if (count($orders) > 0)
                    <div class="table-responsive my-3">
                        <table class="table table-striped mb-0" style="width: 100%; min-width: 1100px;">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Khách hàng</th>
                                    <th scope="col">Tổng tiền</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Ngày đặt</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td><code>{{ $order->code }}</code></td>
                                        <td>
                                            <p>Họ và tên: @if ($order->user_id)
                                                <a href="{{ route('admin.users.show', $order->user_id) }}">{{ $order->fullname }}</a>
                                            @else
                                                {{ $order->fullname }}
                                            @endif</p>
                                            <p>Email: {{ $order->email }}</p>
                                            <p>Số điện thoại: <code>{{ $order->phone_number }}</code></p>
                                            <p>Địa chỉ giao hàng: {{ $order->address }}</p>
                                        </td>
                                        <td><strong class="text-danger">{{ price($order->bill) }}</strong></td>
                                        <td>
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
                                        </td>
                                        <td>{{ $order->created_at }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('order_detail', $order) }}" class="btn btn-light btn-sm"><i class="fas fa-eye"></i> Xem</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $orders->links('admin.components.pagination') }}
                @else
                    @if (request()->has('q'))
                        <div class="jumbotron jumbotron-fluid bg-light text-center">
                            <img src="{{ asset('images/empty-box.png') }}" width="100">
                            <h4 class="mt-3 mb-3">Không tìm thấy kết quả</h4>
                            <a class="btn btn-light" href="{{ route('order') }}"><i class="fas fa-reply"></i> Khôi phục bộ lọc</a>
                        </div>
                    @else
                        <div class="jumbotron jumbotron-fluid bg-light text-center">
                            <img src="{{ asset('images/empty-box.png') }}" width="100">
                            <h4 class="mt-3 mb-3">Chưa có dữ liệu nào</h4>
                        </div>
                    @endif
                @endif
                
            </div>
        </div>
    </div>
</main>


@endsection