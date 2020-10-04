@php
    use Prismic\Dom\RichText;

@endphp

<div class="container banner">
    <div class="banner__inner w-m">        
        {!! RichText::asHtml($data->primary->hbs_h1) !!}
        {!! RichText::asHtml($data->primary->hbs_header_text) !!}
    </div>
</div>
