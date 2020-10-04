@php
    use Prismic\Dom\RichText;

@endphp

<div class="container banner">
    <div class="banner__inner w-m">
        {!! RichText::asHtml($data->primary->hbp_h1) !!}
        {!! RichText::asHtml($data->primary->hbp_header_text) !!}
    </div>
</div>

<div class="info">
    <div class="info__inner">
        @foreach($data->items as $item)
        <div class="info__inner__wrap">
            <i class="{{$item->hbp_icon}}"></i>
            <span>{{$item->hbp_pointer}}</span>
        </div>
        @endforeach
    </div>
</div>
