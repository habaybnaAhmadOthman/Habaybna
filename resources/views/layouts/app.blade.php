<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/admin.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://vjs.zencdn.net/7.15.4/video-js.css" rel="stylesheet" />

    {{-- <link href="{{ asset('css/admin.css') }}" rel="stylesheet"> --}}


</head>

<body>
    <div id="app">

        @if (Auth::user() && Auth::user()->role == 'admin')
             {{-- @include('admin.layouts.nav') --}}
            {{-- @include('admin.layouts.flashMessage') --}}
            <main>
                @yield('content')
               
            </main>
            @else
            <main>
                @yield('content')
            </main>
            @endif


    </div>
    <script src="https://vjs.zencdn.net/7.15.4/video.min.js"></script>

</body>
{{-- <script src="{{ mix('/js/app.js') }}"></script> --}}
{{-- @yield('js-files')
@yield('js-script') --}}
</html>
