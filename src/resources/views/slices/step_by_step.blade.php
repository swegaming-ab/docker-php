@php
    use Prismic\Dom\RichText;
    $linkResolver = new App\LinkResolver();
@endphp
{{-- @php dump($data) @endphp --}}

<div class="container text-box">
    <div class="container__inner w-m">
        <div class="container__inner-head">
            {!! RichText::asHtml($data->primary->sbs_header) !!}
        </div>
        <div class="container__inner-content">
            {!! RichText::asHtml($data->primary->sbs_content) !!}
        </div>
        @foreach($data->items as $item)
            <div class="container__inner-content sbs">
                <div class="sbs__head">
                    <span>{{$loop->iteration}}</span>
                    {!! RichText::asHtml($item->sbs_step_header) !!}
                </div>
                {!! RichText::asHtml($item->sbs_step_content) !!}
            </div>
        @endforeach
    </div>
</div>
