<div>

    <div class="good_cart_wrap">


        @if(!$cart_goods)
            <div style="direction:ltr">
                <p style="margin-top: 40px;">Пока пустая</p>
                <a style="display: inline-block; margin-top: 20px;" href="{{route('market_page')}}" class="link coal">Перейти
                    в магазин</a>
            </div>
        @endif



        @if($cart_goods && !$show_take_option)
            <div class="goods_wrap">
                @foreach($cart_goods as $cart_good)
                    <div class="good_wrap">
                        <div class="counter_wrap">
                            <button wire:click="update_counter({{$cart_good['id']}}, -1)">-</button>
                            <p>{{$cart_good['sell_amount'] ?? 1}}</p>
                            <button wire:click="update_counter({{$cart_good['id']}}, 1)">+</button>
                        </div>
                        <img @if(is_null($cart_good['image_url']) || $cart_good['image_url'] == '')
                             src="/media/media_fixed/logo_holder.png"
                             @else src="{{$cart_good['image_url']}}" @endif
                             alt="">
                        <div class="info">
                            <p class="category">
                                {{\App\Models\GoodCategory::where('id', $cart_good['good_category_id'][0])->first(['title'])->title}}
                            </p>
                            <a href="{{route('good_page', $cart_good['id'])}}"><p
                                    class="name">{{$cart_good['name']}}</p></a>
                            <div class="spec_wrap">
{{--                                <p class="spec">{{$cart_good['capacity']}} {{$cart_good['capacity_type']}}</p>--}}
                                <p class="spec">{{$cart_good['yc_actual_amount']}} в наличии</p>
                                <p class="price">{{$cart_good['yc_price']}} ₽/шт.</p>
                            </div>

                        </div>
                        <a class="remove_good" wire:click.prevent="good_cart_remove({{$cart_good['id']}})">
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
                <p>СУММА ЗАКАЗА</p>
                <hr>
                <p>{{$total_price}} ₽</p>
            </div>

            <div class="buttons_wrap">
                <a wire:click.prevent="show_take_option" class="link-bg fern">ОФОРМИТЬ ЗАКАЗ</a>
            </div>

            <div class="delivery_wrap">
                <p><b>ДОСТАВКА</b></p>
                <p>
                    По Красноярску день в день! Бесплатная доставка при сумме заказа от 3 500 рублей. При сумме заказа
                    меньше 3 500 рублей — за ваш счёт по актуальному прайсу Яндекс-доставки.
                    <br><br>
                    По всей России курьерской службой СДЭК, от 6000 рублей — бесплатно.
                </p>
            </div>

            <a wire:click.prevent="good_cart_remove_all()" class="remove_all link fern">Удалить все товары</a>
        @endif

        @if($show_take_option)
            <div class="buyer_info_wrap">

                <h2>Оформление заказа</h2>

                <div class="input_wrap">
                    <label for="name"><p>ИМЯ</p></label>
                    <input wire:model="name" id="name" name="name"
                           @if($errors_array)
                               @if (in_array("name", $errors_array))
                                    class="invalid"
                               @endif
                           @endif

                           required type="text" placeholder="Имя">
                </div>
                <div class="input_wrap">
                    <label for="surname"><p>ФАМИЛИЯ</p></label>
                    <input
                        @if($errors_array)
                            @if (in_array("surname", $errors_array))
                                class="invalid"
                            @endif
                        @endif
                        wire:model="surname" id="surname" name="surname" required type="text" placeholder="Фамилия">
                </div>
                <div class="input_wrap">
                    <label for=""><p>КОНТАКТНЫЙ НОМЕР</p></label>
                    <input
                        @if($errors_array)
                        @if (in_array("mobile", $errors_array))
                        class="invalid"
                        @endif
                        @endif
                        wire:model="mobile" id="mobile" name="mobile" required class="mobile_input" type="text"
                           placeholder="8 911 123 45 67">
                </div>

                <div>
                    <input type="checkbox" id="need_delivery" wire:model="need_delivery"
                           value="1">
                    <label for="need_delivery"><p>Требуется доставка</p></label>
                </div>

                @if($need_delivery)
                    <div class="input_wrap">
                        <label for="city"><p>Город</p></label>
                        <input
                            @if($errors_array)
                            @if (in_array("city", $errors_array))
                            class="invalid"
                            @endif
                            @endif
                            wire:model="city" id="city" name="city" required type="text" placeholder="Город">
                    </div>
                    <div class="input_wrap">
                        <label for="address"><p>Адрес</p></label>
                        <input
                            @if($errors_array)
                            @if (in_array("address", $errors_array))
                            class="invalid"
                            @endif
                            @endif
                            wire:model="address" id="address" name="address" required type="text"
                               placeholder="Адрес">
                    </div>
                    <div class="input_wrap">
                        <label for="index"><p>Индекс</p></label>
                        <input
                            @if($errors_array)
                            @if (in_array("index", $errors_array))
                            class="invalid"
                            @endif
                            @endif
                            wire:model="index" id="index" name="index" required type="text" placeholder="Индекс">
                    </div>

                @endif

                <div class="buttons_wrap">
                    <a wire:click.prevent="to_checkout()" class="link-bg fern">ОПЛАТИТЬ {{$total_price}} ₽</a>
                </div>

                <a wire:click.prevent="show_take_option" class="link">Назад</a>
            </div>
        @endif

    </div>
    @push('scripts')
        <script>
            document.addEventListener('trigger_mobile_input', function () {
                $('.mobile_input').mask('0 (000) 000-00-00');
            })
            document.addEventListener('open_url_new_tab', function (event) {
                window.open(event.detail.url, '_blank')
            })

        </script>
    @endpush
</div>
