<div>
    <div style="max-width: 1000px;" class="card">
        <div class="card-body">


            <form name="add-blog-post-form" id="add-blog-post-form"
                  method="post"
                  wire:submit.prevent="createCategory(Object.fromEntries(new FormData($event.target)))">
                @csrf
                <div class="form-group">
                    <label>Сфера</label>
                    <select name="scope_id" id="scope_id" class="form-control">
                        <option value="" hidden>Выберите сферу категории</option>
                        @foreach($scopes as $scope)
                            <option value="{{$scope['id']}}">{{$scope['name']}}</option>
                        @endforeach

                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Название</label>
                    <input type="name" id="name" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Описание</label>
                    <textarea name="desc" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Заголовок блока</label>
                    <textarea name="block_title" class="form-control"></textarea>
                </div>


                <input type="file"
                       wire:model="pic_category"
                       class="filepond"
                       name="pic_category"
                       id="pic_category"
                       data-allow-reorder="true"
                       data-max-file-size="3MB"
                       data-max-files="3">

                <button type="submit" class="w-100 show_preloader_on_click btn btn-outline-primary">Сохранить</button>

            </form>
        </div>
    </div>

    @push('scripts')

        <script>

            function filepond_trigger() {

                $('#pic_category').filepond({
                    allowMultiple: false,
                    allowImageValidateSize: true,
                    allowFileTypeValidation: true,
                    acceptedFileTypes: ['image/png', 'image/jpeg'],

                    server: {
                        url: '/temp-uploads/pic_category',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        }
                    },
                    labelIdle: 'Изображение сферы (главная страница) | (460x280) | png/jpg',
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
    @endpush
</div>
