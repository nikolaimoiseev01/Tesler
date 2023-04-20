@extends('layouts.portal')

@section('title')Успех!@endsection

@section('content')
    <div class="market_page_wrap">
        <x-ui.menu color="#111010"></x-ui.menu>
        <div style="padding-top:20px; text-align: center" class="content">
            <h2>Вы успешно оплатили заказ!</h2>
            <p style="margin-top: 40px;">
                Пожалуйста, сохраните Ваш ID.
                По нему мы сможем найти заказ в случае каких-либо вопросов: <b>{{$order['tinkoff_order_id']}}</b>
            </p>
        </div>
    </div>
@endsection
