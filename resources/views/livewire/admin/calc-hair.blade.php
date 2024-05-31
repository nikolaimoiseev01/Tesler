<div>
    <div class="card">
        <div class="card-body">
            <form action="">
                <label for="">Выберите услугу для просчета:</label>
                <div class="mb-3" wire:ignore>
                    <select required wire:ignore class="select2 form-control"
                            aria-hidden="true" id="service_id_chosen">
                        @foreach($services as $serv)
                            <option
                                value="{{$serv['id']}}">{{$serv['name']}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <label for="">Шаг 1: </label>
                <div class="mb-3">
                    <select required wire:model.live="step_1" class="form-control"
                            aria-hidden="true">
                        <option selected>Выберите опцию</option>
                        @foreach($steps_1 as $s)
                            <option
                                value="{{$s}}">{{$s}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <label for="">Шаг 2: </label>
                <div class="mb-3">
                    <select required wire:model.live="step_2" class="form-control"
                            aria-hidden="true">
                        <option selected>Выберите опцию</option>
                        @foreach($steps_2 as $s)
                            <option
                                value="{{$s}}">{{$s}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <label for="">Шаг 3: </label>
                <div class="mb-3">
                    <select required wire:model.live="step_3" class="form-control"
                            aria-hidden="true">
                        <option selected>Выберите опцию</option>
                        @foreach($steps_3 as $s)
                            <option
                                value="{{$s}}">{{$s}}
                            </option>
                        @endforeach
                    </select>
                </div>


                <label for="">Поставить стоимость</label>
                <input wire:model.live="result_price" type="text" class="form-control">


                <button type="submit" wire:click.prevent="new_option_to_add()"
                        class="mt-3 show_preloader_on_click btn btn-outline-primary">
                    Сохранить
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>

            $('#service_id_chosen').on('change', function () {
            @this.set('service_id_chosen', $(this).val());
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


    <div class="card">
        <div class="d-flex align-items-center card-header p-2">
            <h1 style="font-size: 22px;" class="ml-3">Все опции</h1>
        </div>
        <div class="card-body">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th>Услуга</th>
                    <th>Шаг 1</th>
                    <th>Шаг 2</th>
                    <th>Шаг 3</th>
                    <th>Стоимость</th>
                </tr>
                </thead>
                <tbody>
                @foreach($options as $option)
                    <tr>
                        <td>{{$option->service['name']}}</td>
                        <td>{{$option['step_1']}}</td>
                        <td>{{$option['step_2']}}</td>
                        <td>{{$option['step_3']}}</td>
                        <td>{{$option['result_price']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
