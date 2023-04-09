<div>
    <button type="submit" wire:click.prevent="search_for_goods()"
            class="mb-3  show_preloader_on_click btn btn-outline-primary">
        Обновить товары (долгая загрузка)
    </button>

    <a type="submit" href="{{route('shopset.index')}}"
            class="mb-3 show_preloader_on_click btn btn-outline-primary">
        Шопсеты
    </a>

    @if ($found_yc_goods)
        <style>
            td {
                vertical-align: inherit !important;
            }
        </style>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Нашли следующие новые товары:</h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: fit-content"></th>
                        <th style="width: 10px">YC_ID</th>
                        <th>YC_Title</th>
                        <th>YC_Price, rub</th>
                        <th>Последнее изменение</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($found_yc_goods as $found_yc_good)
                        <tr>

                            <td>{{ $loop->index }}</td>
                            <td>{{$found_yc_good['yc_id']}}</td>
                            <td>{{$found_yc_good['yc_title']}}</td>
                            <td>{{$found_yc_good['yc_price']}}</td>
                            <td>{{$found_yc_good['last_change_date']}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <button type="submit" wire:click="add_found_goods()"
                        class="mt-3 show_preloader_on_click btn btn-outline-primary">
                    Добавить в систему
                </button>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <livewire:admin.good.good-table/>
        </div>
    </div>
</div>
