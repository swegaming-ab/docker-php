@php

    use App\LinkResolver;

    if(!isset($document)) {

        // if we don't have the document parameter we need it.
        return 'No document parameter specified.';
    }

    $linkResolver = new LinkResolver();
    $url = $linkResolver->resolve($document);
    $canonical = config('app.url') . $url;

    if(strcasecmp($canonical, '/' . request()->path()) !== 0) {
        // we should redirect these to the canonical
        // url instead.
    }
@endphp

<!DOCTYPE html>
<html lang="{{ config('locales.' .$locale. '.html_lang') }}" dir="ltr">
    <head>
        @include('helpers.tagmanager.script')

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="https://kit.fontawesome.com/086f5d3908.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/vue/latest/vue.js"></script>
        <script src="{{ mix('js/app.js') }}"></script>

        @if(!\App::environment('production'))
            <meta name="robots" content="noindex">
        @endif

        <link rel="canonical" href="{{ $canonical }}">
        @include('components.hreflangs', ['document' => $document, 'requestUrl' => $canonical])

        <title>@yield('title', 'BettingGuide')</title>

        @hasSection('description')
            <meta name="description" content="@yield('description')" />
        @endif

    </head>
    <body id="app">
        @include('helpers.tagmanager.noscript')
        @include('includes.nav')
        @yield('body')
        @include('includes.footer')

        @if(config('prismic.preview'))
            <script>
                window.prismic = {
                    endpoint: '{{ config('prismic.url') }}'
                };
            </script>
            <script type="text/javascript" src="https://static.cdn.prismic.io/prismic.min.js?new=true"></script>
        @endif
    </body>
</html>
