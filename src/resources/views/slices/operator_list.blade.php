@php
    use Prismic\Api;
    use Prismic\Predicates;
    use Prismic\Dom\RichText;

    $linkResolver = new App\LinkResolver();
    $api = Api::get(config('prismic.url'), config('prismic.token'));

    // get the operators that we need.
    $operators = array();

    $ids = array();
    if(count($data->items) > 0) {
        foreach ($data->items as $item) {
            $ids[] = $item->ol_operator->id;
        }
        $operatorSearch = $api->getByIDs($ids);
        $operators = $operatorSearch->results;
    }

@endphp
{{-- @php dump($data) @endphp --}}
<div class="container op-list-main">
    <div class="container__inner w-m">
        <ul class="op-list">
            @foreach ($operators as $operator)
                <li class="list-item">
                    <div class="list-item__inner">
                        <div class="inner-wrap"  style="background: {{$operator->data->operator_main_color}}">
                            @component('components.ahref', ['href' =>  $linkResolver->resolve($operator)])
                                @include('components.image', ['image' => $operator->data->operator_logo])
                                <p><span>{{$operator->data->rating_overall}}</span> / 10</p>
                                <p>{{ translate($translations, 'ol__read_review', 'Read Review') }}</p>
                            @endcomponent
                        </div>
                        <div class="inner-wrap">
                            <h3>{{ $operator->data->title }}</h3>
                            <hr>
                            @foreach ($operator->data->betting_pros as $pros)
                                <div class="inner-wrap__wrapper">
                                    <i class="fas fa-smile"></i>
                                    <p>{{$pros->pro}}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="list-item__inner">
                        <span>{{ translate($translations, 'ol__welcome_offer', 'Welcome Offer') }}</span>
                        <h3>{{$operator->data->betting_bonus_string}}</h3>
                        <div class="inner-btns">
                            @component('components.ahref', [
                                'href' => redirect_link($operator),
                                'target' => '_blank',
                                'class' => 'cta-link'])
                                <button>{{ translate($translations, 'cta__operator_list', 'Claim') }}</button>
                            @endcomponent
                        </div>
                        <button @click="toggle('{{$operator->data->title}}')" type="button" name="button" class="extend">
                            <i v-if="show === '{{$operator->data->title}}'" class="fas fa-chevron-up"></i>
                            <i v-else class="fas fa-chevron-down"></i>
                        </button>
                    </div>

                    @if(isset($operator->data->betting_banner))
                        <div class="betting-banner">
                            {{$operator->data->betting_banner}}
                        </div>
                    @endif
                    {{-- <div class="list-item__bottom">
                        <div class="list-item__bottom-inner">
                            <span class="head">available sports</span>
                        </div>
                        <div class="list-item__bottom-inner">
                            <span class="head">payment methods ({{count($operator->data->payment_details)}})</span>
                            <ul>
                                @foreach($operator->data->payment_details as $item)
                                    <li>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div> --}}
                    <transition name="expand">
                        <div class="list-item__extended" v-if="show === '{{$operator->data->title}}'">
                            <h4>{{ translate($translations, 'ol__summary', 'Summary') }}</h4>
                            {!! RichText::asHtml($operator->data->summary) !!}
                            <hr>
                            @include('components.ahref', [
                                'href' => $linkResolver->resolve($operator),
                                'text' => translate($translations, 'ol__read_more', 'Read more'),
                                'title' => $operator->data->title
                            ])
                        </div>
                    </transition>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<script>
    new Vue({
        el: '.op-list',
        data: {
            show: ''
        },
        methods: {
            toggle: function(id){
                if(id === this.show){
                    this.show = '';
                }
                else {
                    this.show = id;
                }
            }
        }
    })
</script>
