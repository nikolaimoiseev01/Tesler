<div>
    @if(($good['flg_active'] && $good['yc_actual_amount'] > 0) || ($good['flg_active'] && ($good['yc_category'] == 'Сертификаты Сеть Tesler' || $good['yc_category'] == 'Абонементы Сеть Tesler')) || ($good['flg_active'] && $good['good_category_id'][0] === 6) || ($good['flg_active'] && $good['good_category_id'][0] === 7))
        <a wire:click="$dispatch('good_cart_add', { good_id: {{$good['id']}} })"
           id="good_add_{{$good['id']}}"
           class="link-bg coal">
            @if($good['good_category_id'][0] === 6 || $good['good_category_id'][0] === 7)
                Купить
            @else
                В корзину
            @endif
        </a>
    @else
        <p>Этот товар недоступен для покупки</p>
    @endif
</div>
