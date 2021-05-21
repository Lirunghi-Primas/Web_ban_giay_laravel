@inject('order', 'App\Models\Order')
@extends('admin.layouts.master')

@php
    $labels = [];
    $tempData = [];
    $data = [];
    $year = request()->query('year');
    $month = request()->query('month');

    if (! $year && ! $month) {
        $year = now()->year;
        $month = now()->month;
    }

    if ($year && $month) {
        for ($i = 1; $i <= \Carbon\Carbon::createFromFormat('Y-m', "$year-$month")->daysInMonth; $i++) {
            array_push($labels, "Ngày $i");
            array_push($data, \App\Models\Order::whereDate('created_at', "$year-$month-$i")->where('status', 'success')->sum('bill'));
            array_push($tempData, \App\Models\Order::whereDate('created_at', "$year-$month-$i")->sum('bill'));
        }
    }

    if ($year && ! $month) {
        for ($i = 1; $i <= 12; $i++) {
            array_push($labels, "Tháng $i");
            array_push($data, \App\Models\Order::whereYear('created_at', $year)->whereMonth('created_at', $i)->where('status', 'success')->sum('bill'));
            array_push($tempData, \App\Models\Order::whereYear('created_at', $year)->whereMonth('created_at', $i)->sum('bill'));
        }
    }

    $actualRevenue = array_sum($data);
    $estimatedRevenue = array_sum($tempData);

