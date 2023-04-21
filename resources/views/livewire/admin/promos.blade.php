<div>
    <div style="max-width: 1000px;" class="card">
        <div class="card-body p-0">
            <ul wire:sortable="updateOrder" class="products-list product-list-in-card pl-2 pr-2">
                @foreach($promos as $promo)
                    <li x-data="{ open_{{$promo['id']}}: false }" wire:sortable.item="{{$promo['id']}}"
                        wire:key="promo-{{$promo['id']}}" class="item">
                        <div class="d-flex align-items-center">
                            <div wire:sortable.handle style="white-space: nowrap"
                                 class="d-flex mr-3 ml-3 align-items-center">
                                 <span class="grabbable handle ui-sortable-handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                 </span>
                            </div>
                            <div class="mr-3 product-img">
                                <img style="width: auto;" src="{{$promo->getFirstMediaUrl('promo_pics')}}" alt="">
                            </div>

                            <div class="ml-0 mr-3 product-info">
                                <a href="{{route('promo.edit', $promo['id'])}}" class="product-title">{{$promo['title']}}</a>
                                <span style="white-space: inherit;"
                                      class="product-description">{{$promo['desc']}}</span>
                            </div>
                            <div class="ml-auto mr-3">
                                <a href="{{route('promo.edit', $promo['id'])}}" class="mr-3">
                                    <i style="font-size: 18px;" class="fa-solid grey_icon fa-pen-to-square"></i>
                                </a>
                                <a>
                                    <i style="font-size: 18px;" wire:click.prevent="delete_confirm({{$promo['id']}})"
                                       class="fas grey_icon fa-trash-alt"></i>
                                </a>
                            </div>
                        </div>

                    </li>
                @endforeach
            </ul>
        </div>
        <div x-data="{ open: false }" class="p-3 border-top">

            <a @click.prevent="open = !open" id="new_promo_button" class="w-100 btn btn-outline-secondary">
                <span x-show="!open">
                    <i class="mr-2 fa fa-plus"></i>
                        Добавить
                </span>
                <span x-show="open">
                        Свернуть
                </span>
            </a>
            <form wire:key="1" x-show="open" name="add-blog-post-form" class="mt-3" id="add-blog-post-form"
                  method="post"
                  wire:submit.prevent="createPromo(Object.fromEntries(new FormData($event.target)))">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Заголовок</label>
                    <input type="text" id="title" name="title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Описание</label>
                    <textarea name="desc" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Ссылка</label>
                    <input type="text" id="link" name="link" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Текст ссылки</label>
                    <input type="text" id="link_text" name="link_text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Тип</label>
                    <input type="text" id="type" name="type" class="form-control">
                </div>
                <div wire:ignore id="filepond_wrap">
                    <input type="file"
                           class="filepond"
                           name="promo_pics"
                           data-allow-reorder="true"
                           data-max-file-size="3MB"
                           data-max-files="3">
                </div>

                <button type="submit" class="w-100 show_preloader_on_click btn btn-outline-primary">Сохранить</button>

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

            document.addEventListener('close_form_edit', function () {
                $('.edit_promo').hide();
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
