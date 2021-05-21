@extends('user.layouts.master')

@section('title', 'Danh mục '.$category->name)

@section('content')

{{-- Jumbotron --}}
<div class="jumbotron jumbotron-fluid">
    <div class="container-fluid container-lg">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 mb-0">{{ $category->name }}</h1>
            </div>
        </div>
    </div>
</div>
{{-- /Jumbotron --}}

<section>
    <div class="container py-5">
        <div class="row">
            @if ($has_product > 0)
                <div class="col-12 col-lg-3 mb-4">
                    @include('user.components.product-filter-sidebar', [
                        'categories' => $categories,
                    ])
                </div>
                <div class="col-12 col-lg-9">
                    @if (count($products))
                        <div class="row">
                            @foreach ($products as $product)
                                @include('user.components.product', [
                                    'product' => $product,
                                    'class' => 'col-6 col-md-4 mb-4'
                                ])
                            @endforeach
                        </div>
                        {{ $products->links('user.components.pagination', ['class' => 'mt-3']) }}
                    @else
                        @include('user.components.empty-product', [
                            'title' => 'Oops! Không tìm thấy sản phẩm nào',
                            'caption' => 'Hệ thống không tìm thấy sản phẩm nào tương ứng với bộ lọc này',
                            'action' => route('product_list', ['slug' => $category->slug]),
                            'action_caption' => 'Trở về mặc định'
                        ])
                    @endif
                </div>
            @else
                <div class="col-12">
                    @include('user.components.empty-product', [
                        'title' => 'Oops! Chưa có sản phẩm nào',
                        'caption' => 'Danh mục này chưa có sản phẩm nào, chúng tôi sẽ cập nhật sớm nhất.',
                        'action' => route('home'),
                        'action_caption' => 'Trở về trang chủ'
                    ])
                </div>
            @endif
        </div>
    </div>
</section>

@endsection