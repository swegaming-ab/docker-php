@php
    use App\Locale\Locale;
    use App\LinkResolver;

    $linkResolver = new LinkResolver();
@endphp

<link rel="alternate" hreflang="{{ $document->lang }}" href="{{ $requestUrl }}" />
@foreach ($document->alternate_languages as $alternateLocale)
    @if($link = $linkResolver->resolveWithAppUrl($alternateLocale))
        <link rel="alternate" hreflang="{{ $alternateLocale->lang }}" href="{{ $link }}" />
    @endif
@endforeach
