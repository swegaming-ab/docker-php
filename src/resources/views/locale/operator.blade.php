@php

    use App\LinkResolver;
    use Prismic\Dom\RichText;
    use Prismic\Dom\Link;

    $linkResolver = new LinkResolver();
    $seoTitle = $document->data->seo_title ?? "";
    $seoDescription = $document->data->seo_description ?? "";

    $steps = $document->data->getting_started;

@endphp

@extends('layouts.app')

@section('title', $seoTitle)
@section('description', $seoDescription)


@section('body')
    <div class="main op">
        <div class="container banner">
            @if(isset($document->data->operator_main_color))
                <div class="banner__overlay" style="background: {{$document->data->operator_main_color}}"></div>
            @else
                <div class="banner__overlay" style="background: #333"></div>
            @endif
            <div class="banner__inner w-m">
                @if(isset($document->data->operator_logo->url))
                    <img src="{{ $document->data->operator_logo->url }}" alt="{{ $document->data->operator_logo->alt }}" class="bimg" />
                @endif
            </div>
        </div>

        <div class="container-sticky" id="sticky">
            <div @click="sticky =! sticky" class="i">
                <i v-if="!sticky" class="fas fa-chevron-down"></i>
                <i v-if="sticky" class="fas fa-chevron-up"></i>
            </div>
            <ul v-if="sticky" class="flex">
                <Scrollactive
                ref="scrollactive"
                class="flex"
                active-class="stickyActive"
                :offset="200"
                :duration="800"
                bezier-easing-value=".5,0,.35,1"
                :modify-url=false
                >
                    <li><a href="#bonus" class="scrollactive-item flex">{{ translate($translations, 'or__sticky_bonus', 'Sign up Bonus') }}</a></li>
                    <li><a href="#payment" class="scrollactive-item flex">{{ translate($translations, 'or__sticky_payment', 'Payment') }}</a></li>
                    <li><a href="#service" class="scrollactive-item flex">{{ translate($translations, 'or__sticky_customer_service', 'Customer Service') }}</a></li>
                    <li><a href="#information" class="scrollactive-item flex">{{ translate($translations, 'or__sticky_information', 'Information') }}</a></li>
                    <li><a href="#score" class="scrollactive-item flex">{{ translate($translations, 'or__sticky_score', 'Score') }}</a></li>
                    <li><a href="#guide" class="scrollactive-item flex">{{ translate($translations, 'or__sticky_get_started', 'Get started') }}</a></li>
                    <li><a href="#faq" class="scrollactive-item flex">{{ translate($translations, 'or__sticky_faq', 'FAQ') }}</a></li>
                </Scrollactive>
            </ul>
        </div>

        <div class="container hql" id="bonus">
            <div class="container__inner">
                @if(isset($document->data->betting_bonus_string))
                    @include('components.operator.bonus-offer', [
                        'type' => translate($translations, 'or__betting_bonus', 'Betting Bonus'),
                        'string' => $document->data->betting_bonus_string,
                        'header' => $document->data->betting_bonus_guide_header,
                        'guideList' => $document->data->betting_bonus_guide_content,
                        'turnover' => $document->data->betting_bonus_details_turnover,
                        'minOdds' => $document->data->betting_bonus_details_min_odds,
                        'maxAmount' => $document->data->betting_bonus_details_max_amount,
                        'minDeposit' => $document->data->betting_bonus_details_min_deposit,
                        'expirationTime' => $document->data->betting_bonus_details_expiration_time,
                        // 'bonusDetails' => [
                        //     'turnover' => $document->data->betting_bonus_details_turnover,
                        //     'minOdds' => $document->data->betting_bonus_details_min_odds,
                        //     'maxAmount' => $document->data->betting_bonus_details_max_amount,
                        //     'minDeposit' => $document->data->betting_bonus_details_min_deposit,
                        //     'expirationTime' => $document->data->betting_bonus_details_expiration_time,
                        // ]
                    ])
                @endif

                @if(isset($document->data->casino_bonus_string))
                    @include('components.operator.bonus-offer', [
                        'type' => translate($translations, 'or__casino_bonus', 'Casino Bonus'),
                        'string' => $document->data->casino_bonus_string,
                        'header' => $document->data->casino_bonus_guide_header,
                        'guideList' => $document->data->casino_bonus_guide_content,
                        'turnover' => $document->data->casino_bonus_details_turnover,
                        'minOdds' => $document->data->casino_bonus_details_min_odds,
                        'maxAmount' => $document->data->casino_bonus_details_max_amount,
                        'minDeposit' => $document->data->casino_bonus_details_min_deposit,
                        'expirationTime' => $document->data->casino_bonus_details_expiration_time,
                    ])
                @endif
            </div>
        </div>

        <div class="container" id="payment">
            <div class="container__inner w-l">
                <div class="container__inner-head func">
                    <h2 @click="active = 'with'" v-bind:class="{disabled: active === 'dep'}">{{ translate($translations, 'or__withdrawal', 'Withdrawal') }}</h2>
                    <h2 @click="active = 'dep'" v-bind:class="{disabled: active === 'with'}">{{ translate($translations, 'or__deposit', 'Deposit') }}</h2>
                </div>
                <div class="table__container">
                    <div class="table-vue" :class="[{tabActive: active === 'with'}, {inactive: active === 'dep'}]">
                        @include('components.operator.payment-table', [
                            'show' => 'withdrawal',
                            'details' => $document->data->payment_details
                        ])
                    </div>

                    <div class="table-vue" :class="[{tabActive: active === 'dep'}, {inactive: active === 'with'}]">
                        @include('components.operator.payment-table', [
                            'show' => 'deposit',
                            'details' => $document->data->payment_details
                        ])
                    </div>
                </div>
            </div>
        </div>

        <div class="container" id="service">
            <div class="container__inner w-m">
                @include('components.operator.op-data-list', [
                    'header' => translate($translations, 'or__customer_service', 'Customer Service'),
                    'list' => [
                        [
                            'title' =>  translate($translations, 'or__chat', 'Chat'),
                            'content' => $document->data->customer_service_has_live_chat,
                            'icon' => 'fas fa-comments',
                            'link' => false
                        ],
                        [
                            'title' => translate($translations, 'or__email', 'Email'),
                            'content' => $document->data->customer_service_email,
                            'icon' => 'fas fa-envelope',
                            'link' => false
                        ],
                        [
                            'title' => translate($translations, 'or__phone', 'Phone'),
                            'content' => $document->data->customer_service_phone_number,
                            'icon' => 'fas fa-phone',
                            'link' => false
                        ],
                        [
                            'title' => translate($translations, 'or__open', 'Open'),
                            'content' => $document->data->customer_service_opening_hours[0]->hours, $document->data->customer_service_opening_hours[0]->day,
                            'icon' => 'fas fa-user',
                            'link' => false
                        ],
                    ]
                ])
            </div>
            <div class="container__inner w-m" id="information">
                @include('components.operator.op-data-list', [
                    'header' => translate($translations, 'or__information', 'Information'),
                    'list' => [
                        [
                            'title' =>  translate($translations, 'or__products', 'Products'),
                            'content' => $document->data->products,
                            'icon' => 'fas fa-sitemap',
                            'link' => false
                        ],
                        [
                            'title' =>  translate($translations, 'or__license', 'License'),
                            'content' => $document->data->license,
                            'icon' => 'fas fa-id-badge',
                            'link' => false
                        ],
                        [
                            'title' =>  translate($translations, 'or__founded', 'Founded'),
                            'content' => $document->data->year_founded,
                            'icon' => 'fas fa-warehouse',
                            'link' => false
                        ],
                        [
                            'title' =>  translate($translations, 'or__webiste', 'Website'),
                            'content' => $document->data->website_url,
                            'icon' => 'fab fa-chrome',
                            'link' => true
                        ]
                    ]
                ])
            </div>

        <div class="container" id="score">
            <div class="container__inner w-m">
                <div class="container__inner-head">
                    <h2>{{ translate($translations, 'or__our_score', 'Our Score') }}</h2>
                </div>
                <div class="container__inner-content">
                    <ul class="op-score__list">
                        @include('components.operator.score', ['header' => translate($translations, 'or__score_bonus', 'Sign Up Bonus'), 'score' => $document->data->rating_bonus])
                        @include('components.operator.score', ['header' => translate($translations, 'or__customer_service', 'Customer Service'), 'score' => $document->data->rating_customer_support])
                        @include('components.operator.score', ['header' => translate($translations, 'or__score_payment', 'Payment Methods'), 'score' => $document->data->rating_payment_methods])
                        @include('components.operator.score', ['header' => translate($translations, 'or__score_licensing', 'Licensing & Safety'), 'score' => $document->data->rating_licensing_safety])
                        @include('components.operator.score', ['header' => translate($translations, 'or__score_usabilitiy', 'Design & Usability'), 'score' => $document->data->rating_usability])
                        @include('components.operator.score', ['header' => translate($translations, 'or__score_overall', 'Overall Score'), 'score' => $document->data->rating_overall, 'class' => 'overall'])
                    </ul>
                </div>
            </div>
        </div>

        <div class="container text-box" id="guide">
            <div class="container__inner w-m">
                <div class="container__inner-head">
                    {!! RichText::asHtml($document->data->getting_started_header) !!}
                </div>
                <div class="container__inner-content">
                    @foreach($document->data->getting_started as $step)
                        <span>
                            <h3>#{{$step->step}}: {{$step->header}}</h3>
                            {!! RichText::asHtml($step->description) !!}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="container faq" id="faq">
            <div class="container__inner w-m">
                <div class="container__inner-head">
                    {!! RichText::asHtml($document->data->faq_header) !!}
                </div>
                @foreach($document->data->faq as $item)
                    <div class="faq-inner qa flex as" @click="toggle({{$loop->iteration}})">
                        <div class="faq-inner__question q flex">
                            <span class="p">{{$item->question}}</span>
                            <i v-if="included({{$loop->iteration}})" class="fas fa-chevron-up"></i>
                            <i v-else class="fas fa-chevron-down"></i>
                        </div>
                        <transition name="dropdown">
                            <div v-if="included({{$loop->iteration}})" class="{{$loop->iteration}} faq-inner__answer a">
                                <p>{{$item->answer}}</p>
                            </div>
                        </transition>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
    <script>
        new Vue({
            el: '.op',
            data: {
                show: false,
                disabled: 'with',
                active: 'with',
                open: [],
                sticky: false
            },
            methods: {
                toggle: function(id){
                    if(this.included(id)){
                        this.open.splice(this.open.indexOf(id), 1);
                    } else {
                        this.open.push(id);
                    }
                },
                included: function(value){
                    var pos = this.open.indexOf(value);
                    if (pos >= 0) {
                        return true;
                    } else {
                        return false;
                    }
                },
                handleResize() {
                    if(window.innerWidth > 1000){
                        this.sticky = true;
                    } else {
                        this.sticky = false;
                    }
                }
            },
            created: function() {
                window.addEventListener('resize', this.handleResize);
            },
            destroyed: function() {
                window.removeEventListener('resize', this.handleResize);
            },
            beforeMount: function(){
                this.handleResize();
            }
        })
    </script>
@endsection
