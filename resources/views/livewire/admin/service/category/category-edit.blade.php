<div>
    <style>
        .filepond--item {
            width: fit-content;
        }
    </style>

    <div style="    margin-bottom: 500px; max-width: 1000px;" class="mb-3 card">
        <div class="card-body p-0">
            <form name="add-blog-post-form" class="p-3 mb-0" id="add-blog-post-form"
                  method="post"
                  wire:submit.prevent="editCategory(Object.fromEntries(new FormData($event.target)))">
                @csrf
                <input type="text" name="category_id" value="{{$category['id']}}" style="display: none">
                <div class="d-flex">
                    <div class="w-50 mr-2 form-group">
                        <label for="exampleInputEmail1">Название</label>
                        <input type="name" id="name" value="{{$category['name']}}" name="name" class="form-control">
                    </div>

                    <div class="w-50 form-group">
                        <label>Сфера</label>
                        <select name="scope_id" id="scope_id" class="form-control">
                            @foreach($scopes as $scope)
                                <option @if($scope['id'] == $category['scope_id']) selected
                                        @endif value="{{$scope['id']}}">{{$scope['name']}}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="w-50 mr-2 form-group">
                        <label for="exampleInputEmail1">Описание</label>
                        <textarea name="desc" class="form-control">{{$category['desc']}}</textarea>
                    </div>

                    <div class="w-50 form-group">
                        <label for="exampleInputEmail1">Заголовок блока</label>
                        <textarea name="block_title" class="form-control">{{$category['block_title']}}</textarea>
                    </div>
                </div>

                <div class="p-3 border">

                    <div>
                        <label for="">Примеры в категории</label>
                    </div>

                    <div wire:sortable="updateExamplesOrder" class="mb-3 overflow-auto d-flex">
                        @foreach($category->getMedia('category_examples') as $cat_example)
                            <div class="interior_pic_wrap" wire:sortable.item="{{$cat_example['id']}}"
                                 wire:key="example-{{$cat_example['id']}}">
                                <div class="p-2 buttons">
                                    <div wire:sortable.handle style="white-space: nowrap"
                                         class="d-flex align-items-center">
                                 <span class="grabbable handle ui-sortable-handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                 </span>
                                    </div>
                                    <button wire:click.prevent="delete_confirm({{$cat_example['id']}})"
                                            class="filepond--file-action-button filepond--action-revert-item-processing"
                                            type="button" data-align="right"
                                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1); opacity: 1;">
                                        <svg width="26" height="26" viewBox="0 0 26 26"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.586 13l-2.293 2.293a1 1 0 0 0 1.414 1.414L13 14.414l2.293 2.293a1 1 0 0 0 1.414-1.414L14.414 13l2.293-2.293a1 1 0 0 0-1.414-1.414L13 11.586l-2.293-2.293a1 1 0 0 0-1.414 1.414L11.586 13z"
                                                fill="currentColor" fill-rule="nonzero"></path>
                                        </svg>
                                        <span>Remove</span>
                                    </button>

                                </div>
                                <img class="m-2" style="max-width: 150px;" src="{{$cat_example->getFullUrl()}}" alt="">
                            </div>

                        @endforeach
                    </div>


                    <div wire:ignore id="input_cat_ex_block" class="mt-2">
                        <input type="file"
                               wire:model="category_examples"
                               class="filepond"
                               multiple
                               name="category_examples"
                               id="category_examples"
                               data-allow-reorder="true"
                               data-max-file-size="3MB"
                               data-max-files="3">

                    </div>

                    @push('scripts')
                        <script>
                            $('#add_cat_ex_link').on('click', function () {
                                $('#input_cat_ex_block').toggle();
                            })
                        </script>
                    @endpush
                </div>

                <label for="">Изображение на странице блока</label>
                <div style=" width: fit-content" id="pic_block_{{$category['id']}}"
                     class="position-relative">

                    <img style="max-width: 150px;" src="/{{$category['pic']}}"
                         alt="">
                    <a id="make_pic_block--{{$category['id']}}"
                       class="mt-3 mb-3 make_pic btn btn-outline-primary">заменить</a>
                </div>
                <div wire:ignore style="display: none;" class="mt-2" id="new_pic_block_{{$category['id']}}">
                    <input type="file"
                           wire:model="pic_category"
                           class="filepond"
                           name="pic_category"
                           id="pic_category"
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

                $('#pic_category').filepond({
                    allowMultiple: false,
                    allowImageValidateSize: true,
                    allowFileTypeValidation: true,
                    imageValidateSizeMinWidth: 610,
                    imageValidateSizeMinHeight: 700,
                    imageValidateSizeMaxWidth: 610,
                    imageValidateSizeMaxHeight: 700,
                    imageValidateSizeLabelImageSizeTooBig: 'размер изображения не верный!',
                    imageValidateSizeLabelImageSizeTooSmall: 'размер изображения не верный!',
                    acceptedFileTypes: ['image/png', 'image/jpeg'],

                    server: {
                        url: '/temp-uploads/pic_category',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        }
                    },
                    labelIdle: 'Изображение категории | 610х700 | png/jpg',
                    maxFileSize: '10MB',
                    maxTotalFileSize: '20MB',
                    labelMaxFileSizeExceeded: 'Размер превышен!',
                    labelMaxFileSize: 'Максимальный: {filesize}',
                    labelMaxTotalFileSizeExceeded: 'Сумма размеров превышена!',
                    labelMaxTotalFileSize: 'Максимум: {filesize}',
                })


                function make_livewire_var() {
                    var pics_array = []
                    $("[name='category_examples']").each(function () {
                        pics_array.push($(this).val())
                    })
                @this.set("category_examples", pics_array);
                }


                $('#category_examples').filepond({
                    allowMultiple: true,
                    allowImageValidateSize: true,
                    imageValidateSizeMinWidth: 288,
                    imageValidateSizeMinHeight: 440,
                    imageValidateSizeLabelImageSizeTooBig: 'размер изображения не верный!',
                    imageValidateSizeLabelImageSizeTooSmall: 'размер изображения не верный!',
                    allowFileTypeValidation: true,
                    acceptedFileTypes: ['image/png', 'image/jpeg'],

                    server: {
                        url: '/temp-uploads/category_examples',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        }
                    },
                    onprocessfile: (file) => {
                        make_livewire_var()
                    },
                    onremovefile: (file) => {
                        make_livewire_var()
                    },
                    onreorderfiles: (file) => {
                        make_livewire_var()
                    },
                    labelIdle: 'Добавить примеры категории | (min: 288x440) | png/jpg',
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

            document.addEventListener('update_filepond', function () {
                $('.filepond--root').remove();
                $(document).ready(function () {
                    input = "<input type='file' wire:model='category_examples' class='filepond' multiple name='category_examples' id='category_examples' data-allow-reorder='true' data-max-file-size='3MB' data-max-files='3'>"
                    $('#input_cat_ex_block').append(input);
                    filepond_trigger();
                })
            })
        </script>


        <script>
            $('.make_pic').on('click', function () {
                id = $(this).attr('id').split('--')[1];
                $('#pic_block_' + id).hide()
                $('#new_pic_block_' + id).show();
                // @this.set("pic_old." + id, "");
                // $("[name='filepond']").attr('name', 'promo_pics')
            })

            document.addEventListener('close_form_edit', function () {
                $('.edit_promo').hide();
            })
        </script>
    @endpush
</div>
