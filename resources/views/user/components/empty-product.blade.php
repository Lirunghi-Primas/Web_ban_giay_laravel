<div class="jumbotron jumbotron-fluid bg-white text-center">
    <img src="{{ asset('images/empty-box.png') }}" width="100">
    <h4 class="mt-3">{{ $title }}</h4>
    <p class="text-muted lead">{{ $caption }}</p>
    <a class="btn btn-light" href="{{ $action }}"><i class="fas fa-reply"></i> {{ $action_caption }}</a>
</div>