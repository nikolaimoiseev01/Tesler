@extends('layouts.portal')

@section('title')Магазин@endsection

@section('content')
    <div class="market_page_wrap">
        <x-ui.menu color="#111010"></x-ui.menu>
        <div class="content categories_filter_wrap">
            @foreach($categories as $category)
                <div onclick="location.href='{{route('good_category_page', $category['id'])}}';" class="category_filter_wrap">
                    <img src="{{$category->getFirstMediaUrl('pic_goodcategory_small')}}" alt="">
                    <p>{{$category['title']}}</p>
                </div>
            @endforeach
        </div>
{{--        <div class="page_cover image_blackout">--}}
{{--            <img src="/media/media_fixed/abonement_cover.png" alt="">--}}
{{--        </div>--}}
        @livewire('portal.market-page', ['goods' => $goods, 'categories' => $categories, 'abon_page_check' => $abon_page_check])
    </div>
@endsection
