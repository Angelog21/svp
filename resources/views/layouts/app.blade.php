<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SVP') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/iconos.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">



</head>
<body>
    @if (Request::path() != 'login')
        @include('partials.navigation')
    @endif
        <main>
            @yield('title')
            @yield('content')
        </main>
        @if (Request::path() != 'login')
            @include('partials.footer')
        @endif
    <!-- Scripts -->
    <script src="{{asset('js/raphael.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/all.js') }}"></script>
    @include('sweetalert::alert')
    @if(strpos(Request::path(),'permits/estadisticas') !== false || strpos(Request::path(),'holidays/estadisticas') !== false)
        @include('partials.stadistics.scriptgraphics')
    @endif
    @if(Request::path() == 'holidays/administrar_personal')
        @include('partials.manageStaff.script')
    @endif
    @if(strpos(Request::path(),'holidays/administrar_vacaciones') !== false)
        @include('partials.manageStaff.script2')
    @endif
</body>
</html>
