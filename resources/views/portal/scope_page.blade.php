@extends('layouts.portal')

@section('title')
    {{$scope['name']}}
@endsection

@section('content')
    <div class="sp_welcome">
        <x-ui.menu color="white"></x-ui.menu>
        <div class="image_blackout">
            <img src="{{$scope->getFirstMediaUrl('scope_page_pic')}}" alt="">
        </div>
        <h1>{{$scope['desc']}}</h1>
    </div>

    <div class="sp_cats_filter_wrap">
        @foreach($scope->category as $category)
            <a href="{{route('scope_page', $scope['id'])}}#category_{{$category['id']}}">
                <p>{{$category['name']}}</p>
            </a>
        @endforeach
    </div>

    @foreach($scope->category as $category)

        <div id="category_{{$category['id']}}" class="sp_cat_about_wrap">
            <div class="text_wrap">
                <div class="text">
                    <p>{{$scope['name']}}</p>
                    <h2> {{$category['block_title']}} </h2>
                    <div>
                        <p>{{$category['desc']}}</p>
                    </div>
                    <a href="#sp_services_block_{{$category['id']}}" class="link-bg coal">Записаться</a>
                </div>
            </div>
            <img src="{{$category->getFirstMediaUrl('main_pic') ?: config('cons.default_pic')}}" alt="">
        </div>

        @if(count($category->getMedia('category_examples')->pluck('original_url')->all()) > 0)
            <div class="sp_examples_wrap">
                <x-ui.gallery
                    title="ПРИМЕРЫ РАБОТ"
                    :photos="$category->getMedia('category_examples')->pluck('original_url')->all()">
                </x-ui.gallery>
            </div>
        @endif

        @if ($category['staff_ids'] ?? null && count($category['staff_ids']) > 0)
            <div class="content two_parts_block_wrap">
                <div class="left"></div>
                <div class="right">
                    <h2>Люди, которые любят свою работу</h2>
                    <p>
                        Запишитесь на эту услугу к любому из специалистов ниже. Чтобы познакомиться с мастером, увидеть
                        его
                        опыт и работы – нажмите на фото.
                    </p>
                    <div class="workers_wrap">
                        @foreach($category->staff as $staff_member)
                            <div class="worker">
                                <a href="{{route('staff_page', $staff_member['yc_id'])}}">
                                    <img src="{{$staff_member['yc_avatar']}}" alt="">
                                    <p-400>{{$staff_member['yc_name']}}</p-400>
                                    <p>{{$staff_member['yc_specialization']}}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if($loop->index == 0)
            <x-ui.advs-slider></x-ui.advs-slider>
        @endif

        <livewire:portal.components.service.category-services
            :category="$category"></livewire:portal.components.service.category-services>

        @if(collect($abonements)->where('category_id', $category['id'])->count() > 0)
            <x-ui.preview-cta
                title="абонементы на {{$category['name'] ?? 'услуги'}}"
                link="{{route('abonements_page')}}"
                :cards="$abonements">
            </x-ui.preview-cta>
        @endif

    @endforeach


    @if(count($scope['faqs'] ?? []) > 0)
        <livewire:portal.components.service.scope-faq
            :questions="$scope['faqs']"></livewire:portal.components.service.scope-faq>
    @endif

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


    <div class="content about_wrap">
        <div class="text">
            <p>КОНСУЛЬТАЦИЯ</p>
            <h2> Не опредилились с выбором? </h2>
            <div>
                <p>Получите бесплатную онлайн-консультацию от специалистов Tesler и подберите услугу, подходящую именно
                    вам
                </p>
            </div>
            <a modal-id="consult_modal" class="modal-link link-bg fern">Бесплатная консультация</a>
        </div>
        <div class="image_blackout">
            @if($scope['name'] == 'Подология')
                <img src="/media/media_fixed/need_consultation_подология.jpg" alt="">
            @elseif($scope['name'] == 'Перманент')
                <img src="/media/media_fixed/need_consultation_перманент.jpg" alt="">
            @elseif($scope['name'] == 'Брови Ресницы')
                <img src="/media/media_fixed/need_consultation_брови.jpg" alt="">
            @elseif($scope['name'] == 'Парикмахерские услуги')
                <img src="/media/media_fixed/need_consultation_парикмахерские.jpg" alt="">
            @elseif($scope['name'] == 'Косметология')
                <img src="/media/media_fixed/need_consultation_косметология.jpg" alt="">
            @elseif($scope['name'] == 'Ногтевой сервис')
                <img src="/media/media_fixed/need_consultation_ногтевой.jpg" alt="">
            @else
                <img src="/media/media_fixed/need_consultation.png" alt="">
            @endif
        </div>
    </div>


    @push('scripts')
        <script>
            $('.group_title_wrap').on('click', function () {

                id = $(this).attr('data-group-title')
                block = $('#services_in_group_' + id)
                if (block.is(":visible")) {
                    $(this).children('svg').css('transform', 'scale(-1, 1)')
                } else {
                    $(this).children('svg').css('transform', 'scale(1, -1)')
                }
                block.slideToggle()
            })
        </script>
    @endpush
@endsection
