<div>
    <div style="max-width: 1400px;" class="row">
        <div class="col-md-6">
            <div style="max-width: 1000px;" class="card">
                <div class="d-flex align-items-center card-header p-2">
                    <h1 style="font-size: 22px;" class="ml-3">Общая информация</h1>
                </div>
                <div class="card-body">
                    <h1 class="mb-3"><b>Общая стоимость: {{$order['price'] / 100}} руб.</b></h1>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td style="font-weight: bold">ID</td>
                            <td>
                                {{$order['id']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Tinkoff Заказ</td>
                            <td>
                                {{$order['tinkoff_order_id']}}
                            </td>
                        </tr>
                        @if($order['promocode'])
                            <tr>
                                <td style="font-weight: bold">Промокод</td>
                                <td>
                                    {{$order['promocode']}}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td style="font-weight: bold">Tinkoff статус</td>
                            <td>
                                {{$order['tinkoff_status']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Полная стоимость с учетом промокода</td>
                            <td>
                                {{$order['price'] / 100}} руб.
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">ФИО</td>
                            <td>
                                {{$order['name']}} {{$order['surname']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Телефон</td>
                            <td>
                                {{$order['mobile']}}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight: bold">Получение</td>
                            <td><b>
                                    @if($order['need_delivery'] == 1)
                                        Нужна доставка
                                    @else
                                        Самостоятельно
                                    @endif
                                </b>
                            </td>
                        </tr>


                        @if($order['need_delivery'] == 1)
                            <tr>
                                <td style="font-weight: bold">Адрес</td>
                                <td>
                                    {{$order['city']}} {{$order['address']}} {{$order['index']}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Статус отправления</td>
                                <td>
                                    <div class="form-group">
                                        <select wire:change="make_deli_status" wire:model="deli_status"
                                                class="form-control">
                                            @foreach($deli_statuses_all as $deli_status)
                                                <option
                                                    value="{{$deli_status['id']}}">{{$deli_status['title']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>


                </div>
            </div>
        </div>


        {{--        <a wire:click.prevent="make_selling()">Сделать складские операции</a>--}}

        <div class="col-md-6">
            <div style="max-width: 1000px;" class="card">
                <div class="d-flex align-items-center card-header p-2">
                    <h1 style="font-size: 22px;" class="ml-3">Товары в заказе</h1>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-2">
                        @foreach(json_decode($order['goods']) as $key=>$order)
                            <div>
                                {{$key + 1}}) <a target="_blank"
                                                 href="{{route('good.edit', $order->good_id)}}">{{\App\Models\Good::where('id', $order->good_id)->value('name')}}</a>
                                <b>Кол-во: {{$order->amount}}</b>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
