<li class="nav__list__item" :class="{subActive: sub === '{{ $menuId }}'}">
    <button @click="toggle('{{ $menuId }}')" type="button" name="button" class="nav__list__link" :class="{betActive: btnActive === '{{ $menuId }}'}">
        <span class="nav__item__menu-dropdown">{{ $menuText }}</span>
        <transition name="hamburger" mode="out-in">
            <i v-if="btnActive === '{{ $menuId }}'" class="fas fa-chevron-up" key="1"></i>
            <i v-if="btnActive !== '{{ $menuId }}'" class="fas fa-chevron-down" key="2"></i>
        </transition>
    </button>

    <transition name="nav">
        <div v-if="open" class="nav__list__item-open">
            <transition name="nav-left" mode="out-in">
            <div class="open__wrapper left" v-if="sub === '{{ $menuId }}'">
                <div @mouseover="hover = 'col1'" @mouseleave="hover = false" class="open__wrapper-wrap left" :class="[{hover: hover === 'col1'}, {hoverInactive: hover !== 'col1' && hover !== false}]">
                    @include('components.nav.menuitem-items', [
                        'header' => $leftHeader,
                        'items' => $leftItems
                    ])
                </div>

                <div @mouseover="hover = 'col2'" @mouseleave="hover = false" class="open__wrapper-wrap right" :class="[{hover: hover === 'col2'}, {hoverInactive: hover !== 'col2' && hover !== false}]">
                    @include('components.nav.menuitem-items', [
                        'header' => $rightHeader,
                        'items' => $rightItems
                    ])
                </div>
            </div>
            </transition>

            <div class="open__wrapper right">
                <transition name="featured" mode="out-in">
                    <div @mouseover="hover = 'col3'" @mouseleave="hover = false" class="open__wrapper-wrap" v-if="sub === '{{ $menuId }}'" :class="[{hover: hover === 'col3'}, {hoverInactive: hover !== 'col3' && hover !== false}]">
                        <span class="nav__item__column-header">
                            {{$featuredHeader}}
                        </span>
                        <hr>
                        @foreach($featuredPosts as $post)
                            @component('components.ahref', ['href' => $linkResolver->resolve($post->item), 'class' => 'featured-post'])
                                <div class="featured-post__img">
                                    @include('components.image', ['image' => $post->image, 'width' => '280'])
                                </div>

                                <div class="featured-post__content">
                                    <span class="header">{{$post->header}}</span>
                                    <span class="txt">{{$post->description}}</span>
                                    <span class="link">read more</span>
                                </div>
                            @endcomponent
                        @endforeach
                    </div>
                </transition>
            </div>
            <transition name="fade">
            <div class="open__block" v-if="sub === '{{ $menuId }}'">
                <div class="open__block-inner">
                    <transition name="fade">
                        <a v-if="sub === '{{ $menuId }}'" href="{{ $linkResolver->resolve($exploreLink) }}" title="{{ $exploreTitle }}">{{ $exploreText }}</a>
                    </transition>
                </div>
            </div>
            </transition>
        </div>
        </transition>
</li>
