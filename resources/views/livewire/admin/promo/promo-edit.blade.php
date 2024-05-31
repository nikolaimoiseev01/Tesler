<div>
    <div class="card">
        <div class="card-body">
            <form wire:key="edit_promo-{{$promo['id']}}"
                  action="editPromo(Object.fromEntries(new FormData($event.target)))"
                  x-show="open_{{$promo['id']}}"
                  name="add-blog-post-form"
                  class="edit_promo mt-3"
                  id="edit-blog-post-form"
                  method="post"
                  wire:submit="editPromo(Object.fromEntries(new FormData($event.target)))">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Заголовок</label>
                    <input value="{{$promo['title']}}" name="title" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Описание</label>
                    <textarea name="desc"
                              class="form-control">{{$promo['desc']}}</textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Текст ссылки</label>
                    <input type="text" value="{{$promo['link_text']}}"
                           id="link_text" name="link_text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Ссылка</label>
                    <input type="text" value="{{$promo['link']}}"
                           id="link" name="link" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Тип</label>
                    <input type="text" value="{{$promo['type']}}"
                           id="type" name="type" class="form-control">
                </div>
                <div>
                    <input type="text" name="promo_id" value="{{$promo['id']}}" style="display: none">

                    <div style="width: fit-content" id="pic_block_{{$promo['id']}}"
                         class="position-relative">
                        <label>Изображение акции</label>
                        <div class="image_editable_wrap">
                            <img data-crop-component="refreshPromoEdit"
                                 data-crop-media="promo_pics"
                                 data-crop-width="460"
                                 data-crop-height="280"
                                 style="max-width: 300px;"
                                 src="{{$src}}"
                                 alt="">
                            <i class="image_edit_button fa-solid fa-pencil"></i>
                        </div>

                        <a id="make_new_pic--{{$promo['id']}}" class="mt-3 make_new_pic btn btn-outline-primary">заменить</a>
                    </div>
                    <div style="display: none;" class="mt-2" id="new_pic_block_{{$promo['id']}}">
                        <input type="file"
                               class="filepond filepond_promo_edit"
                               name="promo_pics"
                               data-allow-reorder="true"
                               data-max-file-size="3MB"
                               data-max-files="3">

                    </div>

                    <button  type="submit" class="w-100 mt-3 show_preloader_on_click btn btn-outline-primary">Сохранить</button>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
        <script>

            function filepond_trigger() {

                $('.filepond').filepond({
                    allowMultiple: false,
                    allowImageValidateSize: true,
                    imageValidateSizeMinWidth: 460,
                    imageValidateSizeMinHeight: 280,
                    imageValidateSizeLabelImageSizeTooBig: 'размер изображения не верный!',
                    imageValidateSizeLabelImageSizeTooSmall: 'размер изображения не верный!',
                    allowFileTypeValidation: true,
                    acceptedFileTypes: ['image/png', 'image/jpeg'],

                    server: {
                        url: '/temp-uploads/promo_pics',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        }
                    },


                    labelIdle: 'Одно изображение акции | (min: 460x280px) | png/jpg',
                    maxFileSize: '10MB',
                    maxTotalFileSize: '20MB',
                    labelMaxFileSizeExceeded: 'Размер превышен!',
                    labelMaxFileSize: 'Максимальный: {filesize}',
                    labelMaxTotalFileSizeExceeded: 'Сумма размеров превышена!',
                    labelMaxTotalFileSize: 'Максимум: {filesize}',
                })

            };

            filepond_trigger();
            document.addEventListener('livewire:update', function () {
                filepond_trigger();
                main_js_trigger();
                $("[name='filepond']").attr('name', 'promo_pics');
                // $(':input').val('');
            })
        </script>

        <script>
            $('.make_new_pic').on('click', function () {
                id = $(this).attr('id').split('--')[1];
                $('#pic_block_' + id).hide()
                $('#new_pic_block_' + id).show();
                // @this.set("pic_old." + id, "");
                // $("[name='filepond']").attr('name', 'promo_pics')
            })

            document.addEventListener('update_filepond', function () {
                $('#add-blog-post-form .filepond--root').remove();
                $(document).ready(function () {
                    input = "<input type='file' class='filepond' name='promo_pics' data-allow-reorder='true' data-max-file-size='3MB' data-max-files='3'>"
                    $('#add-blog-post-form #filepond_wrap').append(input);
                    filepond_trigger();
                })
            })

        </script>
    @endpush
</div>
