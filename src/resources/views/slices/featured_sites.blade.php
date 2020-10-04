@php
    use Prismic\Api;
    use Prismic\Dom\RichText;
    $linkResolver = new App\LinkResolver();
    $api = Api::get(config('prismic.url'), config('prismic.token'));

    // get the operators that we need.
    $operators = array();

    $ids = array();
    if(count($data->items) > 0) {
        foreach ($data->items as $item) {
            $ids[] = $item->fs_operator->id;
        }
        $operatorSearch = $api->getByIDs($ids);
        $operators = array_combine($ids, $operatorSearch->results);
    }
@endphp

<div class="container">
    <div class="container__inner w-m">
        <div class="container__inner-head">
            {!! RichText::asHtml($data->primary->fs_header, $linkResolver) !!}
        </div>
        <div class="container__inner-content">
            {!! RichText::asHtml($data->primary->fs_content_above, $linkResolver) !!}

            <ul class="betting-guide__list">
                @foreach($data->items as $item)
                    {{-- @component('components.ahref', ['href' => $linkResolver->resolve($item->fs_operator)]) --}}
                    <a href="{{$linkResolver->resolve($item->fs_operator)}}" style="background: {{$operators[$item->fs_operator->id]->data->operator_main_color}};">
                        <div class="img" style="background: {{$operators[$item->fs_operator->id]->data->operator_main_color}};">
                            @include('components.image', ['image' => $operators[$item->fs_operator->id]->data->operator_logo])
                        </div>
                        <div class="content">
                            {!! RichText::asHtml($item->fs_description, $linkResolver) !!}
                        </div>
                    </a>
                    {{-- @endcomponent --}}
                @endforeach
            </ul>
            {!! RichText::asHtml($data->primary->fs_content_below, $linkResolver) !!}
        </div>
    </div>
</div>
