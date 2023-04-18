<div>
    <div class="d-flex flex-wrap gap-3">


    <button type="submit" wire:click.prevent="search_for_services()"
            class="mb-3 mr-2 show_preloader_on_click btn btn-outline-primary">
        Обновить услуги
    </button>

    <a type="submit" wire:click.prevent="refresh_service_yc_info()"
       class="mb-3 mr-2 show_preloader_on_click btn btn-outline-primary">
        Обновить YClients инфо (2 мин.)
    </a>

    <div class="d-flex gap-3">


        <a type="submit" wire:click.prevent="have_nulls()"
           class="mb-3 show_preloader_on_click btn btn-outline-primary">
            Показать, у кого незаполненны:
        </a>

        <div class="form-group">
            <select wire:model="null_column" class="form-control"
                    aria-hidden="true" id="has_null">
                <option value="scope_id">Сфера</option>
                <option value="category_id">Категория</option>
                <option value="group_id">Группа</option>
                <option value="desc_small">Описание маленькое</option>
                <option value="desc">Описание</option>
                <option value="proccess">Процесс</option>
                <option value="result">Результат</option>
            </select>
        </div>
    </div>
    </div>
    {{--    <a wire:click.prevent="export_all()" class="">Выгрузить все</a>--}}
    @if ($found_yc_services)
        <style>
            td {
                vertical-align: inherit !important;
            }
        </style>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Нашли следующие новые услуги:</h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: fit-content"></th>
                        <th style="width: 10px">YC_ID</th>
                        <th>YC_Title</th>
                        <th>YC_Category</th>
                        <th>YC_Price_min, rub</th>
                        <th>YC_Duration, sec</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($found_yc_services as $found_yc_service)
                        <tr>

                            <td>{{ $loop->index }}</td>
                            <td>{{$found_yc_service['yc_id']}}</td>
                            <td>{{$found_yc_service['yc_title']}}</td>
                            <td>{{$found_yc_service['yc_category_name'] ?? ""}}</td>
                            <td>{{$found_yc_service['yc_price_min'] ?? ""}}</td>
                            <td>{{$found_yc_service['yc_duration'] ?? ""}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <button type="submit" wire:click="add_found_services()"
                        class="mt-3 show_preloader_on_click btn btn-outline-primary">
                    Добавить в систему
                </button>
            </div>
        </div>
    @endif

    @if ($services_have_nulls)
        <style>
            td {
                vertical-align: inherit !important;
            }
        </style>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">У следующих услуг не заполнено поле {{$null_column}}</h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: fit-content"></th>
                        <th style="width: 10px">ID</th>
                        <th>Название</th>
                        <th>Сфера</th>
                        <th>Категория</th>
                        <th>Группа</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($services_have_nulls as $service_has_nulls)
                        <tr>

                            <td><a target="_blank" href="{{route('service.edit', $service_has_nulls['id'])}}">Подробнее</a></td>
                            <td>{{$service_has_nulls['id']}}</td>
                            <td>{{$service_has_nulls['name']}}</td>
                            <td>{{$service_has_nulls->scope['name'] ?? ""}}</td>
                            <td>{{$service_has_nulls->category['name'] ?? ""}}</td>
                            <td>{{$service_has_nulls->group['name'] ?? ""}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <livewire:admin.service.service-table/>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:update', function () {
            // filepond_trigger();
            main_js_trigger();
            $("[name='filepond']").attr('name', 'promo_pics');
            // $(':input').val('');
        })
    </script>
</div>
