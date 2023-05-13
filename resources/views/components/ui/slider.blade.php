@section('styles')
    <link rel="stylesheet" href="/plugins/slick/slick.css">
    {{--    <link rel="stylesheet" href="/plugins/slick/slick-theme.css">--}}
    <style>
        .slick-disabled {
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
@endsection

<div class="slider_wrap">
    <h1>{{ $title }}</h1>
    <div class="navigation">
        <button class="previous_slider">
            <svg width="21" height="18" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M10.0763 1.41422L3.8284 7.66209H20.4142V9.66209H3.8284L10.0763 15.9099L8.6621 17.3241L1.90735e-06 8.66209L8.6621 0L10.0763 1.41422Z"
                    fill="#111010"/>
            </svg>
        </button>
        <div class="pagingInfo_slider"></div>
        <button class="next_slider">
            <svg width="21" height="18" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M10.3379 1.41422L16.5858 7.66209H0V9.66209H16.5858L10.3379 15.9099L11.7521 17.3241L20.4142 8.66209L11.7521 0L10.3379 1.41422Z"
                    fill="#111010"/>
            </svg>
        </button>
    </div>


    <div class="slider">
        @foreach($cards as $card)
            <div class="card">
                <div class="image">
                    <img src="{{$card->getFirstMediaUrl('promo_pics')}}" alt="">
                    <p>{{$card['type']}}</p>
                </div>
                <div x-data="{ open_{{$card['id']}}: false }" class="text">
                    <div>
                        <p>{{$card['title']}}</p>

                        <p>
                           <span x-show="!open_{{$card['id']}}">{{Str::limit($card['desc'], 90, '')}}</span>
                            @if (Str::length($card['desc']) > 90)
                                <span x-show="open_{{$card['id']}}">{{ $card['desc'] }}</span>
                                <a class="dots" @click="open_{{$card['id']}} = !open_{{$card['id']}}">...</a>
                            @endif
                        </p>
                    </div>

                    <a href="{{$card['link']}}" class="link fern">{{$card['link_text']}}</a>
                </div>

            </div>
        @endforeach
    </div>
</div>

@push('scripts')
    <script>

    </script>

    <script>
        var $slickElement_slider = $('.slider');

        var $status_slider = $('.pagingInfo_slider');
        $slickElement_slider.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
            //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
            var i = (currentSlide ? currentSlide : 0) + 1;
            $status_slider.text(i + '/' + slick.slideCount);
        });

        $slickElement_slider.slick({
            infinite: true,
            slidesToShow: 4,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 5,
                        infinite: true,
                    }
                },
                // {
                //     breakpoint: 480,
                //     settings: {
                //         slidesToShow: 6,
                //         infinite: true,
                //     }
                // }
            ],
            // centerMode: true,
            slidesToScroll: 1,
            arrows: true,
            nextArrow: '.next_slider',
            prevArrow: '.previous_slider'
        });

    </script>

@endpush
