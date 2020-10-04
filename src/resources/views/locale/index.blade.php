@php

    use Prismic\Dom\RichText;
    $linkResolver = new  App\LinkResolver();

    $seoTitle = $document->data->seo_title ?? "";
    $seoDescription = $document->data->seo_description ?? "";

@endphp

@extends('layouts.app')

@section('title', $seoTitle)
@section('description', $seoDescription)

@section('body')
    <div class="main index">
        <div class="container banner">
            <div class="banner__inner w-l">
                {!! RichText::asHtml($document->data->h1) !!}
                {!! RichText::asHtml($document->data->header_text) !!}
            </div>
        </div>

        @include('components.quick-links', [
            'links' => $document->data->header_links
        ])

        @include('components.index.links', [
            'header' => $document->data->links1_header,
            'items' => $document->data->links1_items,
            'exploreText' => $document->data->links1_explore_text,
            'exploreTitle' => $document->data->links1_explore_title,
            'exploreLink' => $document->data->links1_explore_link,
        ])

        @include('components.index.links', [
            'header' => $document->data->links2_header,
            'items' => $document->data->links2_items,
            'exploreText' => $document->data->links2_explore_text,
            'exploreTitle' => $document->data->links2_explore_title,
            'exploreLink' => $document->data->links2_explore_link,
        ])

        <div class="container text-box">
            <div class="container__inner w-l">
                <div class="container__inner-head">
                    {!! RichText::asHtml($document->data->featured_post_header) !!}
                </div>
                <div class="container__inner-content">
                    {!! RichText::asHtml($document->data->featured_post_description, $linkResolver) !!}
                    @include('components.image', ['image' => $document->data->featured_post_image])
                    <div class="container__block">
                        <a class="explore-btn" href="{{ $linkResolver->resolve($document->data->featured_post_link) }}" title="{{ $document->data->featured_post_link_text }}">
                            {{ $document->data->featured_post_link_text }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
