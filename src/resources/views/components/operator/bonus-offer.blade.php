<div class="container__inner-wrap">    
    <h3>{{ $type }}</h3>
    <h2>{{ $string }}</h2>
    <h4>{{ $header }}</h4>
    @foreach ($guideList as $item)
        <li class="flex">
            <i class="fas fa-dice-d20"></i>
            <p>{{$item->step}}</p>
        </li>
    @endforeach
    <div class="col">
        <h5>{{ translate($translations, 'or__quick_info', 'Quick info') }}</h5>
        <table>
            <tr><td class="m">{{ translate($translations, 'or__turnover', 'turnover') }}</td><td>{{$turnover}}</td></tr>
            <tr><td class="m">{{ translate($translations, 'or__min_odds', 'min. odds') }}</td><td>{{$minOdds}}</td></tr>
            <tr><td class="m">{{ translate($translations, 'or__max_amount', 'max. amount') }}</td><td>{{$maxAmount}}</td></tr>
            <tr><td class="m">{{ translate($translations, 'or__min_deposit', 'min. deposit') }}</td><td>{{$minDeposit}}</td></tr>
            <tr><td class="m">{{ translate($translations, 'or__expiration', 'expiration') }}</td><td>{{$expirationTime}}</td></tr>
        </table>
    </div>
    <div class="btn-container">
        @component('components.ahref', [
            'href' => redirect_link($document),
            'target' => '_blank',
            'class' => 'cta-link'])
            {{ translate($translations, 'cta__operator_review', 'Claim Bonus') }}
        @endcomponent
    </div>
</div>
