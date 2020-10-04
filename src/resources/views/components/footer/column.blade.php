<span class="col-header">{{$navigation->data->footer_area1_header}}</span>
<ul>
    @foreach($links as $link)
        @if(isset($link->item->lang))
            <li>
                @component('components.ahref', ['href' => $linkResolver->resolve($link->item), 'title' => $link->title])
                    {{$link->text}}
                @endcomponent
            </li>
        @endif
    @endforeach
</ul>
