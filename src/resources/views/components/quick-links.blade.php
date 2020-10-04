@php
    // TODO /betting provides link title with key: title1, should be title?
@endphp

<div class="container hql">
    <div class="container__inner w-m">
        <ul class="quick-links__list">
            @foreach ($links as $link)
                <a href="{{ $linkResolver->resolve($link->item) }}" title="{{ $link->title1 ?? $link->title }}">
                    @include('components.image', ['image' => $link->icon] )
                    @if(isset($link->icon_hover->url))
                        @include('components.image', ['image' => $link->icon_hover] )
                    @else
                        @include('components.image', ['image' => $link->icon] )
                    @endif

                    <span class="quick-links__text">{{ $link->text }}</span>
                </a>
            @endforeach
        </ul>
    </div>
</div>
