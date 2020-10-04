<div class="container__inner-head">
    <h2>{{ $header }}</h2>
</div>
<div class="container__inner-content">
    <ul class="op-data__list">
        @foreach($list as $listItem)
            <li>
                <div>
                    <i class="{{ $listItem['icon'] ?? '' }}"></i>
                    <p>{{ $listItem['title'] }}</p>
                </div>
                <div>
                    @if($listItem['content'] === true)
                        <p>Yes</p>
                    @elseif($listItem['content'] === false)
                        <p>No</p>
                    @else
                        @if($listItem['link'])
                            <a href="{{$listItem['content']}}" target="_blank">{{$listItem['content']}}</a>
                        @else
                            <p>{{ $listItem['content'] }}</p>
                        @endif
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>
