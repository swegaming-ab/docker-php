@php
    use Prismic\Dom\RichText;
    $linkResolver = new App\LinkResolver();
@endphp

<div class="container banner">
    <div class="banner__inner w-m">
        {!! RichText::asHtml($data->primary->h1) !!}
        {!! RichText::asHtml($data->primary->header_text) !!}
    </div>
</div>


@include('components.quick-links', [
    'links' => $data->items
])
