@section('styles')
    <link rel="stylesheet" href="/plugins/slick/slick.css">
    {{--    <link rel="stylesheet" href="/plugins/slick/slick-theme.css">--}}
@endsection

<div class="content selling_slider_wrap">
    <div class="title_wrap">

        <p class="title">{{ $title }}</p>
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
    </div>


    <div class="slider">
        @foreach($cards as $card)
            <div class="card">
                <div class="image">
                    <img src="{{$card->getFirstMediaUrl('pic_main')}}" alt="">
                    <p>{{$card['type']}}</p>
                </div>
                <div class="text">
                    <div>
                        <p class="category">{{$card->category['name']}}</p>
                        <p>{{$card['name']}}</p>
                    </div>
                    <div class="buttons_wrap">
                        <a class="link fern"
                           onclick="Livewire.emit('service_cart_add', {{$card['id']}})"
                           id="service_add_bg_{{$card['id']}}">Добавить</a>
                        <p class="price">{{$card['yc_price_min']}} ₽</p>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
</div>

@push('scripts')
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
            // centerMode: true,
            slidesToScroll: 1,
            arrows: true,
            nextArrow: '.next_slider',
            prevArrow: '.previous_slider'
        });

    </script>
@endpush
