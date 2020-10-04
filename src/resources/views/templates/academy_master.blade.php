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
    $academyCategories = $api->query(
        [
            Predicates::at('document.type', 'page'),
            Predicates::at('my.page.parent', $document->id)
        ],
        [
            'lang' => $document->lang,
            'fetchLinks' => 'page.title, page.academy_guide_image, page.academy_guide_short_description'
        ]
    );
@endphp

<div class="main academy">
    @if(count($academyCategories->results) == 0)
        @php
            // make sure that we have academy categories
            // otherwise we just return here and return blank
            return;
        @endphp
    @endif
    <div class="container banner">
        <div class="banner__inner w-m">
            {!! RichText::asHtml($document->data->academy_master_header) !!}
            {!! RichText::asHtml($document->data->academy_master_description) !!}
        </div>
    </div>

    @php
        // TODO Recieved data here differs from quick-links for /index and /betting. Wait for solution or keep as is?
     @endphp
    {{-- @include('components.quick-links', [
        'links' => $academyCategories->results
    ]) --}}

    <div class="container hql">
        <div class="container__inner w-m">
            <ul class="quick-links__list">
                @foreach ($academyCategories->results as $category)
                    @component('components.ahref', ['href' => $linkResolver->resolve($category), 'title' => $category->data->title])
                        @include('components.image', ['image' => $category->data->academy_category_icon])
                        @include('components.image', ['image' => $category->data->academy_category_icon])
                        <span class="quick-links__text">{{ $category->data->title }}</span>
                    @endcomponent
                @endforeach
            </ul>
        </div>
    </div>

{{-- body --}}

    @foreach ($academyCategories->results as $category)
        @include('components.academy.list', [
            'header' => $category->data->title,
            'items' => $category->data->academy_category_featured_guides
        ])
    @endforeach
</div>
