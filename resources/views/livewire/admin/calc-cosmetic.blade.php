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
            @if ($cur_option['services'] !== null)
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
