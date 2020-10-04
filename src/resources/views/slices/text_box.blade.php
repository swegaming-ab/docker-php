@php
    use Prismic\Dom\RichText;
    use App\LinkResolver;

    $linkResolver = new LinkResolver();
    // dump($data)

@endphp

<div class="container text-box">
    <div class="container__inner w-m">
        <div class="container__inner-head">
            {!! RichText::asHtml($data->primary->tb_header, $linkResolver) !!}
        </div>
        <div class="container__inner-content">
            {!! RichText::asHtml($data->primary->tb_content, $linkResolver) !!}
        </div>
    </div>
</div>
