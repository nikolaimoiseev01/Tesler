<div>
    <form wire:key="1" x-show="open" name="add-blog-post-form" class="p-3 mt-3" id="add-blog-post-form"
          method="post"
          wire:submit="createScope(Object.fromEntries(new FormData($event.target)))">
        @csrf
        <h1 style="font-size: 1.8rem;" class="mb-3 pb-3 border-bottom">Добавление сферы</h1>
        <div class="form-group">
            <label for="exampleInputEmail1">Название</label>
            <input type="name" id="name" name="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Описание</label>
            <textarea name="desc" class="form-control"></textarea>
        </div>

        <input type="file"
               wire:model.live="pic_scope_main_page"
               class="filepond"
               name="pic_scope_main_page"
               id="pic_scope_main_page"
               data-allow-reorder="true"
               data-max-file-size="3MB"
               data-max-files="3">

        <input type="file"
               wire:model.live="pic_scope_page"
               class="filepond"
               name="pic_scope_page"
               id="pic_scope_page"
               data-allow-reorder="true"
               data-max-file-size="3MB"
               data-max-files="3">


        <button type="submit" class="w-100 show_preloader_on_click btn btn-outline-primary">Сохранить</button>

    </form>


        <script>

            function filepond_trigger() {

                $('#pic_scope_main_page').filepond({
                    allowMultiple: false,
                    allowImageValidateSize: true,
                    allowFileTypeValidation: true,
                    acceptedFileTypes: ['image/png', 'image/jpeg'],

                    server: {
                        url: '/temp-uploads/pic_scope_main_page',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        }
                    },
                    labelIdle: 'Изображение сферы (главная страница) | png/jpg',
                    maxFileSize: '10MB',
                    maxTotalFileSize: '20MB',
                    labelMaxFileSizeExceeded: 'Размер превышен!',
                    labelMaxFileSize: 'Максимальный: {filesize}',
                    labelMaxTotalFileSizeExceeded: 'Сумма размеров превышена!',
                    labelMaxTotalFileSize: 'Максимум: {filesize}',
                })

                $('#pic_scope_page').filepond({
                    allowMultiple: false,
                    allowImageValidateSize: true,
                    allowFileTypeValidation: true,
                    acceptedFileTypes: ['image/png', 'image/jpeg'],

                    server: {
                        url: '/temp-uploads/pic_scope_page',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        }
                    },
                    labelIdle: 'Изображение сферы (страница сферы) | (460x280) | png/jpg',
                    maxFileSize: '10MB',
                    maxTotalFileSize: '20MB',
                    labelMaxFileSizeExceeded: 'Размер превышен!',
                    labelMaxFileSize: 'Максимальный: {filesize}',
                    labelMaxTotalFileSizeExceeded: 'Сумма размеров превышена!',
                    labelMaxTotalFileSize: 'Максимум: {filesize}',
                })

            };

            filepond_trigger();

            document.addEventListener('filepond_trigger', function () {
                 filepond_trigger();
            })

            document.addEventListener('livewire:update', function () {
                // filepond_trigger();
                main_js_trigger();
                $("[name='filepond']").attr('name', 'promo_pics');
                // $(':input').val('');
            })
        </script>

</div>
