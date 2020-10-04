@php
    use Prismic\Dom\RichText;
    $linkResolver = new App\LinkResolver();

@endphp
    <div class="container__inner-content">
        <div class="all-links__inner">
            {!! RichText::asHtml($data->primary->sms_header) !!}
        </div>
        <div class="all-links__inner">
            <ul>
                @foreach($data->items as $item)
                    {{-- @php dump($item) @endphp --}}
                    @include('components.ahref', ['href' => $linkResolver->resolve($item->sms_link), 'text' => $item->sms_text, 'title' => $item->sms_title])
                @endforeach
            </ul>
        </div>
    </div>
    <hr>
