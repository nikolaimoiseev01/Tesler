<div>
    <div class="calculator_wrap calc_cosmetic_wrap">
        <div wire:ignore class="steps_wrap">
            <div wire:ignore id="step_wrap_1" class="step_wrap active">
                <h2>Что вас песпокоит?</h2>
                <div class="filter_wrap check_box_filter_wrap">
                    @foreach($options->pluck('step_1')->unique() as $option)
                        <div>
                            <label for="{{$option}}"><p>{{$option}}</p></label>
                            <input type="radio" name="step_1" id="{{$option}}"
                                   value="{{$option}}">
                        </div>
                    @endforeach
                </div>
            </div>

            <div wire:ignore id="step_wrap_2" class="step_wrap">
                <h2>Какой у вас тип кожи?</h2>
                <div class="filter_wrap check_box_filter_wrap">
                    @foreach($options->pluck('step_2')->unique() as $option)
                        <div>
                            <label for="{{$option}}"><p>{{$option}}</p></label>
                            <input type="radio" name="step_2" id="{{$option}}"
                                   value="{{$option}}">
                        </div>
                    @endforeach
                </div>
            </div>

            <div wire:ignore id="step_wrap_3" class="step_wrap">
                <h2>Тип посещения</h2>
                <div x-transition x-show="opened_category" class="filter_wrap check_box_filter_wrap">
                    @foreach($options->pluck('step_3')->unique() as $option)
                        <div>
                            <label for="{{$option}}"><p>{{$option}}</p></label>
                            <input type="radio" name="step_3" id="{{$option}}"
                                   value="{{$option}}">
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="step_wrap_4" class="step_wrap">
                <h2>Предлагаем:</h2>
                <div class="services_wrap">
                </div>
            </div>
        </div>


        <div wire:ignore class="buttons_wrap">
            <a data-direction="-1" id="prev_button" class="link disabled fern">Назад</a>
            <div class="process_dots_wrap">
                <div id="process_dot_1" class="active"></div>
                <div id="process_dot_2"></div>
                <div id="process_dot_3"></div>
            </div>
            <a data-direction="1" id="next_button" class="link fern">Далее</a>
        </div>
    </div>
    @push('scripts')
        <script>
            // Настраиваем высоту модального окна
            var maxHeight = -1;
            $('#calc_cosmetic').show()
            $('.step_wrap').each(function () {

                if ($(this).height() > maxHeight) {
                    maxHeight = $(this).height();
                }
            });
            $('#calc_cosmetic').hide()
            $('.steps_wrap').height(maxHeight + 20);

            // ----------------------------------------------

            $('.buttons_wrap a').on('click', function (event) {
                event.preventDefault()
                direction = parseFloat($(this).attr('data-direction'))
                change_step(direction)
            })


            var cur_slide = 1

            function change_step(direction) {
                step_1 = $('[name="step_1"]')
                step_2 = $('[name="step_2"]')
                step_3 = $('[name="step_3"]')
                all_checked = (step_1.is(':checked') && step_2.is(':checked') && step_3.is(':checked'))
                if (cur_slide + direction >= 1 && cur_slide + direction <= 4) {

                    if (cur_slide + direction !== 5) {
                        $('#process_dot_' + cur_slide).removeClass('active')
                        $('#step_wrap_' + cur_slide).removeClass('active')
                    }


                    setTimeout(function () {




                        $('#process_dot_' + (cur_slide + direction)).addClass('active')
                        $('#step_wrap_' + (cur_slide + direction)).addClass('active')

                        if (cur_slide + direction === 4 && direction === 1) {
                        @this.set('step_1', $("input[name='step_1']:checked").val())
                        @this.set('step_2', $("input[name='step_2']:checked").val())
                        @this.set('step_3', $("input[name='step_3']:checked").val())
                            Livewire.emit('make_option')
                        } else {

                        }
                        cur_slide += direction


                        if (cur_slide > 1) {
                            $('#prev_button').removeClass('disabled')
                        } else {
                            $('#prev_button').addClass('disabled')
                        }


                        next_button = $('#next_button')
                        if (cur_slide === 4) {
                            next_button.addClass('disabled')
                        } else {
                            next_button.removeClass('disabled')
                        }


                        if (cur_slide === 3) {
                            if (!step_1.is(':checked') || !step_2.is(':checked') || !step_3.is(':checked')) {
                                next_button.addClass('disabled')
                                next_button.text('Выберите опции')
                            } else {
                                next_button.text('Итог')
                            }

                        } else {
                            next_button.text('Далее')

                        }

                    }, 300)
                }

            }

            $('input').on('change', function () {
                change_step(1)
            })



            document.addEventListener('update_option', event => {
                $('#step_wrap_4 .services_wrap').html("")
                $('#step_wrap_4 .services_wrap').append("<p> <b>Выбрано:</b> " + event.detail.option_steps + "</p>")
                event.detail.services.forEach(function (item) {

                    link = document.location.origin + '/service/' + item['id']
                    take_service_link = " <a target='_blank' href='" + link + "' class=\"link\">Подробнее</a>"
                    if(item['id'] !== 999999) {
                        $('#step_wrap_4 .services_wrap').append("<div class='option_link_wrap'><a target='_blank' class='link coal' href='" + link + "'>" + item['name'] + "</a> " + take_service_link + "</div>")
                    } else {
                        $('#step_wrap_4 .services_wrap').append("<div class='option_link_wrap'><a target='_blank' class='link coal'>" + item['name'] + "</a></div>")
                    }



                });
                $('#step_4').removeAttr('wire:ignore')
            })
        </script>
    @endpush
</div>
