@extends('layouts.portal')

@section('title'){{$service['name']}}@endsection

@section('content')

    <div class="s_welcome_block">
        <x-ui.menu color="#111010"></x-ui.menu>
        <div class="content s_welcome_wrap">
            <div class="left">
                @if($service['scope_id'] ?? null)
                    <div class="bread_wrap">
                        <a href="{{route('scope_page', $service['scope_id'])}}"
                           class="link coal">{{$service->scope['name']}}</a> /
                        <p>{{$service->group['name'] ?? "Доп. услуга"}}</p>
                    </div>
                @endif

                <h2>{{$service['name']}}</h2>

                <p>{{$service['desc_small']}}</p>

                <div class="buttons_wrap">
                    <div class="button_wrap">
                        <a target="_blank"
                           onclick="Livewire.emit('service_cart_add', {{$service['id']}})"
                           id="service_add_bg_{{$service['id']}}"
                           class="link-bg coal">Записаться</a>
                        <div class="info">
                            <span class="yellow_info"><p>{{$service['yc_duration'] / 60}} МИН</p></span>
                            <p class="price">{{$service['yc_price_min']}} ₽</p>
                        </div>

                    </div>
                </div>
            </div>
            <img
                @if(is_null($service->getFirstMediaUrl('pic_main')) || $service->getFirstMediaUrl('pic_main') == '')
                src="/media/media_fixed/logo_holder.png"
                @else src="{{$service->getFirstMediaUrl('pic_main')}}"
                @endif
                alt="">
        </div>
    </div>

    @if($service_adds && count($service_adds) > 0)
        <x-ui.selling-slider
            title="дополните процедуру и получите ещё больше удовольствия"
            :cards="$service_adds">
        </x-ui.selling-slider>
    @endif

    @if($service['desc'])
        <div class="s_desc content two_parts_block_wrap">
            <div class="left"></div>
            <div class="right">
                <h2>Описание</h2>
                <p>{{$service['desc']}}</p>
            </div>
        </div>
    @endif


    @if(count($service->getMedia('service_examples')->pluck('original_url')->all())>0)

        <div class="sp_examples_wrap">
            <x-ui.gallery
                title="ПРИМЕРЫ РАБОТ"
                :photos="$service->getMedia('service_examples')->pluck('original_url')->all()">
            </x-ui.gallery>
        </div>
    @endif


    @if($service['process'])

        <div class="s_desc content two_parts_block_wrap">
            <div class="left"></div>
            <div class="right">
                <h2>Процесс</h2>
                <p style="margin-bottom: 44px;">{{$service['proccess']}}</p>
                <a href="" class="link-bg coal">Записаться</a>
            </div>
        </div>
    @endif

    @if($service->getFirstMediaUrl('pic_proccess'))
        <div class="s_desc content two_parts_block_wrap only_image">
            <div class="left"></div>
            <div class="right_img_wrap right">
                <img src="{{$service->getFirstMediaUrl('pic_proccess')}}" alt="">
            </div>
        </div>
    @endif

    @if($service['result'])
        <div class="s_desc content two_parts_block_wrap">
            <div class="left"></div>
            <div class="right">
                <h2>Результат</h2>
                <p style="margin-bottom: 44px;">{{$service['result']}}</p>
            </div>
        </div>
    @endif

    {{--    {{$service_workers}}--}}
    @if ($service_workers ?? null !== null)
        <div class="s_desc content two_parts_block_wrap">
            <div class="left"></div>
            <div class="right">
                <h2>Специалисты услуги</h2>
                <p>
                    Запишитесь на эту услугу к любому из специалистов ниже. Чтобы познакомиться с мастером, увидеть его
                    опыт
                    и работы –нажмите на фото.
                </p>

                <div style="margin-bottom: 20px;" class="workers_wrap">
                    @foreach($service_workers as $worker)
                        <div class="worker">
                            <a href="{{route('staff_page', $worker['id'])}}">
                                <img src="{{$worker['avatar']}}" alt="">
                                <p-400>{{$worker['name']}}</p-400>
                                <p>{{$worker['specialization']}}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if($abonements)
        <x-ui.preview-cta
            title="абонементы на {{$service->group['name'] ?? 'услуги'}}"
            link="{{route('abonements_page')}}"
            :cards="$abonements">
        </x-ui.preview-cta>
    @endif

    <x-ui.need-consultation/>


@endsection
