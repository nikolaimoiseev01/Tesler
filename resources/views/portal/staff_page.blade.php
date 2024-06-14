@extends('layouts.portal')

@section('title'){{$staff['yc_name']}}@endsection

@section('content')

    <div class="staff_welcome_block s_welcome_block">
        <x-ui.menu color="#111010"></x-ui.menu>
        <div class="content s_welcome_wrap">
            <div class="left">

                <div class="info">
                    <span class="yellow_info"><p>{{$staff['experience']}} опыта</p></span>
                    <p class="specialization">{{$staff['yc_specialization']}}</p>
                </div>
                <h2>{{$staff['yc_name']}}</h2>
                @if(Auth::check())
                    <a href="/admin/staff/{{$staff['id']}}/edit" class="link coal">Страница в Админке</a>
                @endif
                <p>{{$staff['desc_small']}}</p>

                <div class="buttons_wrap">
                    <div class="button_wrap">
                         @if($staff['yc_specialization'] !== 'Администратор')
                            <a target="_blank"
                               href="https://b253254.yclients.com/company/247576/menu?o=m{{$staff['yc_id']}}"
                               class="link-bg coal">Записаться</a>
                        @endif
                    </div>
                </div>
            </div>
            <img
                @if(is_null($staff['yc_avatar']) || $staff['yc_avatar'] == '')
                src="/media/media_fixed/holder_610x400.png"
                @else src="{{$staff['yc_avatar']}}"
                @endif
                alt="">
        </div>
    </div>

    @if($staff['desc'])
        <div class="s_desc content two_parts_block_wrap">
            <div class="left"></div>
            <div class="right">
                <h2>Описание</h2>
                <p>{{$staff['desc']}}</p>
            </div>
        </div>
    @endif


    @if(count($staff->getMedia('staff_examples')->pluck('original_url')->all()) > 0)
        <div class="sp_examples_wrap">
            <x-ui.gallery
                title="ПРИМЕРЫ РАБОТ"
                :photos="$staff->getMedia('staff_examples')->pluck('original_url')->all()">
            </x-ui.gallery>
        </div>
    @endif

    @if ($collegues)
        <div class="s_desc content two_parts_block_wrap">
            <div class="left"></div>
            <div class="right">
                <h2>Коллеги</h2>
                <p>
                    А также эту услугу предоставляет любой из специалистов ниже. Чтобы познакомиться с мастером, увидеть
                    его
                    опыт и работы — нажмите на фото.
                </p>

                <div style="margin-bottom: 20px;" class="workers_wrap">
                    @foreach($collegues as $colleague)
                        <div class="worker"><a href="{{route('staff_page', $colleague['yc_id'])}}">
                                <img src="{{$colleague['yc_avatar']}}" alt="">
                                <p-400>{{$colleague['yc_name']}}</p-400>
                                <p>{{$colleague['yc_specialization']}}</p>
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    @endif

    @if($selected_from_staff ?? null && count($selected_from_staff)>0)
        <x-ui.preview-cta
            title="Подборки от мастера"
            link="{{route('market_page')}}"
            :cards="$selected_from_staff"></x-ui.preview-cta>
    @endif

    <x-ui.need-consultation/>


@endsection
