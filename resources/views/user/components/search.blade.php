@php
if (\Request::route()->getName() == 'order') {
    $q = null;
} else {
    $q = request()->query('q');
}
@endphp

<form class="{{ $class }}" action="{{ route('search') }}" method="GET">
    @if (request()->has('category_id'))
    <input type="hidden" name="category_id" value="{{ request()->query('category_id') }}">
    @endif
    @if (request()->has('price'))
    <input type="hidden" name="price" value="{{ request()->query('price') }}">
    @endif
    <input class="form-control rounded-pill" name="q" type="search" placeholder="Tìm kiếm sản phẩm..." value="{{ $q }}">
</form>
