<div>
    <button type="submit" wire:click.prevent="search_for_services()"
            class="mb-3 show_preloader_on_click btn btn-outline-primary">
        Обновить услуги
    </button>
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
                            <td>{{$found_yc_service['yc_price_min']}}</td>
                            <td>{{$found_yc_service['yc_duration']}}</td>
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
