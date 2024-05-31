<div>
    <div class="calculator_wrap calc_hair_wrap">
        <div class="steps_wrap">


            <div class="step_wrap @if($step === 0) active @endif">
                <h2>Выберите услугу</h2>
                <div class="filter_wrap check_box_filter_wrap">
                    @foreach($options->unique('service_id') as $option)
                        <div>
                            <label for="service_{{$option['service_id']}}"><p>{{$option->service['name']}}</p></label>
                            <input type="radio" wire:model.live="step_0" id="service_{{$option['service_id']}}"
                                   value="{{$option['service_id']}}">
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="step_wrap @if($step === 1) active @endif">
                <h2>Ваша длина волос</h2>
                <div class="filter_wrap check_box_filter_wrap">
                    @foreach($options->pluck('step_1')->unique() as $option)
                        <div>
                            <label for="hair_step_{{$option}}"><p>{{$option}}</p></label>
                            <input type="radio" wire:model.live="step_1" id="hair_step_{{$option}}"
                                   value="{{$option}}">
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="step_wrap  @if($step === 2) active @endif">
                <h2>Какой у вас тип волос?</h2>
                <div class="filter_wrap check_box_filter_wrap">
                    @foreach($options->pluck('step_2')->unique() as $option)
                        <div>
                            <label for="hair_step_{{$option}}"><p>{{$option}}</p></label>
                            <input type="radio" wire:model.live="step_2" id="hair_step_{{$option}}"
                                   value="{{$option}}">
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="step_wrap @if($step === 3) active @endif">
                <h2>Ваши волосы уже окрашены?</h2>
                <div class="filter_wrap check_box_filter_wrap">
                    @foreach($options->pluck('step_3')->unique() as $option)
                        <div>
                            <label for="hair_step_{{$option}}"><p>{{$option}}</p></label>
                            <input type="radio" wire:model.live="step_3" id="hair_step_{{$option}}"
                                   value="{{$option}}">
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="step_wrap @if($step === 4) active @endif">

                    <div class="result_text @if($result_price) active @endif">
                        <h2>Расчет:</h2>
                        <p style="color: white">
                            Предварительная стоимость окрашивания равна <b>{{$result_price}}</b> руб.
                            Стоимость окрашивания может отличаться, если ранее ваши волосы подвергались таким факторам,
                            как окрашивание бытовым красителем, кератиновое восстановление, ламинирование волос и другие
                            химические воздействия,
                            которые влияют на структуру волоса.
                            Запишитесь на бесплатную консультацию к нашим мастерам.
                        </p>
                        <div class="go_buttons">
                            <a href="{{$result_link}}" target="_blank" class="link-bg fern">Записаться</a>
                            <a modal-id="consult_modal" class="need-consult link-bg fern">Получить консультацию</a>
                        </div>
                    </div>
                    <div class="result_text @if(!$result_price) active @endif">
                        <h2 style="color: white">
                            Выберите все опции!
                        </h2>
                    </div>

            </div>
        </div>


        <div class="buttons_wrap">
            <a wire:click.prevent="change_slide(-1)" data-direction="-1" id="prev_button"
               class="@if($step === 0) disabled @endif link fern">Назад</a>
            <div class="process_dots_wrap">
                <div id="process_dot_0" @if($step === 0) class="active" @endif></div>
                <div id="process_dot_1" @if($step === 1) class="active" @endif></div>
                <div id="process_dot_2" @if($step === 2) class="active" @endif></div>
                <div id="process_dot_3" @if($step === 3) class="active" @endif></div>
            </div>
            <a wire:click.prevent="change_slide(1)" id="next_button" class="link @if($step === 4) disabled @endif fern">Далее</a>
        </div>
    </div>

    @push('scripts')
        <script>

            $('#calc_hair').hide()

            $('.calc_hair_wrap input').on('change', function () {
                setTimeout(() => {
                @this.dispatch('next_step_hair')
                }, 300);
            })

            $('.need-consult').on('click', function (event) {
                event.preventDefault()
                // Закрываем предыдущее
                $('.modal').fadeOut(200);
                modal_on = 0

                modal = $(this).attr('modal-id');

                $('#' + modal).fadeToggle(200);
                $('body').css('overflow-y', 'hidden')
                setTimeout(function () {
                    modal_on = 1
                }, 1000)
            })

        </script>
    @endpush

</div>
