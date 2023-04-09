@extends('layouts.portal')

@section('title')Магазин@endsection

@section('content')
    <div class="gc_page_wrap market_page_wrap">
        <x-ui.menu color="white"></x-ui.menu>
        <div class="page_cover image_blackout">
            <img
                @if ($goodcategory->getFirstMediaUrl('pic_goodcategory'))
                src="{{$goodcategory->getFirstMediaUrl('pic_goodcategory')}}"
                @else
                src="/media/media_fixed/abonement_cover.png"
                @endif
                alt="">
        </div>
        <div class="content page_title_wrap">
            <div class="g_bread_wrap">
                <a href="{{route('market_page')}}" class="link coal">Магазин</a> / <p>{{$goodcategory['title']}}</p>
            </div>
            <h2>{{$goodcategory['title']}}</h2>
        </div>

        @livewire('portal.market-page', ['goods' => $goods, 'categories' => $categories, 'abon_page_check' => $abon_page_check])
    </div>
@endsection
