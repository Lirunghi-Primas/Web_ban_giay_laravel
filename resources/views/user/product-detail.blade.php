@extends('user.layouts.master')

@section('title', $product->title)

@section('content')
<div class="container-fluid container-lg py-5">
    <div class="row">
        <div class="col-lg-6">
            <img class="w-100" src="{{ $product->getThumbnail() }}">
        </div>

        <div class="col-lg-6 mt-3 mt-lg-0">
            <a href="{{ route('product_list', ['slug' => $category->slug]) }}" class="text-dark">
                <h5>
                    {{ $category->name }}
                </h5>
            </a>
            <h4 class="text-uppercase">
                {{ $product->title }}
            </h4>
            <div class="my-4">
                <span class="mr-2 text-danger lead">{{ price($product->price) }}</span>
                @if ($product->cost)
                    <del class="text-muted">{{ price($product->cost) }}</del>
                @endif
            </div>
            <div>
                <label class="mt-3">Chọn Size</label>
            </div>
            <div class="row mx-0" style="margin-left: 1px !important;">
                @for ($i = 35; $i <= 44; $i++) 
                    <div class="col-4 col-sm-3 col-md-2 col-lg-3 px-0" style="margin-left: -1px; margin-bottom: -1px;">
                        <button type="button" class="btn btn-block rounded-0 border btn-size">{{ $i }}</button>
                    </div>
                @endfor
            </div>

            <div class="row my-4">
                <div class="col-12 mb-2 col-sm-6">
                    <a href="{{ route('add_to_cart', ['product_id' => $product->id, 'size' => 35, 'redirect_to_cart' => 1]) }}" class="btn btn-block btn-lg btn-dark border rounded text-warning btn-add-to-cart">Mua ngay</a>
                </div>
                <div class="col-12 col-sm-6">
                    <a href="{{ route('add_to_cart', ['product_id' => $product->id, 'size' => 35]) }}" class="btn btn-add-to-cart btn-block btn-lg border rounded">Thêm vào giỏ hàng</a>
                </div>
            </div>
            <p class="text-justify">{{ $product->description }}</p>
        </div>
    </div>

    <h2 class='text-left mt-5 mb-3 font-weight-light'>Sản phẩm liên quan</h2>
    <div class="row">
        @foreach ($related as $item)
            @include('user.components.product', [
                'product' => $item,
                'class' => 'col-6 col-md-3 mb-4'
            ])
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
@if (session('just_add_to_cart'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Đã thêm vào giỏ hàng',
            showConfirmButton: false,
            timer: 1500
        })
    </script>
@endif

<script>
    $('.btn-size:first').addClass('bg-dark text-warning active');

    $('.btn-size').on('click', function() {
        let size = $(this)
        $('.btn-size').removeClass('bg-dark text-warning active');
        size.addClass('bg-dark text-warning active');
        $('.btn-add-to-cart').each(function(index, btn) {
            let link = $(btn).attr('href').replace(/size\=[0-9]+/, 'size=' + size.html())
            $(btn).attr('href', link)
        })
    });
</script>
@endpush
