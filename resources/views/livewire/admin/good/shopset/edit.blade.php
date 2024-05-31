<div>
    <div class="card">
        <div class="card-body">
            <form name="add-blog-post-form"
                  method="post"
                  wire:submit="editShopset(Object.fromEntries(new FormData($event.target)))">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Название</label>
                    <input type="name" id="title" name="title" value="{{$title}}" class="form-control">
                </div>

                <div class="form-group">
                    <label>Сотрудник создатель</label>
                    <select class="form-control"
                            name="staff_id" aria-hidden="true">
                        @if(!($staffs ?? null))
                            <option value="" hidden>Не выбрано</option>
                        @endif
                        @foreach($staffs as $staff)
                            <option @if($staff_id === $staff['id']) selected @endif value="{{$staff['id']}}">
                                {{$staff['yc_name']}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-1 mb-3 p-3 border">
                    <label for="exampleInputEmail1">Полная стоимость сета: {{$goods_in_shopset->sum('yc_price')}} ₽;
                        Включает в себя:</label>
                    <div class="gap-3 d-flex flex-wrap">
                        @foreach($goods_in_shopset as $good_in_shopset)
                            <span wire:key="good_{{$good_in_shopset['id']}}_in_shopset">
                                <a target="_blank"
                                   href="{{route('good.edit', $good_in_shopset['id'])}}">{{$good_in_shopset['name']}} ({{$good_in_shopset['yc_price']}} ₽)</a>
                                <a wire:click.prevent="delete_good_in_shopset({{$good_in_shopset['id']}})"
                                   href="">
                                <i class="fa-solid fa-xmark"></i>
                                </a>
                            </span>
                        @endforeach
                    </div>
                    <div class="mt-3 form-group">
                        <div wire:ignore>
                            <select wire:ignore class="select2 form-control"
                                    aria-hidden="true" id="good_to_add">
                                @foreach($all_goods as $good)
                                    <option
                                        value="{{$good['id']}}">{{$good['name']}} ({{$good['yc_price']}} ₽)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <a type="submit" wire:click.prevent="new_good_to_add()"
                           class="mt-3 show_preloader_on_click btn btn-outline-primary">
                            Добавить
                        </a>
                    </div>
                </div>

                <div x-data="{ open: false }">


                    <div x-show="!open" style="width: fit-content"
                         class="position-relative">
                        <label for="">Фото шопсета</label>
                        <div class="image_editable_wrap">
                            <img data-crop-component="refreshPromoEdit"
                                 data-crop-width="300"
                                 data-crop-height="300"
                                 style="max-height: 400px; width: auto;"
                                 src="{{$shopset->getFirstMediaUrl('pic_shopset')}}"
                                 alt="">
                            <i class="image_edit_button fa-solid fa-pencil"></i>
                        </div>
                        <a @click.prevent="open = true"
                           class="mt-3 mb-3 make_pic_main_page_block btn btn-outline-primary">заменить</a>
                    </div>

                    <div x-show="open">
                        <input
                            type="file"
                            wire:model.live="pic_shopset"
                            class="filepond"
                            name="pic_shopset"
                            id="pic_shopset"
                            data-allow-reorder="true"
                            data-max-file-size="3MB"
                            data-max-files="3">
                    </div>
                </div>


                <button type="submit" class="w-100 show_preloader_on_click btn btn-outline-primary">Сохранить</button>

            </form>
        </div>
    </div>


    @push('scripts')
        <script>

            $('#good_to_add').on('change', function () {
            @this.set('good_to_add', $(this).val());
            })

            function page_js_trigger() {
                $('.select2').select2()
            }

            page_js_trigger()

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
                    labelIdle: 'Обложка шопсета (главная страница) | (min: 300x300) | png/jpg',
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
