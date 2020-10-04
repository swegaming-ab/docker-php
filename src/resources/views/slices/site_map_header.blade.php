@php
    use Prismic\Dom\RichText;
@endphp
{{-- @php dump($data); @endphp --}}

<div class="container">
    <div class="container__inner w-m all-links">
        <div class="container__inner-head">
            {!! RichText::asHtml($data->primary->smh_header) !!}
        </div>
