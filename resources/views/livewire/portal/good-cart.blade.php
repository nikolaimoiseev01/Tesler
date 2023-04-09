<div x-data="{ opened_cart: true }">
    <div class="good_cart_wrap">
        <h2>Корзина</h2>

        @if(!$cart_goods)
            <div style="direction:ltr">
                <p style="margin-top: 40px;">Пока пустая</p>
                <a style="display: inline-block; margin-top: 20px;" href="{{route('market_page')}}" class="link coal">Перейти в магазин</a>
            </div>
        @endif

        <a @click="opened_cart = false" class="close_cross">
            <svg width="19" height="3" viewBox="0 0 19 3" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.5 0.679688H0.5V2.67969H18.5V0.679688Z" fill="black"/>
            </svg>
        </a>


        @if($cart_goods)
            <div class="goods_wrap">


                @foreach($cart_goods as $cart_good)
                    <div class="good_wrap">
                        <img @if(is_null($cart_good['image_url']) || $cart_good['image_url'] == '')
                             src="/media/media_fixed/holder_225x175.png"
                             @else src="{{$cart_good['image_url']}}" @endif
                             alt="">
                        <div class="info">
                            <p class="category">
                                {{\App\Models\GoodCategory::where('id', $cart_good['good_category_id'][0])->first(['title'])->title}}
                            </p>
                            <p class="name">{{$cart_good['name']}}</p>
                            <div class="spec_wrap">
                                <p class="spec">{{$cart_good['yc_price']}}</p>
                                <p class="price">{{$cart_good['yc_price']}} ₽</p>
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
                <p>{{$total_price}}</p>
            </div>

            <div class="buttons_wrap">
                <a class="link-bg fern">ОФОРМИТЬ ЗАКАЗ</a>
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

            <a wire:click.prevent="good_cart_remove_all()" class="remove_all link fern">Удалить все</a>
        @endif


    </div>
</div>
