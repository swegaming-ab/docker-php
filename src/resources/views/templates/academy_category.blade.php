@php

    use App\LinkResolver;
    use Prismic\Api;
    use Prismic\Predicates;
    use Prismic\Dom\RichText;

    // to get the urls of the documents
    // we need to link. Always use the LinkResolver
    // as that should be able to get all links so that
    // everything is correct.
    $linkResolver = new LinkResolver();

    // query the api for all pages with this document
    // as its parent. Fetch the title and featured image
    // we need for the featured guides.
    $api = Api::get(config('prismic.url'), config('prismic.token'));
    $children = $api->query(
        [
            Predicates::at('document.type', 'page'),
            Predicates::at('my.page.parent', $document->id)
        ],
        [
            'lang' => $document->lang,
            'fetchLinks' => 'page.title'
        ]
    );

    $siblings = $api->query(
        [
            Predicates::at('document.type', 'page'),
            Predicates::at('my.page.parent', $document->data->parent->id),

            // should we include or exclude this document?
            Predicates::not('document.id', $document->id),
        ],
        [
            'lang' => $document->lang,
            'fetchLinks' => 'page.title'
        ]
    );
@endphp

<div class="main" id="a-child">
    <div class="container banner">
        <div class="banner__inner w-m">
            {!! RichText::asHtml($document->data->academy_category_header) !!}
            {!! RichText::asHtml($document->data->academy_category_description) !!}
        </div>
    </div>

    @include('components.academy.list', [
        'items' => $children->results
    ])

@if(count($children->results) == 0)
    @php
        return;
    @endphp
@endif
