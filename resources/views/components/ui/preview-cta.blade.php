<div class="preview_cta_wrap">
    <div class="left">
        <img src="/media/media_fixed/preview_cta_holder.png" alt="">
    </div>

    <div class="right">
        <h2>{{$title}}</h2>
        <div class="cards_wrap">
            @foreach($cards as $card)
                <div class="card_wrap">
                    <div class="img_wrap">
                        <img src="{{($card['img'] !== '') ? $card['img'] : '/media/media_fixed/logo_holder.png'}}"
                             alt="">
                    </div>

                    <div class="info">
                        <p class="category">{{$card['category']}}</p>
                        <a target="_blank" href="{{$card['link']}}"><p class="name">{{$card['title']}}</p></a>
                        @if($card['category'] <> 'SHOP-СЕТ')
                            <p class="price">{{$card['price']}} ₽</p>
                        @endif
                        <a href="{{$card['link']}}" class="to_cart link-bg coal">Подробнее</a>
                    </div>
                </div>
            @endforeach

        </div>
        <a href="{{$link}}" target="_blank" class="go_to_all link coal">Смотреть все</a>
    </div>

</div>
