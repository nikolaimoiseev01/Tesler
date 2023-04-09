<div>
    <form wire:key="1" x-show="open" name="add-blog-post-form" class="p-3 mt-3" id="add-blog-post-form"
          method="post"
          wire:submit.prevent="editScope(Object.fromEntries(new FormData($event.target)))">
        @csrf
        <input type="text" name="scope_id" value="{{$scope['id']}}" style="display: none">
        <h1 style="font-size: 1.8rem;" class="mb-3 pb-3 border-bottom">Изменение сферы</h1>
        <div class="form-group">
            <label for="exampleInputEmail1">Название</label>
            <input type="name" id="name" value="{{$scope['name']}}" name="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Описание</label>
            <textarea name="desc" class="form-control">{{$scope['desc']}}</textarea>
        </div>

        <div style="width: fit-content" id="pic_main_page_block_{{$scope['id']}}"
             class="position-relative">
            <label for="">Фото на главной странице</label>
            <img style="max-width: 100px;" src="/{{$scope['pic_main_page']}}"
                 alt="">
            <a id="make_pic_main_page_block--{{$scope['id']}}" class="mt-3 mb-3 make_pic_main_page_block btn btn-outline-primary">заменить</a>
        </div>

        <div style="display: none;" class="mt-2" id="new_pic_main_page_block_{{$scope['id']}}">
            <input type="file"
                   wire:model="pic_scope_main_page"
                   class="filepond"
                   name="pic_scope_main_page"
                   id="pic_scope_main_page"
                   data-allow-reorder="true"
                   data-max-file-size="3MB"
                   data-max-files="3">

        </div>

        <div style="width: fit-content" id="pic_scope_page_block_{{$scope['id']}}"
             class="position-relative">
            <label for="">Фото на странице сферы</label>
            <img style="max-width: 300px;" src="/{{$scope['pic_scope_page']}}"
                 alt="">
            <a id="make_pic_scope_page_block--{{$scope['id']}}" class="mt-3 mb-3 make_pic_scope_page_block btn btn-outline-primary">заменить</a>
        </div>
        <div style="display: none;" class="mt-2" id="new_pic_scope_page_block_{{$scope['id']}}">
            <input type="file"
                   wire:model="pic_scope_page"
                   class="filepond"
                   name="pic_scope_page"
                   id="pic_scope_page"
                   data-allow-reorder="true"
                   data-max-file-size="3MB"
                   data-max-files="3">
        </div>



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
                labelIdle: 'Изображение сферы (страница сферы) | png/jpg',
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


    <script>
        $('.make_pic_main_page_block').on('click', function () {
            id = $(this).attr('id').split('--')[1];
            $('#pic_main_page_block_' + id).hide()
            $('#new_pic_main_page_block_' + id).show();
            // @this.set("pic_old." + id, "");
            // $("[name='filepond']").attr('name', 'promo_pics')
        })

        $('.make_pic_scope_page_block').on('click', function () {
            id = $(this).attr('id').split('--')[1];
            $('#pic_scope_page_block_' + id).hide()
            $('#new_pic_scope_page_block_' + id).show();
            // @this.set("pic_old." + id, "");
            // $("[name='filepond']").attr('name', 'promo_pics')
        })

        document.addEventListener('close_form_edit', function () {
            $('.edit_promo').hide();
        })
    </script>
</div>
