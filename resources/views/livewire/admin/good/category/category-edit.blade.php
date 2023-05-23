<div>
    <form name="add-blog-post-form"
          method="post"
          class="p-3 mt-3"
          wire:submit.prevent="editgoodcategory(Object.fromEntries(new FormData($event.target)))">
        @csrf
        <h1 style="font-size: 1.8rem;" class="mb-3 pb-3 border-bottom">Редактирование категории</h1>
        <div class="form-group">
            <label for="exampleInputEmail1">Название</label>
            <input type="name" id="title" name="title" value="{{$title}}" class="form-control">
        </div>

        <div x-data="{ open: false }">


            <div x-show="!open" style="width: fit-content"
                 class="position-relative">
                <label for="">Обложка категории на ее страницы</label>
                @if($goodcategory->getFirstMediaUrl('pic_goodcategory'))
                    <div class="image_editable_wrap">
                        <img data-crop-component="refreshGoodCategoryEdit"
                             data-crop-width="1700"
                             data-crop-height="500"
                             style="max-height: 400px; width: auto;"
                             src="{{$goodcategory->getFirstMediaUrl('pic_goodcategory')}}"
                             alt="">
                        <i class="image_edit_button fa-solid fa-pencil"></i>
                    </div>
                @endif
                <a @click.prevent="open = true"
                   class="mt-3 mb-3 make_pic_main_page_block btn btn-outline-primary">заменить</a>
            </div>

            <div x-show="open">
                <input
                    type="file"
                    class="filepond"
                    name="pic_goodcategory"
                    id="pic_goodcategory"
                    data-allow-reorder="true"
                    data-max-file-size="30MB"
                    data-max-files="30">
            </div>
        </div>


        <div @if($goodcategory->getFirstMediaUrl('pic_goodcategory_small'))
             x-data="{ open: false }"
             @else
             x-data="{ open: true }"
            @endif
        >


            <div x-show="!open" style="width: fit-content"
                 class="position-relative">
                <label for="">Изображение категории в фильтрах</label>
                @if($goodcategory->getFirstMediaUrl('pic_goodcategory_small'))
                    <div class="image_editable_wrap">
                        <img data-crop-component="refreshGoodCategoryEdit"
                             data-crop-width="350"
                             data-crop-height="350"
                             style="max-height: 400px; width: auto;"
                             src="{{$goodcategory->getFirstMediaUrl('pic_goodcategory_small')}}"
                             alt="">
                        <i class="image_edit_button fa-solid fa-pencil"></i>
                    </div>
                @endif
                <a @click.prevent="open = true"
                   class="mt-3 mb-3 make_pic_main_page_block btn btn-outline-primary">заменить</a>
            </div>

            <div x-show="open">
                <input
                    type="file"
                    class="filepond"
                    name="pic_goodcategory_small"
                    id="pic_goodcategory_small"
                    data-allow-reorder="true"
                    data-max-file-size="30MB"
                    data-max-files="30">
            </div>
        </div>


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
                imageCropAspectRatio: 1,
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
                imageValidateSizeMinWidth:200,
                imageValidateSizeMinHeight: 200,
                imageCropAspectRatio: 1,
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

        // $(document).ready(function() {
        //     console.log('525')
        // })
        filepond_trigger();


        document.addEventListener('filepond_trigger', function () {
            filepond_trigger();
        })

        document.addEventListener('livewire:update', function () {
            // filepond_trigger();
            main_js_trigger();
            // $(':input').val('');
        })
    </script>

</div>
