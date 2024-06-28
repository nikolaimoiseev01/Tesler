<div @click.outside="opend_filter = 'none'" x-data="{ opend_filter: 'none' }" class="choose_comp_wrap">
    <a @click="opend_filter = 'sort'" class="link coal">{{$chosen_yc_shop['name']}}</a>
    <svg @click="opend_filter = 'sort'" fill="#000000" height="800px" width="800px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
         xmlns:xlink="http://www.w3.org/1999/xlink"
         viewBox="0 0 330 330" xml:space="preserve">
<path id="XMLID_225_" d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393
	c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393
	s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z"/>
</svg>
    <div x-transition x-show="opend_filter === 'sort'" class="filter_wrap select_filter_wrap">
        <div>
            @foreach(config('cons.yc_shops') as $yc_shop)
                <p wire:click.prevent="select_comp({{$yc_shop['id']}})">{{$yc_shop['name']}}</p>
            @endforeach
        </div>
    </div>
</div>
