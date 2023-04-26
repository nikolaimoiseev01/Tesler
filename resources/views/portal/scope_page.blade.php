@extends('layouts.portal')

@section('title'){{$scope['name']}}@endsection

@section('content')
    <div class="sp_welcome">
        <x-ui.menu color="white"></x-ui.menu>
        <div class="image_blackout">
            <img src="/{{$scope['pic_scope_page']}}" alt="">
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
                </div>
            </div>
            <img
                @if(is_null($category['pic']) || $category['pic'] == '')
                src="/media/media_fixed/logo_holder.png"
                @else src="/{{$category['pic']}}" @endif alt="">
        </div>

        @if(count($category->getMedia('category_examples')->pluck('original_url')->all()) > 0)
            <div class="sp_examples_wrap">
                <x-ui.gallery
                    title="ПРИМЕРЫ РАБОТ"
                    :photos="$category->getMedia('category_examples')->pluck('original_url')->all()">
                </x-ui.gallery>
            </div>
        @endif

        @if ($category['staff'] ?? null && count($category['staff']) > 0)
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
                        @foreach($category['staff'] as $staff_member)
                            <div class="worker">
                                <a href="{{route('staff_page', $staff_member['yc_id'])}}">
                                    <img src="{{$staff_member['avatar']}}" alt="">
                                    <p-400>{{$staff_member['name']}}</p-400>
                                    <p>{{$staff_member['specialization']}}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="sp_services_block">
            @if(count(\App\Models\Service::where('scope_id', $scope['id'])->where('category_id', $category['id'])->get()) > 0)
                <h2>{{$category['name']}}</h2>
                @foreach(\App\Models\Group::whereIn('id', \App\Models\Service::where('scope_id', $scope['id'])
                                                            ->where('flg_active', 1)->where('category_id', $category['id'])
                                                            ->where(function ($query) {
                                                                    $query->where('service_type_id', '=', 1)
                                                                          ->orWhere('service_type_id', '=', 2);
                                                                })
                                                            ->pluck('group_id')
                                                            ->toArray())
                                                            ->get() as $group)
                    <div class="group_wrap">
                        <div data-group-title="{{$group['id']}}" class="group_title_wrap">
                            <h2>{{$group['name']}}</h2>
                            <svg width="15" height="9" viewBox="0 0 15 9" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M1.46757 0.580322L7.50741 6.6202L13.5473 0.580322L14.7258 1.75883L7.50741 8.9772L0.289062 1.75883L1.46757 0.580322Z"
                                    fill="#111010"/>
                            </svg>
                        </div>


                        <div id="services_in_group_{{$group['id']}}" class="sp_group_services_wrap">
                            @foreach(\App\Models\Service::where('scope_id', $scope['id'])
                                       ->where('category_id', $category['id'])
                                       ->where('flg_active', 1)
                                       ->where(function ($query) {
                                            $query->where('service_type_id', '=', 1)
                                                  ->orWhere('service_type_id', '=', 2);
                                        })
                                       ->where('group_id', $group['id'])
                                       ->get() as $service)
                                <div class="service_wrap">
                                    <div class="info">
                                        <a href="{{route('service_page', $service['id'])}}">
                                            <p class="duration"
                                               style="flex: none; width: 80px;">{{$service['yc_duration'] / 60}}
                                                мин</p>
                                        </a>
                                        <a href="{{route('service_page', $service['id'])}}">
                                            <p style="flex: none; width:70px;">{{$service['yc_price_min']}} ₽</p>
                                        </a>
                                        <a href="{{route('service_page', $service['id'])}}">
                                            <p>{{$service['name']}}</p>
                                        </a>
                                    </div>
                                    <div class="buttons-wrap">
                                        <a onclick="Livewire.emit('service_cart_add', {{$service['id']}})"
                                           id="service_add_bg_{{$service['id']}}"
                                           class="link coal">Записаться</a>
                                        <a href="{{route('service_page', $service['id'])}}"
                                           class="link fern">Подробнее</a>
                                        <a class="svg_link" href="{{route('service_page', $service['id'])}}">
                                            <svg width="15" height="4" viewBox="0 0 15 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0.833496 0.798828V3.29883H3.3335V0.798828H0.833496Z"
                                                      fill="black"/>
                                                <path d="M6.25016 0.798828V3.29883H8.75016V0.798828H6.25016Z"
                                                      fill="black"/>
                                                <path d="M11.6668 0.798828V3.29883H14.1668V0.798828H11.6668Z"
                                                      fill="black"/>
                                            </svg>
                                        </a>
                                    </div>


                                </div>
                            @endforeach
                        </div>

                    </div>

                @endforeach
            @endif
        </div>
    @endforeach
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
