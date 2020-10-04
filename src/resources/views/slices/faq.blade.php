@php
    use Prismic\Dom\RichText;
    use App\LinkResolver;

    $linkResolver = new LinkResolver();

@endphp
<div class="container faq">
    <div class="container__inner w-m">
        <div class="container__inner-head">
            {!! RichText::asHtml($data->primary->faq_header, $linkResolver) !!}
        </div>
        @foreach($data->items as $item)
            <div class="faq-inner qa flex as" @click="toggle({{$loop->iteration}})">
                <div class="faq-inner__question q flex">
                    <span class="p">{{$item->question}}</span>
                    <i v-if="included({{$loop->iteration}})" class="fas fa-chevron-up"></i>
                    <i v-else class="fas fa-chevron-down"></i>
                </div>
                <transition name="dropdown">
                    <div v-if="included({{$loop->iteration}})" class="{{$loop->iteration}} faq-inner__answer a">
                        <transition name="fade"><span v-if="included({{$loop->iteration}})">{!! RichText::asHtml($item->answer) !!}</span></transition>
                    </div>
                </transition>
            </div>
        @endforeach
    </div>
</div>

<script>
    new Vue({
        el: '.faq',
        data: {
            open: []
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
            }
        }
    })
</script>
