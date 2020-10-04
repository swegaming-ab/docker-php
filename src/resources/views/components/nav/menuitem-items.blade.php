<span class="nav__item__column-header">{{ $header }}</span>
<hr>
<ul>
    @foreach ($items as $menuItem)
        @if($menuItem->text)
            <a href="{{ $linkResolver->resolve($menuItem->item) }}" title="{{ $menuItem->title }}">
                <div class="nav__item__header">
                    {{-- <img src="/icons/casino.png" alt=""> --}}
                    {{-- <i class="fas fa-atom"></i> --}}
                    <span>{{ $menuItem->text }}</span>
                </div>
                <span class="nav__item__summary">{{ $menuItem->description }}</span>
            </a>
        @endif
    @endforeach
</ul>
