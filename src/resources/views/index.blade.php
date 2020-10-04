@extends('layouts.langselector')

@section('title', 'Select your language | BettingGuide.com')
@section('description', 'Welcome to BettingGuide.com, the world\'s best guide to online gambling.')
@section('canonical', config('app.url'))
@section('hreflang', config('app.url'))

@section('body')
    <div class="container fl">
        <div class="flags">
            <div class="head">
                <span class="h3">Please select your market</span>
            </div>
            @foreach (config('locales') as $locale => $config)
                @if($config['enabled'])
                    <a href="/{{ $locale }}">
                        <img src="{{ $config['locale_selector']['img']['flag'] }}" class="flag" alt="{{ $config['country'] }}" />
                        <span class="h4">{{ $config['country'] }}</span>
                    </a>
                @endif
            @endforeach
            <div class="foot">
                <h1>Betting<span>Guide</span></h1>
            </div>
        </div>
    </div>
@endsection
