@php
$categoryId = isset($category) ? $category->id : request()->query('category_id')
@endphp

<div class="mb-5">
    <h5 class="mb-3">Danh mục</h5>
    @empty($category)
        <p class="ml-3">
            @if (! $categoryId)
                <i class="fas fa-circle text-warning"></i>
            @endif
            <a class="text-dark" href="
                {{ request()->fullUrlWithQuery(['page' => null, 'category_id' => null]) }}
            ">Tất cả</a>
        </p>
    @endempty
    @foreach ($categories as $item)
        <p class="ml-3">
            @if ($categoryId == $item->id)
                <i class="fas fa-circle text-warning"></i>
            @endif
            <a class="text-dark" href="
                @isset($category) 
                    {{ route('product_list', ['slug' => $item->slug, 'page' => null]) }}
                @else 
                    {{ request()->fullUrlWithQuery(['page' => null, 'category_id' => $item->id]) }}
                @endisset
            ">{{ $item->name }}</a>
        </p>

        @foreach ($item->children as $subItem)
            <p class="ml-5">
                @if ($categoryId == $subItem->id)
                    <i class="fas fa-circle text-warning"></i>
                @endif
                <a class="text-dark" href="
                @isset($category) 
                    {{ route('product_list', ['slug' => $subItem->slug, 'page' => null]) }}
                @else 
                    {{ request()->fullUrlWithQuery(['page' => null, 'category_id' => $item->id]) }}
                @endisset
                ">{{ $subItem->name }}</a>
            </p>
        @endforeach
    @endforeach
</div>
<div>
    <h5 class="mb-3">Chọn mức giá</h5>
    <p class="ml-3">
        @if (! request()->query('price'))
            <i class="fas fa-circle text-warning"></i>
        @endif
        <a class="text-dark" href="{{ request()->fullUrlWithQuery(['price' => null, 'page' => null]) }}">Tất cả</a>
    </p>
    @foreach(config('price_filter') as $price => $text)
        <p class="ml-3">
            @if (request()->query('price') == $price)
                <i class="fas fa-circle text-warning"></i>
            @endif
            <a class="text-dark" href="{{ request()->fullUrlWithQuery(['price' => $price, 'page' => null]) }}">{{ $text }}</a>
        </p>
    @endforeach 
</div>