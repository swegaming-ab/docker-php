@php

    // TODO not used anymore since using Tag Manager instead

    use Prismic\Api;
    use Prismic\Predicates;

    $api = Api::get(config('prismic.url'), config('prismic.token'));
    $settings = $api->query(
        [Predicates::at('document.type', 'settings')],
        ['lang' => $document->lang]
    );
@endphp

@if(count($settings->results) > 0)
    @php
        $settings = $settings->results[0];
    @endphp

    @foreach ($settings->data->{$variableName} as $htmlString)
        {!! $htmlString->text !!}
    @endforeach
@endif
