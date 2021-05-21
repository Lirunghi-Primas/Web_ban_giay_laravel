<div class="{{ $class }}">
    <a href="{{ route('product_detail', ['slug' => $product->slug]) }}">
        <img class="w-100 rounded" src="{{ $product->getThumbnail() }}">
    </a>
    <a href="{{ route('product_detail', ['slug' => $product->slug]) }}" class="text-dark">
        <h5 class='mt-2 font-weight-bold'>{{ $product->title }}</h5>
    </a>
    <p class='mb-0 font-weight-bold text-danger'>{{ price($product->price) }}</p>
    @if ($product->cost)
        <p class='mb-0 text-muted'>
            <small><del>{{ price($product->cost) }}</del></small>
        </p>
    @endif
</div>