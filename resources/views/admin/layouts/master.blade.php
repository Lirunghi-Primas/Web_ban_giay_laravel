<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }} Administration</title>

    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

    <link rel="icon" type="image/png" href="{{ asset('images/2.png') }}">
    
    @stack('styles')
</head>
<body>
    @auth('admin')
        @include('admin.layouts.header')
    @endauth
    
    @yield('content')

    @auth('admin')
        @include('admin.layouts.footer')
    @endauth

    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>

    @stack('scripts')
</body>
</html>