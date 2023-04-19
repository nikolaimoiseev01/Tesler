<div  x-data="{ opened_cart: true }" class="good_cart_wrap service_cart_block_wrap">
    @if(!$cart_services)
        <div style="direction:ltr">
            <p style="margin-top: 40px;">Пока пустая</p>
            <a style="display: inline-block; margin-top: 20px;" href="{{route('home')}}/#scopes_main_page" class="link coal">Наши услуги</a>
        </div>
    @endif
    @if($cart_services)
{{--        <div @click="opened_cart = true" class="service_cart_icon_wrap">--}}
{{--            <p>{{count($cart_services)}}</p>--}}
{{--        </div>--}}

{{--        <div x-show="opened_cart"--}}
{{--             x-transition--}}
{{--             class="service_cart_wrap">--}}
{{--            --}}{{--            <a href="" wire:click.prevent="check_session">Посмотреть сессию</a>--}}
{{--            --}}{{--            <a href="" wire:click.prevent="delete_session">Удалить сессию</a>--}}
{{--            <div class="title_wrap">--}}
{{--                --}}{{--                <p >Выбрано услуг ({{count($cart_services)}}): </p>--}}
{{--                <a target="_blank" href="{{$yc_link}}" class="link fern">Перейти к записи ({{$total_price}} ₽)</a>--}}
{{--            </div>--}}

{{--            <a @click="opened_cart = false" class="close_cross">--}}
{{--                <svg width="19" height="3" viewBox="0 0 19 3" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                    <path d="M18.5 0.679688H0.5V2.67969H18.5V0.679688Z" fill="black"/>--}}
{{--                </svg>--}}
{{--            </a>--}}

{{--            <div class="services_wrap">--}}
{{--                <div style="direction: ltr;">--}}
{{--                    @foreach($cart_services as $cart_service)--}}
{{--                        <div class="service_wrap">--}}
{{--                            <p class="duration">{{$cart_service['yc_duration'] / 60}} мин</p>--}}
{{--                            <p class="price">{{$cart_service['yc_price_min']}} ₽</p>--}}
{{--                            <div>--}}
{{--                                <p>{{$cart_service['name']}}</p>--}}
{{--                                <a wire:click.prevent="service_cart_remove({{$cart_service['id']}})">--}}
{{--                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"--}}
{{--                                         xmlns="http://www.w3.org/2000/svg">--}}
{{--                                        <path--}}
{{--                                            d="M0.519784 12.3027L5.82308 6.99941L0.519775 1.6961L1.69829 0.517595L7.00158 5.82091L12.3048 0.517578L13.4834 1.6961L8.18008 6.99941L13.4833 12.3027L12.3048 13.4812L7.00158 8.17791L1.69829 13.4812L0.519784 12.3027Z"--}}
{{--                                            fill="#DDDDD5" fill-opacity="0.3"/>--}}
{{--                                    </svg>--}}

{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <a wire:click.prevent="service_cart_remove_all()" class="remove_all link fern">Удалить все</a>--}}


{{--        </div>--}}
            <div class="goods_wrap">


                @foreach($cart_services as $cart_service)
                    <div class="good_wrap">
                        <img @if(is_null($cart_service['image_url']) || $cart_service['image_url'] == '')
                             src="/media/media_fixed/logo_holder.png"
                             @else src="{{$cart_service['image_url']}}" @endif
                             alt="">
                        <div class="info">
{{--                            <p class="category">--}}
{{--                                {{\App\Models\Category::where('id', $cart_service['category_id'])->first(['name'])->name}}--}}
{{--                            </p>--}}
                            <a href="{{route('service_page', $cart_service['id'])}}"><p class="name">{{$cart_service['name']}}</p></a>
                            <div class="spec_wrap">
                                <p class="spec">{{\App\Models\Category::where('id', $cart_service['category_id'])->first(['name'])->name}}</p>
                                <p class="price">{{$cart_service['yc_price_min']}} ₽</p>
                            </div>

                        </div>
                        <a class="remove_good" wire:click.prevent="service_cart_remove({{$cart_service['id']}})">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.519784 12.3027L5.82308 6.99941L0.519775 1.6961L1.69829 0.517595L7.00158 5.82091L12.3048 0.517578L13.4834 1.6961L8.18008 6.99941L13.4833 12.3027L12.3048 13.4812L7.00158 8.17791L1.69829 13.4812L0.519784 12.3027Z"
                                    fill="#DDDDD5" fill-opacity="0.3"/>
                            </svg>

                        </a>

                    </div>
                @endforeach
            </div>

            <div class="total_price_wrap">
                <p>СТОИМОСТЬ УСЛУГ</p>
                <hr>
                <p>{{$total_price}} ₽</p>
            </div>

            <div class="buttons_wrap">
                <a target="_blank" href="{{$yc_link}}" class="link-bg fern">Перейти к записи</a>
            </div>


            <a wire:click.prevent="service_cart_remove_all()" class="remove_all link fern">Удалить все услуги</a>
    @endif
</div>
