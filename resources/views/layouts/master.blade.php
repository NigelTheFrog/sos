<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="stylesheet" href="{{ asset('assets/css/font-bunny/fonts.bunny.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap4-1-3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap5-3-2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icon/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/virtual-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sweet-alert2.min.css') }}">

    <script src="{{ asset('assets/js/bootstrap@5.3.2.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/fontawesome.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3-3-1.slim.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/ajax.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/virtual-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweet-alert2.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.7.0.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.1.13.7.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.searchBuilder.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.dateTime.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    @yield('styles')
    
</head>

<body>
    @include('layouts.inc.admin-navbar')
    <div id="layoutSidenav">
        @include('layouts.inc.admin-sidebar')
        <div id="layoutSidenav_content">
            <main class="pb-3" style="background-color:rgb(234, 234, 234); height: 100%;">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @elseif (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
            @include('layouts.inc.admin-footer')
        </div>
    </div>
</body>

</html>
