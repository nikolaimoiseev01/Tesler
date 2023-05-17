<div>
    <div class="card">
        <div class="card-body">
            <label for="">Выберите вариант исхода:</label>
            <div wire:ignore>
                <select wire:ignore class="select2 form-control"
                        aria-hidden="true" id="cur_option">
                    @foreach($options as $option)
                        <option
                            value="{{$option['id']}}">{{$option['step_1']}} -> {{$option['step_2']}}
                            -> {{$option['step_3']}}
                        </option>
                    @endforeach
                </select>
            </div>

            <label class="mt-3" for="">Процедуры в итоге этого варианта: </label>
            @if ($cur_option['services'] ?? null !== null)
                <div>

                    @foreach($cur_option['services'] as $cur_option_service)
                        <div wire:key="{{ $loop->index }}">
                            <a target="_blank"
                               href="{{route('service.edit', $cur_option_service['id'])}}">{{$cur_option_service['name']}}</a>
                            <a wire:click.prevent="delete_service({{$cur_option_service['id']}})" href="">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                еще нет ни одной
            @endif

        </div>
    </div>

    <div class="mt-3 mb-3 form-group">
        <div wire:ignore>
            <select wire:ignore class="select2 form-control"
                    aria-hidden="true" id="service_to_add">
                @foreach($services_all as $service)
                    <option
                        value="{{$service['id']}}">{{$service['name']}}
                    </option>
                @endforeach
            </select>
        </div>
        <a type="submit" wire:click.prevent="new_option_to_add()"
           class="mt-3 show_preloader_on_click btn btn-outline-primary">
            Добавить
        </a>
    </div>

    <div class="card">
        <div class="d-flex align-items-center card-header p-2">
            <h1 style="font-size: 22px;" class="ml-3">Все опции</h1>
        </div>
        <div class="card-body">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th>Шаг 1</th>
                    <th>Шаг 2</th>
                    <th>Шаг 3</th>
                    <th>Услуги</th>
                </tr>
                </thead>
                <tbody>
                @foreach($options as $option)
                    <tr>
                        <td>{{$option['step_1']}}</td>
                        <td>{{$option['step_2']}}</td>
                        <td>{{$option['step_3']}}</td>
                        <td>
                            @if($option['services'])
                                @foreach($option['services'] as $service)
                                    @if($service > 0)
                                        {{Str::limit(\App\Models\Service::where('id', $service)->first()['name'], 15, '...')}} ||
                                    @endif
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            $('#service_to_add').on('change', function () {
            @this.set('service_to_add', $(this).val());
            })
            //
            $('#cur_option').on('change', function () {
            @this.set('cur_option_id', $(this).val());
            })

            function page_js_trigger() {
                $('.select2').each(function () {
                    $(this).select2()
                })
            }

            page_js_trigger()

            document.addEventListener('page_js_trigger', function () {
                page_js_trigger()
            })
        </script>
    @endpush
</div>
