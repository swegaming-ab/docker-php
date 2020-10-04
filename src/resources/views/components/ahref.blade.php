@php

    // TODO with helper functions or similar

    if(isset($href)) {
        $hrefHtml = 'href="' . $href . '"';
    }
    else {
        $hrefHtml = '';
    }

    if(isset($title)) {
        $titleHtml = 'title="' . $title . '"';
    }
    else if(isset($text)) {
        $titleHtml = 'title="' . $text . '"';
    }
    else {
        $titleHtml = '';
    }

    if(isset($class)) {
        $classHtml = 'class="' . $class . '"';
    }
    else {
        $classHtml = '';
    }

    if(isset($target)) {
        $targetHtml = 'target="' . $target .'"';
    }
    else {
        $targetHtml = '';
    }

    if(isset($style)) {
        $styleHtml = 'style="' . $style .'"';
    }
    else {
        $styleHtml = '';
    }

@endphp
<a {!! $hrefHtml !!} {!! $titleHtml !!} {!! $classHtml !!} {!! $targetHtml !!} {!! $styleHtml !!}>
    @if(isset($slot))
        {{ $slot }}
    @else
        {{ $text }}
    @endif
</a>
