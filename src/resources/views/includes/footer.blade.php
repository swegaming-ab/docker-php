@php

    use App\Locale\Locale;
    use Prismic\Api;
    use Prismic\Dom\RichText;
    use Prismic\Predicates;


    $linkResolver = new App\LinkResolver();

    $api = Api::get(config('prismic.url'), config('prismic.token'));
    $navigation = $api->query(
        [Predicates::at('document.type', 'navigation')],
        ['lang' => $document->lang]
    );
@endphp

@if(count($navigation->results) > 0)

    @php
        $navigation = $navigation->results[0];


        // @FIXME we can delete all this is was just for help if needed :)

        // From settings we'll get the logo, just as usual, otherwise
        // we'll get everything from the navigation

        // text/description/whatever that we'll display
        // under/close to the logo
        $navigation->data->footer_text;

        // Compliance items, could/should be images including links
        // The whole item could be empty, if we don't have any compliance
        // rules or so, so check if it contains anything before using it
        //
        // The items could include a link, but could also be empty. Check if
        // it has a link before trying to display it

        // The first area of items including header.
        $navigation->data->footer_area1_header;
        $navigation->data->footer_area1_items;

        // 2nd area
        $navigation->data->footer_area2_header;
        $navigation->data->footer_area2_items;

        // the "bottom" area, could include About us, Privacy policy etc.
        $navigation->data->footer_area_bottom_items;

        // copyright text
        $navigation->data->footer_copyright;

    @endphp

    <div class="container" id="footer">
        <div class="markets">
            <ul class="markets-inner">
                @foreach (config('locales') as $locale => $config)
                    @if($config['enabled'])
                        <li>
                            @component('components.ahref', ['href' =>  '/' . $locale, 'title' => $config['country']])
                                <img src="{{$config['locale_selector']['img']['flag']}}" alt="">
                            @endcomponent
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>


        <div class="cols">
            @if($settings->logo)
                @if(!$navigation->data->footer_area2_header)
                    <div class="col left single">
                @else
                    <div class="col left">
                @endif
                @component('components.ahref', ['href' =>  '/' . Locale::findLocaleOfDocument($document), 'title' => 'BettingGuide.com'])
                    @include('components.image', ['image' => $settings->logo, 'width' => '280'])
                @endcomponent
                @if($navigation->data->footer_text)
                    {!! RichText::asHtml($navigation->data->footer_text) !!}
                @endif
            </div>
            @endif

             @if($navigation->data->footer_area1_header)
                 <div class="col mid">
                     @include('components.footer.column', [
                         'header' => $navigation->data->footer_area1_header,
                         'links' => $navigation->data->footer_area1_items
                     ])
                 </div>
             @endif

             @if($navigation->data->footer_area2_header)
                 <div class="col right">
                     @include('components.footer.column', [
                         'header' => $navigation->data->footer_area2_header,
                         'links' => $navigation->data->footer_area2_items
                     ])
                 </div>
             @endif
        </div>

        <div class="privacy">
            @foreach($navigation->data->footer_compliance_items as $item)
                @if($item->title)
                    @component('components.ahref', ['href' => $linkResolver->resolve($item->link), 'title' => $item->title])
                        @include('components.image', ['image' => $item->image, 'width' => '280'])
                    @endcomponent
                @endif
            @endforeach
        </div>

        <div class="copy f-white flex">
            {!! RichText::asHtml($navigation->data->footer_copyright, $linkResolver) !!}
        </div>
        <transition name="foot">

        <div v-if="show" @click="totop" class="scrollTop flex bxs">
            <i class="fas fa-long-arrow-alt-up"></i>
        </div>
        </transition>
    </div>
    <script>
        new Vue({
            el: '#footer',
            data: {
                show: false
            },
            methods: {
                scroll: function(){
                    if(window.pageYOffset >= 10){
                        this.show = true;
                    }
                    else {
                        this.show = false;
                    }
                },
                totop: function(){
                    window.scroll({
                        top: 0,
                        left: 0,
                        behavior: 'smooth'
                    })
                }
            },
            created: function() {
                window.addEventListener('scroll', this.scroll);
            },
            destroyed: function() {
                window.removeEventListener('scroll', this.scroll);
            },
            beforeMount: function(){
                this.scroll();
            }
        })
    </script>
@endif
