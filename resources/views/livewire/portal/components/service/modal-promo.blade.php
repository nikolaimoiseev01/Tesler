<div class="modal_promo_wrap">
    <h2 class="modal_title">Выбери свой подарок</h2>
    <div class="img_wrap">
        {{$promo->getFirstMedia('promo_pics')}}
        <span>{{$promo['type']}}</span>
    </div>

    <b><p class="promo_title">{{$promo['title']}}</p></b>
    <p class="promo_desc">{{$promo['desc']}}</p>
    <a href="{{$promo['link']}}" class="link-bg fern_to_light promo_link">{{$promo['link_text']}}</a>
    <a href="/#promo_slider" class="link-bg fern_to_light close_link">Выбрать другую акцию</a>

</div>
