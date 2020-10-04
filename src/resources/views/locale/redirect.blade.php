@extends('layouts.redirect', ['url' => $document->data->redirect_url])
@section('body')
    <p>{{ translate($translations, 'r__text', 'You\'re being redirected.') }}</p>
@endsection
