@if(!empty($slices))
    @foreach ($slices as $slice)
        @include('slices.' . $slice->slice_type, ['data' => $slice])
    @endforeach
@endif
