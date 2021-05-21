@extends('user.layouts.master')

@section('title', 'Trang chủ')

@section('content')
{{-- Jumbotron --}}
@include('user.layouts.jumbotron')
{{-- /Jumbotron --}}

{{-- Best Seller  --}}
<section>
    <div class="container-fluid container-lg py-5 list-product">
        <h2 class='text-left mb-3 font-weight-light'>BÁN CHẠY</h2>
        <div class="row">
        @foreach($best_sell_products as $product)
            @include('user.components.product', [
                'product' => $product,
                'class' => 'col-6 col-md-3 mb-4'
            ])
        @endforeach
    </div>
</div>
</section>

{{-- New Release --}}
<section class='bg-light'>
    <div class="container-fluid container-lg py-5 list-product ">
        <h2 class='text-left mb-3 font-weight-light'>MỚI NHẤT</h2>
        <div class="row">
            @foreach($latest_products as $product)
                @include('user.components.product', [
                    'product' => $product,
                    'class' => 'col-6 col-md-3 mb-4'
                ])
            @endforeach
        </div>
    </div>
</section>

@endsection