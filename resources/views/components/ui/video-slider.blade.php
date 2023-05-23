<div>
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

    <div class="video_slider_wrap">
        <div class="title_wrap">
            <h1>Комфорт и сервис – </br> для нас базовые принципы</h1>
            <div class="navigation">
                <button class="previous_video_slider">
                    <svg width="21" height="18" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.0763 1.41422L3.8284 7.66209H20.4142V9.66209H3.8284L10.0763 15.9099L8.6621 17.3241L1.90735e-06 8.66209L8.6621 0L10.0763 1.41422Z"
                            fill="#111010"/>
                    </svg>
                </button>
                <div class="pagingInfo_video_slider"></div>
                <button class="next_video_slider">
                    <svg width="21" height="18" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.3379 1.41422L16.5858 7.66209H0V9.66209H16.5858L10.3379 15.9099L11.7521 17.3241L20.4142 8.66209L11.7521 0L10.3379 1.41422Z"
                            fill="#111010"/>
                    </svg>
                </button>
            </div>
        </div>



        <div class="video_slider">
                <div class="video_card card">
                    <div class="video">
                        <video controls>
                            <source src="/media/media_fixed/video_1.MOV" type="video/mp4">
                            Your browser does not support HTML video.
                        </video>
                    </div>
                    <div class="text">
                        <p class="title">У НАС БЕЗОПАСНО</p>
                        <p class="info">Каждый инструмент проходит трехэтапную дезинфекцию и стерилизацию и вскрывается только при вас.</p>
                    </div>
                </div>

            <div class="video_card card">
                <div class="video">
                    <video controls>
                        <source src="/media/media_fixed/video_2.MOV" type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                </div>
                <div class="text">
                    <p class="title">Индивидуальный подход</p>
                    <p class="info">Мы используем одноразовые пилки, палочки и бафы, которые вы сможете забрать с собой. И, конечно, внимательно прислушиваемся к вашим пожеланиям.</p>
                </div>
            </div>

            <div class="video_card card">
                <div class="video">
                    <video controls>
                        <source src="/media/media_fixed/video_3.MOV" type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                </div>
                <div class="text">
                    <p class="title">Качество и надёжность</p>
                    <p class="info">Используем только высококачественную технику и материалы, внимательно отбираем и тестируем каждый бренд.</p>
                </div>
            </div>

            <div class="video_card card">
                <div class="video">
                    <video controls>
                        <source src="/media/media_fixed/video_4.MOV" type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                </div>
                <div class="text">
                    <p class="title">С заботой</p>
                    <p class="info">Мы знаем, что счастье – в мелочах!
                        Поэтому делаем всё, чтобы вы провели время с удовольствием и в комфорте: вкусный кофе, удобные кресла, массажеры для ног, экспресс-услуги в 4 руки, фильмы для хорошего настроения и многое другое.</p>
                </div>
            </div>

            <div class="video_card card">
                <div class="video">
                    <video controls>
                        <source src="/media/media_fixed/video_5.MOV" type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                </div>
                <div class="text">
                    <p class="title">У НАС БЕЗОПАСНО</p>
                    <p class="info">Каждый инструмент проходит трехэтапную дезинфекцию и стерилизацию и вскрывается только при вас.</p>
                </div>
            </div>
            <div class="video_card card">
                <div class="video">
                    <video controls>
                        <source src="/media/media_fixed/video_6.MOV" type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                </div>
                <div class="text">
                    <p class="title">У НАС БЕЗОПАСНО</p>
                    <p class="info">Каждый инструмент проходит трехэтапную дезинфекцию и стерилизацию и вскрывается только при вас.</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            var $slickElement_video_slider = $('.video_slider');

            var $status_video_slider = $('.pagingInfo_video_slider');
            $slickElement_video_slider.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
                //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
                var i = (currentSlide ? currentSlide : 0) + 1;
                $status_video_slider.text(i + '/' + slick.slideCount);
            });

            $slickElement_video_slider.slick({
                infinite: true,
                slidesToShow: 5,
                touchThreshold: 100,
                lazyLoad: 'ondemand',
                responsive: [
                    // {
                    //     breakpoint: 1450,
                    //     settings: {
                    //         slidesToShow: 4,
                    //     }
                    // },
                    // {
                    //     breakpoint: 1000,
                    //     settings: {
                    //         slidesToShow: 3,
                    //     }
                    // },
                    //
                    // {
                    //     breakpoint: 750,
                    //     settings: {
                    //         slidesToShow: 2,
                    //     }
                    // },
                    //
                    // {
                    //     breakpoint: 500,
                    //     settings: {
                    //         slidesToShow: 1,
                    //     }
                    // }


                ],
                // centerMode: true,
                slidesToScroll: 1,
                arrows: true,
                nextArrow: '.next_video_slider',
                prevArrow: '.previous_video_slider'
            });

        </script>

    @endpush

</div>
