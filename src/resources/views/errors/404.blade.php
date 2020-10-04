@php
    use Prismic\Api;
    use Prismic\Predicates;

    $link = '/';
    $locale = null;
    $settingsData = (object)[];

    if($parameters = request()->route()->parameters) {
        if($locale = $parameters['locale']) {
            if(
                in_array($locale, array_keys(config('locales'))) &&
                config('locales.' .$locale. '.enabled')
            ) {
                $link .= $locale;
            }
            else {
                $locale = null;
            }
        }
    }

    if($locale) {

        // get setting post type
        $api = Api::get(config('prismic.url'), config('prismic.token'));
        $settings = $api->query(
            [Predicates::at('document.type', 'settings')],
            ['lang' => config('locales.' . $locale . '.prismic')]
        );

        if(count($settings->results) > 0) {
            $settingsData = $settings->results[0]->data;
        }
    }
@endphp

@extends('layouts.404')
@section('title', '404 | BettingGuide.com')
@section('body')
    <div class="container" id="err">
        <div class="col flex">
            <div class="content">
                @if(isset($settingsData->{'404_image'}) && isset($settingsData->{'404_image'}->url))
                    <img src="{{ $settingsData->{'404_image'}->url }}" class="err" alt="404 error" />
                @else
                    <img src="../../images/404.png" class="err" alt="404 error">
                @endif
                <h1 class="bold">{{ setting($settingsData, '404_header', 'Stay calm.') }}</h1>
                <h2>{{ setting($settingsData, '404_helper', 'Press the button below.') }}</h2>
            </div>
            <a href="{{ $link }}">{{ setting($settingsData, '404_button_text', 'Take me back.') }}</a>
        </div>
    </div>
@endsection
