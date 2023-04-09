<div class="gallery_wrap">

    <div class="gallery">
        @foreach($photos as $photo)
            <img src="{{$photo}}" alt="">
        @endforeach
    </div>
    <div class="desc">
        <p-400>{{$title}}</p-400>
        <div class="navigation">
            <button class="previous_gallery">
                <svg width="21" height="18" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10.0763 1.41422L3.8284 7.66209H20.4142V9.66209H3.8284L10.0763 15.9099L8.6621 17.3241L1.90735e-06 8.66209L8.6621 0L10.0763 1.41422Z"
                        fill="#111010"/>
                </svg>
            </button>
            <div class="pagingInfo_gallery"></div>
            <button class="next_gallery">
                <svg width="21" height="18" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10.3379 1.41422L16.5858 7.66209H0V9.66209H16.5858L10.3379 15.9099L11.7521 17.3241L20.4142 8.66209L11.7521 0L10.3379 1.41422Z"
                        fill="#111010"/>
                </svg>
            </button>
        </div>
    </div>

</div>

@push('scripts')
    <script defer>

        $('.gallery_wrap').each(function (key, item) {

            var sliderIdName = 'slider' + key;
            var sliderNavIdName = 'sliderNav' + key;

            this.id = sliderIdName;

            $(this).children('.desc').children('.navigation').children('.next_gallery').attr('id', 'next_gallery_' + key);
            $(this).children('.desc').children('.navigation').children('.previous_gallery').attr('id', 'previous_gallery_' + key);
            $(this).children('.gallery').not('.slick-initialized').slick({
                infinite: true,
                slidesToShow: 5,
                centerMode: true,
                slidesToScroll: 1,
                arrows: true,
                nextArrow: '#next_gallery_' + key,
                prevArrow: '#previous_gallery_' + key,
                responsive: [
                    {
                        breakpoint: 1300,
                        settings: {
                            slidesToShow: 4,
                        }
                    },
                    {
                        breakpoint: 1000,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 640,
                        settings: {
                            slidesToShow: 2,
                        }
                    }],
            });

        });


    </script>
@endpush
