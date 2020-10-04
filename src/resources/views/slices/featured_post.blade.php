@php
    use Prismic\Dom\RichText;
    $linkResolver = new App\LinkResolver();

@endphp

<div class="container text-box">
    <div class="container__inner w-m">
        <div class="container__inner-head">
            {!! RichText::asHtml($data->primary->fp_header) !!}
        </div>
        <div class="container__inner-content">
            {!! RichText::asHtml($data->primary->fp_content) !!}
            @include('components.image', ['image' => $data->primary->fp_image])
            <div class="container__block">
                @include('components.ahref', ['href' => $linkResolver->resolve($data->primary->fp_link), 'text' => $data->primary->fp_link_text, 'class' => 'explore-btn', 'title' => $data->primary->fp_link_title])
            </div>
        </div>
    </div>
</div>
