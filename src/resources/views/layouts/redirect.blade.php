<!DOCTYPE html>
<html>
    <head>
        @include('helpers.tagmanager.script')
        <meta charset="utf-8">
        <meta name="viewport" content"width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow" />
        <title>&raquo;&raquo;&raquo;</title>
    </head>
    <body>
        @include('helpers.tagmanager.noscript')
        @yield('body')
        <script type="text/javascript">
            var url = "{!! $url !!}";
            window.location.assign(url);
        </script>
    </body>
</html>
