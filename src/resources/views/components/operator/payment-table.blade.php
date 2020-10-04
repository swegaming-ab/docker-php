<table>
    <tr class="t-head">
        <th>{{ translate($translations, 'or__method', 'Method') }}</th>
        <th>{{ translate($translations, 'or__fee', 'Fee') }}</th>
        <th>{{ translate($translations, 'or__process_time', 'Process time') }}</th>
        @if(isset($detailed))
            <th class="desktop">min</th><th>max</th>
        @endif
    </tr>
    @foreach($details as $detail)
         @if($show === 'withdrawal' && isset($detail->withdrawal_fee) || $show === 'deposit' && isset($detail->deposit_fee))
            <tr>
                <td>
                    @if(isset($detail->method->data->logo->url))
                        <img src="{{ $detail->method->data->logo->url }}" alt="{{ $detail->method->data->logo->alt }}"/>
                    @else
                        <p>{{ $detail->method->slug }}</p>
                    @endif
                </td>
            @if($show === 'deposit')
                <td>{{ $detail->deposit_fee }}</td>
                <td>{{ $detail->deposit_process_time }}</td>
            @else
                <td>{{ $detail->withdrawal_fee }}</td>
                <td>{{ $detail->withdrawal_process_time }}</td>
            @endif
            </tr>
        @endif
    @endforeach
</table>
