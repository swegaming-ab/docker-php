<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        @include('helpers.tagmanager.script')
        <meta charset="utf-8">
        {{-- <meta name="viewport" content"width=device-width, initial-scale=1"> --}}
        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
        {{-- <link type="text/css" rel="stylesheet" href="{{ mix('css/index.css') }}"> --}}
        <script src="https://kit.fontawesome.com/086f5d3908.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/vue/latest/vue.js"></script>

        @if(!\App::environment('production'))
            <meta name="robots" content="noindex">
        @endif

        {{-- needed??? --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @hasSection('canonical')
            <link rel="canonical" href="@yield('canonical')">
        @endif

        @yield('hreflangs')

        <title>@yield('title', 'BettingGuide')</title>

        @hasSection('description')
            <meta name="description" content="@yield('description')" />
        @endif

        @yield('head')
    </head>
    <body id="app">
        @include('helpers.tagmanager.noscript')
        @yield('body')
    </body>
    {{-- <script src="{{ mix('js/app.js') }}"></script>     --}}
    {{-- <script src="http://localhost:8080/js/app.js"></script> --}}
</html>
