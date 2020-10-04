@if(isset($image))
    @php
        $src = $image->url;
        if(isset($width)) {
            $src .= '&w=' . $width;
        }
    @endphp
    <image src="{{ $src }}" alt="{{ $image->alt }}" />
@elseif(isset($source) && isset($alt))
    <image src="{{ $source }}" alt="{{ $alt }}" />
@endif
