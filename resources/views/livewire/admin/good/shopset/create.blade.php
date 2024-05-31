<div>

    <form name="add-blog-post-form" class="p-3 mt-3" id="add-blog-post-form"
          method="post"
          wire:submit="createShopset(Object.fromEntries(new FormData($event.target)))">
        @csrf
        <h1 style="font-size: 1.8rem;" class="mb-3 pb-3 border-bottom">Добавление шопсета</h1>

        <div class="form-group">
            <label for="exampleInputEmail1">Название</label>
            <input type="name" id="title" name="title" class="form-control">
        </div>

        <div class="form-group">
            <label>Выберите сотрудника создателя</label>
            <select class="form-control"
                    name="staff_id" aria-hidden="true">
                @if(!($staffs ?? null))
                    <option value="" hidden>Не выбрано</option>
                @endif
                @foreach($staffs as $staff)
                    <option value="{{$staff['id']}}">{{$staff['yc_name']}}
                    </option>
                @endforeach
            </select>
        </div>

        <input type="file"
               wire:model.live="pic_shopset"
               class="filepond"
               name="pic_shopset"
               id="pic_shopset"
               data-allow-reorder="true"
               data-max-file-size="3MB"
               data-max-files="3">

        <button type="submit" class="w-100 show_preloader_on_click btn btn-outline-primary">Сохранить</button>

    </form>


    <script>

        function filepond_trigger() {

            $('#pic_shopset').filepond({
                allowMultiple: false,
                allowImageValidateSize: true,
                allowFileTypeValidation: true,
                imageValidateSizeMinWidth: 300,
                imageValidateSizeMinHeight: 300,
                imageValidateSizeLabelImageSizeTooBig: 'размер изображения не верный!',
                imageValidateSizeLabelImageSizeTooSmall: 'размер изображения не верный!',
                acceptedFileTypes: ['image/png', 'image/jpeg'],

                server: {
                    url: '/temp-uploads/pic_shopset',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                },
                labelIdle: 'Обложка шопсета | (min: 300x300) | png/jpg',
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
