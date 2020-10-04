{{-- TODO remove this template..??? --}}
@if($document->data->body1)
    <div class="slices">
        @include('slices.include', ['slices' => $document->data->body1])
    </div>
@endif
