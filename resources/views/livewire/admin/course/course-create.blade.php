<div>
    <form name="add-blog-post-form" class="p-3 mt-3" id="add-blog-post-form"
          method="post"
          wire:submit.prevent="createCourse(Object.fromEntries(new FormData($event.target)))">
        @csrf
        <h1 style="font-size: 1.8rem;" class="mb-3 pb-3 border-bottom">Добавление курса</h1>
        <div class="form-group">
            <label for="exampleInputEmail1">Название</label>
            <input wire:model="title" class="form-control">
        </div>



        <button type="submit" class="w-100 show_preloader_on_click btn btn-outline-primary">Сохранить</button>

    </form>

    <script>
        function page_js_trigger() {
            $('.select2').select2()
        }

        page_js_trigger()

        document.addEventListener('livewire:update', function () {
            // filepond_trigger();
            main_js_trigger();
            page_js_trigger();
            // $(':input').val('');
        })

        document.addEventListener('livewire:update', function () {
            // filepond_trigger();
            main_js_trigger();
            page_js_trigger();
            // $(':input').val('');
        })
    </script>

</div>
