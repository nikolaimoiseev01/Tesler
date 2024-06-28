<div @click.outside="opend_filter = 'none'" x-data="{ opend_filter: 'none' }" class="choose_comp_wrap">
    <a @click="opend_filter = 'sort'" class="link coal">{{$chosen_yc_shop['name']}}</a>
    <div x-transition x-show="opend_filter === 'sort'" class="filter_wrap select_filter_wrap">
        <div>
            @foreach(config('cons.yc_shops') as $yc_shop)
                <p wire:click.prevent="select_comp({{$yc_shop['id']}})">{{$yc_shop['name']}}</p>
            @endforeach
        </div>
    </div>
</div>
