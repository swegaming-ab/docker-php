@php

    use App\LinkResolver;
    use Prismic\Api;
    use Prismic\Predicates;
    use Prismic\Dom\RichText;

@endphp

<div class="container">
    <div class="container__inner w-m">
        @if(isset($header))
            <div class="container__inner-head">
                <h2>{{ $header }}</h2>
            </div>
        @endif
        <div class="container__inner-content">
            <ul class="rows-1__links-3">
                @foreach ($items as $guide)

                    @if(isset($guide->guide) && isset($guide->guide->data))

                        @php

                        // get some data from the document
                        $guideData = $guide->guide->data;
                        $title = $guideData->title;
                        $shortDescription = $guideData->academy_guide_short_description ?? [];
                        $url = $linkResolver->resolve($guide->guide);
                        // set to null if it doesnt exists. Otherwise
                        // set image to the featured image set in the document.
                        // include(components.image) will return blank if image
                        // is nul
                        $image = $guideData->academy_guide_image ?? null;

                        @endphp
                        <li>
                            @if(isset($guide->guide->data->academy_guide_image->url))
                                <div class="content-img" style="background: url('{{$guide->guide->data->academy_guide_image->url}}')">
                                @else
                                    <div class="content-img" style="background: url('')">
                                    @endif
                                </div>
                                <div class="content">
                                    <h4>{{ $title }}</h4>
                                    {!! RichText::asHtml($shortDescription, $linkResolver) !!}
                                </div>
                                <div class="link">
                                    @include('components.ahref', ['href' => $url, 'text' => 'Read more', 'title' => $title])
                                </div>
                            </li>

                        @elseif(isset($guide))
                            @php
                                $url = $linkResolver->resolve($guide);
                                $title = $guide->data->title;

                            @endphp
                            <li>
                                @if(isset($guide->data->academy_guide_image->url))
                                    <div class="content-img" style="background: url('{{$guide->data->academy_guide_image->url}}')">
                                    @else
                                        <div class="content-img" style="background: url('')">
                                        @endif
                                    </div>
                                    <div class="content">
                                        <h4>{{ $title }}</h4>
                                        {!! RichText::asHtml($guide->data->academy_guide_short_description, $linkResolver) !!}
                                    </div>
                                    <div class="link">
                                        @include('components.ahref', ['href' => $url, 'text' => 'Read more', 'title' => $title])
                                    </div>
                                </li>

                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
