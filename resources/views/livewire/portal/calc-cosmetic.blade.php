<div>
    <div class="calculator_wrap calc_cosmetic_wrap">
        <div class="steps_wrap">
            <div id="step_wrap_1" class="step_wrap @if($step === 1) active @endif">
                <h2>Что вас песпокоит?</h2>
                <div class="filter_wrap check_box_filter_wrap">
                    @foreach($options->pluck('step_1')->unique() as $option)
                        <div>
                            <label for="{{$option}}"><p>{{$option}}</p></label>
                            <input wire:model="step_1" type="radio" name="step_1" id="{{$option}}"
                                   value="{{$option}}">
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="step_wrap_2" class="step_wrap @if($step === 2) active @endif">
                <h2>Какой у вас тип кожи?</h2>
                <div class="filter_wrap check_box_filter_wrap">
                    @foreach($options->pluck('step_2')->unique() as $option)
                        <div>
                            <label for="{{$option}}"><p>{{$option}}</p></label>
                            <input wire:model="step_2" type="radio" name="step_2" id="{{$option}}"
                                   value="{{$option}}">
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="step_wrap_3" class="step_wrap @if($step === 3) active @endif">
                <h2>Тип посещения</h2>
                <div x-transition x-show="opened_category" class="filter_wrap check_box_filter_wrap">
                    @foreach($options->pluck('step_3')->unique() as $option)
                        <div>
                            <label for="{{$option}}"><p>{{$option}}</p></label>
                            <input wire:model="step_3" type="radio" name="step_3" id="{{$option}}"
                                   value="{{$option}}">
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="step_wrap_4" class="step_wrap @if($step === 4) active @endif">
                @if($has_services === 1)
                    <h2>Предлагаем:</h2>
                @elseif($has_services === 2)
                    <h2>Вам подходят все наши услуги!</h2>
                @elseif($has_services === 3)
                    <h2>Сначала сделайте выбор на всех шагах!</h2>
                @endif
                <div class="services_wrap">
                    {{--                    {{$services}}--}}
                    @if($services && $has_services === 1)
                        @foreach($services as $service)
                            <div class='option_link_wrap'>
                                <a target='_blank' class='link coal' href='{{route('service_page', $service['id'])}}'>
                                    <p>{{$service['name']}}</p>
                                </a>
                                <a target='_blank' href='{{route('service_page', $service['id'])}}' class="link">Подробнее</a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>


        <div class="buttons_wrap">
            <a wire:click.prevent="change_slide(-1)" class="@if($step === 1) disabled @endif link fern">Назад</a>
            <div class="process_dots_wrap">
                <div id="process_dot_1" @if($step === 1) class="active" @endif></div>
                <div id="process_dot_2" @if($step === 2) class="active" @endif></div>
                <div id="process_dot_3" @if($step === 3) class="active" @endif></div>
            </div>
            <a wire:click.prevent="change_slide(1)" class="@if($step === 4) disabled @endif link fern">Далее</a>
        </div>
    </div>
        @push('scripts')
            <script>
                // Настраиваем высоту модального окна
                var maxHeight = -1;
                $('#calc_cosmetic').show()
                $('.calc_cosmetic_wrap .steps_wrap .step_wrap').each(function () {

                    if ($(this).height() > maxHeight) {
                        maxHeight = $(this).height();
                    }
                });
                $('#calc_cosmetic').hide()
                $('.calc_cosmetic_wrap .steps_wrap').height(maxHeight + 20);

                $('.calc_cosmetic_wrap input').on('change', function() {
                    setTimeout(() => {
                    @this.emit('next_step_cosmetic')
                    }, 300);
                })

                // ----------------------------------------------

                document.addEventListener('livewire:update', function () {
                    var maxHeight = -1;
                    $('.calc_cosmetic_wrap .steps_wrap .step_wrap').each(function () {
                        if ($(this).height() > maxHeight) {
                            maxHeight = $(this).height();
                        }
                    });
                    if ($('#calc_cosmetic').is(':visible')) {
                        $('.calc_cosmetic_wrap .steps_wrap').height(maxHeight + 20);
                    }

                })
            </script>
        @endpush
</div>
