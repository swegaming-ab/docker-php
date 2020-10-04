@php

    use App\Locale\Locale;
    use App\LinkResolver;
    use Prismic\Api;
    use Prismic\Predicates;

    // to get the urls of the documents
    // we need to link. Always use the LinkResolver
    // as that should be able to get all links so that
    // everything is correct.
    $linkResolver = new LinkResolver();

    $api = Api::get(config('prismic.url'), config('prismic.token'));
    $response = $api->query(
        [Predicates::at('document.type', 'navigation')],
        ['lang' => $document->lang, 'fetchLinks' => 'operator.rating_overall, operator.title, operator.operator_logo, operator.operator_main_color, operator.redirect_key']
    );
@endphp
<nav class="nav" :class="{navActive: navActive}">
        <div class="nav__group left">
            <div class="nav__list">
                @component('components.ahref', ['href' =>  '/', 'title' => 'Choose another market'])
                        @include('components.image', ['image' => $settings->market, 'width' => '50'])
                @endcomponent
                @component('components.ahref', ['href' =>  '/' . Locale::findLocaleOfDocument($document), 'title' => 'BettingGuide.com'])
                        @include('components.image', ['image' => $settings->logo, 'width' => '280'])
                @endcomponent
            </div>
        </div>

        <transition name="nav-group">
        <div v-if="group" class="nav__group right">
            <div class="nav__list">
                @if(count($response->results) > 0)
                    @php
                        // singular type, so if we have a result
                        // we should only have one navigation.
                        $navigation = $response->results[0];
                    @endphp

                @endif
                @if($navigation->data->menu1_enabled)
                    @include('components.nav.menuitem', [
                        'menuId' => 'menu1',
                        'menuText' => $navigation->data->menu1_text,
                        'leftHeader' => $navigation->data->menu1_left_header,
                        'leftItems' => $navigation->data->menu1_left,
                        'rightHeader' => $navigation->data->menu1_right_header,
                        'rightItems' => $navigation->data->menu1_right,
                        'exploreText' => $navigation->data->menu1_explore_text,
                        'exploreTitle' => $navigation->data->menu1_explore_title,
                        'exploreLink' => $navigation->data->menu1_explore_link,
                        'featuredPosts' => $navigation->data->menu1_featured_posts,
                        'featuredHeader' => $navigation->data->menu1_featured_posts_header
                    ])
                @endif

                @if($navigation->data->menu2_enabled)
                    @include('components.nav.menuitem', [
                        'menuId' => 'menu2',
                        'menuText' => $navigation->data->menu2_text,
                        'leftHeader' => $navigation->data->menu2_left_header,
                        'leftItems' => $navigation->data->menu2_left,
                        'rightHeader' => $navigation->data->menu2_right_header,
                        'rightItems' => $navigation->data->menu2_right,
                        'exploreText' => $navigation->data->menu2_explore_text,
                        'exploreTitle' => $navigation->data->menu2_explore_title,
                        'exploreLink' => $navigation->data->menu2_explore_link,
                        'featuredPosts' => $navigation->data->menu2_featured_posts,
                        'featuredHeader' => $navigation->data->menu2_featured_posts_header
                    ])
                @endif

                @if($navigation->data->more_items)
                    @foreach ($navigation->data->more_items as $item)
                        @if($item->text)
                            <li class="nav__list__item">
                                <a href="{{ $linkResolver->resolve($item->item)}}" title="{{ $item->title }}" class="nav__list__link">
                                    <span class="nav__item__menu-dropdown">{{ $item->text }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
        </transition>

    <div @click="toggle(sub)" class="mobile-shadow" v-if="mobile"></div>
    <transition name="fade"><div @click="toggle(sub)" v-if="open" class="nav__shadow"></div></transition>

    <transition name="hamburger" mode="out-in">
            <i v-if="!group" @click="group = true" class="fas fa-bars" key="1"></i>
            <i v-if="group" @click="group = false, open = false, sub = false, btnActive = false" class="fas fa-times" key="2"></i>
    </transition>
</nav>
<script>
    new Vue({
        el: '.nav',
        data: {
            open: false,
            sub: false,
            menu1: false,
            menu2: false,
            group: false,
            btnActive: false,
            mobile: false,
            mobileOpen: false,
            subOpen: '',
            featured: '',
            active: undefined,
            navActive: false,
            img: 1,
            hover: false
        },
        watch: {
            open: function(){
                {{-- if(!this.open){
                    document.body.style.overflow = "visible";
                }
                if(this.open){
                    document.body.style.overflow = "hidden";
                } --}}
            }
        },
        methods: {
            setActive(){
                if(this.img === 5){
                    this.img = 0;
                }
                this.img++;
            },
            toggle: function(val){
                var _this = this;
                this.btnActive = val;
                {{-- Opening nav menu and applying relevant Z-index class --}}
                if(!this.open && val){
                    this.open = true;
                    if(val === "menu1"){
                        _this.menu1 = true;
                    }
                    if(val === "menu2"){
                        _this.menu2 = true;
                    }
                    setTimeout(function () {
                        _this.sub = val;
                    }, 250);
                }
                {{-- Closing open nav menu --}}
                else if(this.open && this.sub === val || this.open && !val){
                    this.btnActive = false;
                    if(val === "menu1"){
                        this.menu2 = false;
                        this.sub = false;
                        setTimeout(function () {
                            _this.menu1 = false;
                            _this.open = false;
                        }, 250);
                    }
                    if(val === "menu2"){
                        this.menu1 = false;
                        this.sub = false;
                        setTimeout(function () {
                            _this.menu2 = false;
                            _this.open = false;
                        }, 250);
                    }
                }
                {{-- Swapping menu content --}}
                else if(this.open && this.sub !== val){
                    window.scrollTo(0,0);
                    this.sub = false;
                    if(val === "menu1"){
                        setTimeout(function () {
                            _this.menu2 = false;
                            _this.menu1 = true;
                            _this.sub = val;
                        }, 150);
                    }
                    if(val === "menu2"){
                        setTimeout(function () {
                            _this.menu1 = false;
                            _this.menu2 = true;
                            _this.sub = val;
                        }, 150);
                    }
                }
            },
            toggleMobile: function(){
                if(this.mobile){
                    this.mobile = false;
                    this.sub = false;
                    this.menu1 = false;
                    this.menu2 = false;
                    this.btnActive = false;
                }
                else {
                    this.mobile = true;
                }
            },
            handleResize() {
                if(window.innerWidth > 1000){
                    this.group = true;
                } else {
                    this.group = false;
                }
            },
            {{-- scroll: function(){
                if(window.pageYOffset >= 10 && this.open || window.pageYOffset >= 10 || this.open){
                    this.navActive = true;
                }
                else if (!this.open){
                    this.navActive = false;
                }
            } --}}
        },
        created() {
            window.addEventListener('resize', this.handleResize);
            {{-- window.addEventListener('scroll', this.scroll); --}}
        },
        destroyed() {
            window.removeEventListener('resize', this.handleResize);
            {{-- window.removeEventListener('scroll', this.scroll); --}}
        },
        beforeMount: function() {
            this.handleResize();
            {{-- this.scroll();  --}}
            {{-- Only for testing purposes --}}
            {{-- this.toggle('menu1');  --}}
        }
    });
</script>
