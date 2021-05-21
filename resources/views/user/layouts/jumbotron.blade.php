@if ($pinned_product)
<div class="jumbotron jumbotron-fluid">
    <div class="container-fluid container-lg">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3 class="display-5">{{ $pinned_product->title }}</h3>
                <p class="lead text-muted">{{ $pinned_product->description }}</p>
                <a href="{{ route('product_detail', ['slug' => $pinned_product->slug]) }}" class="btn btn-dark text-warning btn-lg my-3">Xem ngay</a>            
            </div>
            <div class="col-12 col-md-6">
               <a href="{{ route('product_detail', ['slug' => $pinned_product->slug]) }}"><img src="{{ $pinned_product->getThumbnail() }}" alt="{{ $pinned_product->title }}" class="w-100"></a>
            </div>  
        </div>
    </div>
</div>
@endif