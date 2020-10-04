@php

    use Prismic\Dom\RichText;
    use Prismic\Dom\Link;
    use App\LinkResolver;

    $seoTitle = $document->data->seo_title ?? "";
    $seoDescription = $document->data->seo_description ?? "";

@endphp

@extends('layouts.app')

@section('title', $seoTitle)
@section('description', $seoDescription)

@section('body')
    {{-- TODO includeFirst --}}
    @include('templates.' . $document->data->template, ['document' => $document])
@endsection
