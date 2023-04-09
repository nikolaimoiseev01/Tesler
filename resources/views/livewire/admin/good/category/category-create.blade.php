<div>


    <form name="add-blog-post-form" class="p-3 mt-3" id="add-blog-post-form"
          method="post"
          wire:submit.prevent="creategoodcategory(Object.fromEntries(new FormData($event.target)))">
        @csrf
        <h1 style="font-size: 1.8rem;" class="mb-3 pb-3 border-bottom">Добавление категории</h1>

        <div class="form-group">
            <label for="exampleInputEmail1">Название</label>
            <input type="name" id="title" name="title" class="form-control">
        </div>

        <input type="file"
               wire:model="pic_goodcategory"
               class="filepond"
               name="pic_goodcategory"
               id="pic_goodcategory"
               data-allow-reorder="true"
               data-max-file-size="3MB"
               data-max-files="3">

        <input type="file"
               wire:model="pic_goodcategory_small"
               class="filepond"
               name="pic_goodcategory_small"
               id="pic_goodcategory_small"
               data-allow-reorder="true"
               data-max-file-size="3MB"
               data-max-files="3">

        <button type="submit" class="w-100 show_preloader_on_click btn btn-outline-primary">Сохранить</button>

    </form>


    <script>

        function filepond_trigger() {

            $('#pic_goodcategory').filepond({
                allowMultiple: false,
                allowImageValidateSize: true,
                allowFileTypeValidation: true,
                imageValidateSizeMinWidth: 1700,
                imageValidateSizeMinHeight: 500,
                imageValidateSizeLabelImageSizeTooBig: 'размер изображения не верный!',
                imageValidateSizeLabelImageSizeTooSmall: 'размер изображения не верный!',
                acceptedFileTypes: ['image/png', 'image/jpeg'],

                server: {
                    url: '/temp-uploads/pic_goodcategory',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                },
                labelIdle: 'Обложка категории | (min: 1700x500) | png/jpg',
                maxFileSize: '10MB',
                maxTotalFileSize: '20MB',
                labelMaxFileSizeExceeded: 'Размер превышен!',
                labelMaxFileSize: 'Максимальный: {filesize}',
                labelMaxTotalFileSizeExceeded: 'Сумма размеров превышена!',
                labelMaxTotalFileSize: 'Максимум: {filesize}',
            })

            $('#pic_goodcategory_small').filepond({
                allowMultiple: false,
                allowImageValidateSize: true,
                allowFileTypeValidation: true,
                imageValidateSizeMinWidth: 350,
                imageValidateSizeMinHeight: 350,
                imageValidateSizeLabelImageSizeTooBig: 'размер изображения не верный!',
                imageValidateSizeLabelImageSizeTooSmall: 'размер изображения не верный!',
                acceptedFileTypes: ['image/png', 'image/jpeg'],

                server: {
                    url: '/temp-uploads/pic_goodcategory_small',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                },
                labelIdle: 'Изображение категории для фильтров | (min: 350x350) | png/jpg',
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
