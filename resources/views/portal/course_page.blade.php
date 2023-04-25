@extends('layouts.portal')

@section('title'){{$course['title']}}@endsection

@section('content')
    <x-ui.modal id="course_app_modal">
        @livewire('portal.course-app-modal', ['course_id' => $course->id])
    </x-ui.modal>

    <div class="course_page_wrap g_page_wrap">


        <div class="course_welcome_block">
            <x-ui.menu color="#111010"></x-ui.menu>
            <div class="content g_bread_wrap">
                <a href="{{route('home')}}" class="link coal">Главная</a> / <p>{{$course['type']}}</p>
            </div>
            <div class="content g_welcome_wrap">

                <div class="info">
                    <h2>{{$course['title']}}</h2>
                    <p>{{$course['desc_small']}}</p>
                    <a modal-id="course_app_modal" class="modal-link link-bg coal">Консультация</a>
                </div>

                <div class="examples_wrap">
                    <img id="main_example"
                         @if(is_null($course['pic']) || $course['pic'] == '')
                         src="/media/media_fixed/logo_holder.png"
                         @else src="/{{$course['pic']}}"
                         @endif
                         alt="">
                </div>

            </div>
        </div>


        @if($course['desc'])
            <div class="s_desc content two_parts_block_wrap">
                <div class="right">
                    <h2>О КУРСЕ</h2>
                    <p>{!! nl2br($course['desc']) !!}</p>
                </div>
            </div>
        @endif


        @if(count($course->getMedia('course_examples')->pluck('original_url')->all())>0)

            <div class="sp_examples_wrap">
                <x-ui.gallery
                    title="ПРИМЕРЫ РАБОТ"
                    :photos="$course->getMedia('course_examples')->pluck('original_url')->all()">
                </x-ui.gallery>
            </div>
        @endif

        <div class="content g_info_wrap">
            <div class="right">
                <div class="header_links_wrap">
                    <a href="#description" class="cont_nav_item current link coal">ПРОЦЕСС</a>
                    <a href="#usage" class="cont_nav_item link coal">ПРОГРАММА</a>
                    <a href="#consist" class="cont_nav_item link coal">ДАТЫ КУРСОВ</a>
                </div>
                <div style="transition: .3s ease-in-out" class="list-wrap">
                    <div id="description">
                        <h2>1200 учениц уже прошли обучение</h2>
                        <p class="desc">{!! nl2br($course['learning']) !!}</p>
                    </div>
                    <div id="usage" class="hide">
                        <p style="margin-top:20px;" class="desc">{!! nl2br($course['program']) !!}</p>
                    </div>
                    <div id="consist" class="hide"><p>{!! nl2br($course['dates']) !!}</p></div>
                </div>

            </div>
        </div>


        <div class="s_desc content two_parts_block_wrap">
            <div class="right">
                <a href="" class="link-bg coal">Записаться на обучение</a>
            </div>
        </div>


        <div class="s_desc two_parts_block_wrap only_image">
             <div class="right_img_wrap right">
                <img src="/media/media_fixed/course_page.png" alt="">
            </div>
        </div>

        <div class="faq_block_wrap s_desc content two_parts_block_wrap">
            <div class="right">
                <div class="faq_wrap">
                    <p class="title">ПОПУЛЯРНЫЕ ВОПРОСЫ</p>
                    <div class="question_wrap">
                        <p data-q-id="1" class="question">
                            ГДЕ ПРОХОДЯТ ЗАНЯТИЯ?
                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8.76948 0.00390625V8.00381H0.769531V10.0038H8.76948V18.0039H10.7695V10.0038H18.7695V8.00381H10.7695V0.00390625H8.76948Z"
                                    fill="#111010"/>
                            </svg>
                        </p>
                        <div style="display: none;" id="a_1" class="answer">
                            <p>
                                Групповые занятия проходят по адресу ул.Взлетная, д.7, офис 307. Индивидуальные уроки
                                проходят
                                по адресу ул.Авиаторов ,21
                            </p>
                        </div>
                    </div>
                    <div class="question_wrap">
                        <p data-q-id="2" class="question">
                            КТО ВЕДЕТ КУРСЫ?
                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8.76948 0.00390625V8.00381H0.769531V10.0038H8.76948V18.0039H10.7695V10.0038H18.7695V8.00381H10.7695V0.00390625H8.76948Z"
                                    fill="#111010"/>
                            </svg>
                        </p>
                        <div style="display: none;" id="a_2" class="answer">
                            <p>
                                Групповые занятия проходят по адресу ул.Взлетная, д.7, офис 307. Индивидуальные уроки
                                проходят
                                по адресу ул.Авиаторов ,21
                            </p>
                        </div>
                    </div>
                    <div class="question_wrap">
                        <p data-q-id="3" class="question">
                            МОЖНО ДЕЛАТЬ УСЛУГУ НЕСКОЛЬКО РАЗ В МЕСЯЦ?
                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8.76948 0.00390625V8.00381H0.769531V10.0038H8.76948V18.0039H10.7695V10.0038H18.7695V8.00381H10.7695V0.00390625H8.76948Z"
                                    fill="#111010"/>
                            </svg>
                        </p>
                        <div style="display: none;" id="a_3" class="answer">
                            <p>
                                Групповые занятия проходят по адресу ул.Взлетная, д.7, офис 307. Индивидуальные уроки
                                проходят
                                по адресу ул.Авиаторов ,21
                            </p>
                        </div>
                    </div>
                    <div class="question_wrap">
                        <p data-q-id="4" class="question">
                            АБОНЕМЕНТ К ОДНОМУ МАСТЕРУ?
                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8.76948 0.00390625V8.00381H0.769531V10.0038H8.76948V18.0039H10.7695V10.0038H18.7695V8.00381H10.7695V0.00390625H8.76948Z"
                                    fill="#111010"/>
                            </svg>
                        </p>
                        <div style="display: none;" id="a_4" class="answer">
                            <p>Групповые занятия проходят по адресу ул.Взлетная, д.7, офис 307. Индивидуальные уроки
                                проходят по
                                адресу ул.Авиаторов ,21
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @push('scripts')
            <script>
                $('.question').on('click', function () {

                    id = $(this).attr('data-q-id')
                    block = $('#a_' + id)
                    if (block.is(":visible")) {
                        $(this).children('svg').css('transform', 'rotate(0)')
                    } else {
                        $(this).children('svg').css('transform', 'rotate(45deg)')
                    }
                    block.slideToggle()
                })
            </script>
        @endpush


        <x-ui.selling-slider
            title="Другие курсы"
            :cards="$sim_courses">
        </x-ui.selling-slider>


        <x-ui.need_consultation/>

    </div>
@endsection
