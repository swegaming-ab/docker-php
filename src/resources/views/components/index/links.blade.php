@php

    use Prismic\Dom\RichText;

@endphp
@if(count($items) > 0 && isset($items[0]->text))
<div class="container">
    <div class="container__inner w-l">
        <div class="container__inner__head">
            <h2>{{ $header }}</h2>
        </div>
        <hr>
        <div class="container__inner-content">
            <ul class="rows-1__links-5">
                @foreach ($items as $item)
                    @if($item->text)
                        <li>
                            <a href="{{ $linkResolver->resolve($item->item)}}" title="{{ $item->title }}">
                                @include('components.image', ['image' => $item->image])
                                <span class="rows-1__links-5-text p">{{ $item->text }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <div class="container__block">
                <a class="explore-btn" href="{!! $linkResolver->resolve($exploreLink) !!}" title={{ $exploreTitle }}>{{ $exploreText }}</a>
            </div>
        </div>
    </div>
</div>
@endif
