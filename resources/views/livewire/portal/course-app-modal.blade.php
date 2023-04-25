<div>
    @if(!$course_app_answered_check)
        <h2>Создание заявки на покупку курса "{{$course['title']}}".</h2>
        <p class="info">
            Создавая Tesler, мы вдохновлялись вами! Это уникальный проект, пропитанный любовью к делу и заботой о госте.
            Здесь каждый сможет почувствовать свою ценность, насладиться качеством и получить новую порцию уверенности в
            себе.
        </p>
        <form action=""
              wire:submit.prevent="createCourseApp(Object.fromEntries(new FormData($event.target)))"
        >
            <div class="inputs_wrap">
                <div class="row_1_wrap">
                    <div class="input_wrap">
                        <label for=""><p>ВАШЕ ИМЯ</p></label>
                        <input id="name" name="name" required type="text" placeholder="Имя">
                    </div>
                    <div class="input_wrap">
                        <label for=""><p>КОНТАКТНЫЙ НОМЕР</p></label>
                        <input id="mobile" name="mobile" required class="mobile_input" type="text"
                               placeholder="8 911 123 45 67">
                    </div>
                </div>
                <div class="input_wrap">
                    <label for=""><p>КОММЕТАРИЙ</p></label>
                    <input id="comment" name="comment" required type="text" placeholder="При необходимости">
                </div>
            </div>

            <button type="submit" class="link-bg fern">Отправить</button>
        </form>

        <p class="off_info_wrap">
            «Нажимая на кнопку, вы даете согласие на обработку
            персональных данных и соглашаетесь c политикой конфиденциальности»
        </p>
    @else
        <h2>Спасибо!</h2>
        <p class="info">
            Мы свяжемся с Вами в ближайшее время!
        </p>
    @endif

</div>