@endphp

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12 col-lg-3">
                @include('admin.layouts.sidebar')
            </div>
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card text-primary bg-light mb-3">
                            <div class="card-body position-relative">
                                <h5 class="card-title display-4">
                                    {{ \App\Models\Product::count() }}
                                </h5>
                                <p class="card-text mb-0">sản phẩm</p>
                                <i class="fas fa-box fa-5x position-absolute" style="top: 1rem; right: 1rem; opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card text-success bg-light mb-3">
                            <div class="card-body position-relative">
                                <h5 class="card-title display-4">
                                    {{ \App\Models\Category::count() }}
                                </h5>
                                <p class="card-text mb-0">danh mục</p>
                                <i class="fas fa-tags fa-5x position-absolute" style="top: 1rem; right: 1rem; opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card text-danger bg-light mb-3">
                            <div class="card-body position-relative">
                                <h5 class="card-title display-4">
                                    {{ \App\Models\User::count() }}
                                </h5>
                                <p class="card-text mb-0">khách hàng</p>
                                <i class="fas fa-users fa-5x position-absolute" style="top: 1rem; right: 1rem; opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-clipboard-list"></i> Đơn hàng
                            </div>
                            <div class="card-body">
                                <div class="progress">
                                    @php
                                        $countPendingOrder = $order->where('status', 'pending')->count();
                                        $widthPendingOrder = $order->count() > 0 ? ($countPendingOrder / $order->count()) * 100 : 0;

                                        $countSendingOrder = $order->where('status', 'sending')->count();
                                        $widthSendingOrder = $order->count() > 0 ? ($countSendingOrder / $order->count()) * 100 : 0;

                                        $countSuccessOrder = $order->where('status', 'success')->count();
                                        $widthSuccessOrder = $order->count() > 0 ? ($countSuccessOrder / $order->count()) * 100 : 0;

                                        $countCancelOrder = $order->where('status', 'cancel')->count();
                                        $widthCancelOrder = $order->count() > 0 ? ($countCancelOrder / $order->count()) * 100 : 0;
                                    @endphp
                                    @if ($countPendingOrder > 0)
                                        <div class="progress-bar bg-secondary" style="width: {{ $widthPendingOrder }}%" ></div>
                                    @endif
                                    @if ($countSendingOrder > 0)
                                        <div class="progress-bar bg-primary" style="width: {{ $widthSendingOrder }}%" ></div>
                                    @endif
                                    @if ($countSuccessOrder > 0)
                                        <div class="progress-bar bg-success" style="width: {{ $widthSuccessOrder }}%" ></div>
                                    @endif
                                    @if ($countCancelOrder > 0)
                                        <div class="progress-bar bg-danger" style="width: {{ $widthCancelOrder }}%" ></div>
                                    @endif
                                </div>
                           
                                <ul class="list-group list-group-flush mt-3">
                                    <a href="{{ route('admin.orders.index') }}" class="list-group-item list-group-item-action">
                                        <i class="far fa-square text-secondary"></i> Tất cả
                                        <span class="badge badge-dark badge-pill float-right mt-1">{{ $order->count() }}</span>
                                    </a>
                                    <a href="{{ route('admin.orders.index', ['status' => 'pending', 'q' => '']) }}" class="list-group-item list-group-item-action">
                                        <i class="fas fa-square text-secondary"></i> Chờ xử lý
                                        <span class="badge badge-secondary badge-pill float-right mt-1">{{ $countPendingOrder }}</span>
                                    </a>
                                    <a href="{{ route('admin.orders.index', ['status' => 'sending', 'q' => '']) }}" class="list-group-item list-group-item-action">
                                        <i class="fas fa-square text-primary"></i> Đang giao
                                        <span class="badge badge-primary badge-pill float-right mt-1">{{ $countSendingOrder }}</span>
                                    </a>
                                    <a href="{{ route('admin.orders.index', ['status' => 'success', 'q' => '']) }}" class="list-group-item list-group-item-action">
                                        <i class="fas fa-square text-success"></i> Đã giao hàng
                                        <span class="badge badge-success badge-pill float-right mt-1">{{ $countSuccessOrder }}</span>
                                    </a>
                                    <a href="{{ route('admin.orders.index', ['status' => 'cancel', 'q' => '']) }}" class="list-group-item list-group-item-action">
                                        <i class="fas fa-square text-danger"></i> Hủy đơn
                                        <span class="badge badge-danger badge-pill float-right mt-1">{{ $countCancelOrder }}</span>
                                    </a>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-dollar-sign"></i> Doanh thu
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <div class="card text-danger bg-light mb-3">
                                            <div class="card-body position-relative">
                                                <h5 class="card-title display-4">
                                                    {{ price($actualRevenue) }}
                                                </h5>
                                                <p class="card-text mb-0">doanh thu thực tế</p>
                                                <i class="fas fa-dollar-sign fa-5x position-absolute" style="top: 1rem; right: 1rem; opacity: 0.5;"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="card text-primary bg-light mb-3">
                                            <div class="card-body position-relative">
                                                <h5 class="card-title display-4">
                                                    {{ price($estimatedRevenue) }}
                                                </h5>
                                                <p class="card-text mb-0">doanh thu dự tính</p>
                                                <i class="fas fa-dollar-sign fa-5x position-absolute" style="top: 1rem; right: 1rem; opacity: 0.5;"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <form action="" method="GET">
                                            <div class="row">
                                                <div class="col form-group">
                                                    <label for="">Năm</label>
                                                    <select name="year" class="form-control">
                                                        @for ($i = 1990; $i <= now()->year; $i++)
                                                            <option value="{{ $i }}" 
                                                                @if (request()->query('year') == $i || (!request()->query('year') && $i == now()->year)) selected @endif
                                                            >{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col form-group">
                                                    <label for="">Tháng</label>
                                                    <select name="month" class="form-control">
                                                        <option value="" @if (! request()->query('month') == '') selected @endif>Tất cả</option>
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}" 
                                                                @if (request()->query('month') == $i 
                                                                || (! request()->query('year') && ! request()->query('month') && $i == now()->month)) selected @endif
                                                            >{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <a href="{{ route('admin.dashboard') }}" class="btn btn-light">Khôi phục</a>
                                            <button type="submit" class="btn btn-primary">Lọc kết quả</button>
                                        </form>
                                    </div>
                                </div>
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js"></script>
<script>
var labels = @json($labels);

var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Doanh thu thực tế',
                data: @json($data),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            },

            {
                label: 'Doanh thu ước tính',
                data: @json($tempData),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            },
        },
    }
});
</script>
@endpush