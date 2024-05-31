<div>
    <div style="max-width: 1000px;" class="p-3 card">
        <div class="card-body p-0">
            <div x-data="{ open: false }" class="p-3 border-bottom">

                <a @click.prevent="open = !open" id="new_promo_button" class="w-100 btn btn-outline-secondary">
                <span x-show="!open">
                    <i class="mr-2 fa fa-plus"></i>
                        Добавить фото
                </span>
                    <span x-show="open">
                        Свернуть
                </span>
                </a>

                <form x-show="open" wire:key="1" x-show="open" name="add-blog-post-form" class="mt-3"
                      id="add-blog-post-form"
                      method="post"
                      wire:submit="createInteriorPhoto(Object.fromEntries(new FormData($event.target)))">
                    @csrf
                    <div id="filepond_wrap" wire:ignore>
                        <input
                            type="file"
                            class="filepond"
                            multiple
                            name="interior_pic"
                            data-allow-reorder="true"
                            data-max-file-size="30MB"
                            data-max-files="10">
                    </div>
                    <button type="submit" class="show_preloader_on_click btn btn-outline-primary">Сохранить</button>
                </form>
            </div>

            <div wire:sortable="updateOrder" class="interior_pics_wrap">
                @foreach($interior_photos as $interior_photo)
                    <div class="interior_pic_wrap" wire:sortable.item="{{$interior_photo['id']}}"
                         wire:key="{{$interior_photo['id']}}">
                        <div class="p-2 buttons">
                            <div wire:sortable.handle style="white-space: nowrap"
                                 class="d-flex align-items-center">
                                 <span class="grabbable handle ui-sortable-handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                 </span>
                            </div>
                            <button wire:click.prevent="delete_confirm({{$interior_photo['id']}})"
                                    class="filepond--file-action-button filepond--action-revert-item-processing"
                                    type="button" data-align="right"
                                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1); opacity: 1;">
                                <svg width="26" height="26" viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.586 13l-2.293 2.293a1 1 0 0 0 1.414 1.414L13 14.414l2.293 2.293a1 1 0 0 0 1.414-1.414L14.414 13l2.293-2.293a1 1 0 0 0-1.414-1.414L13 11.586l-2.293-2.293a1 1 0 0 0-1.414 1.414L11.586 13z"
                                        fill="currentColor" fill-rule="nonzero"></path>
                                </svg>
                                <span>Remove</span>
                            </button>

                        </div>
                        <div class="image_editable_wrap">
                            <img data-crop-component="refreshPromoEdit"
                                 data-crop-width="280"
                                 data-crop-height="440"
                                 style="width: 180px; height: 260px; object-fit: cover;"
                                 src="/{{$interior_photo['pic']}}" alt="">
                            <i class="image_edit_button fa-solid fa-pencil"></i>
                        </div>
                    </div>

                @endforeach
            </div>


        </div>
    </div>

    <style>
        .filepond--item {
            width: fit-content;
        }
    </style>

    @push('scripts')
        <script>

            function filepond_trigger() {

                function make_livewire_var() {
                @this.set("interior_pics", '');
                    var pics_array = []
                    $("[name='interior_pic']").each(function () {
                        pics_array.push($(this).val())
                    })
                @this.set("interior_pics", pics_array);
                }

                $('.filepond').filepond({
                    allowMultiple: true,
                    allowImageValidateSize: true,
                    imageValidateSizeMinWidth: 280,
                    imageValidateSizeMinHeight: 440,
                    imageValidateSizeLabelImageSizeTooBig: 'размер изображения не верный!',
                    imageValidateSizeLabelImageSizeTooSmall: 'размер изображения не верный!',
                    allowFileTypeValidation: true,
                    acceptedFileTypes: ['image/png', 'image/jpeg'],
                    file: [],
                    server: {
                        url: '/temp-uploads/interior_pic',
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

                    labelIdle: 'Можно несколько изображений | (min: 280x440) | png/jpg',
                    maxFileSize: '30MB',
                    maxTotalFileSize: '100MB',
                    labelMaxFileSizeExceeded: 'Размер превышен!',
                    labelMaxFileSize: 'Максимальный: {filesize}',
                    labelMaxTotalFileSizeExceeded: 'Сумма размеров превышена!',
                    labelMaxTotalFileSize: 'Максимум: {filesize}',
                    labelFileProcessingComplete: '',
                    labelTapToUndo: '',
                    labelFileProcessing: '',
                    labelTapToCancel: '',
                })

            };

            filepond_trigger();

            document.addEventListener('update_filepond', function () {
                $('.filepond--root').remove();
                input = "<input type='file' class='filepond' multiple name='interior_pic' data-allow-reorder='true' data-max-file-size='3MB' data-max-files='3'>"
                $('#filepond_wrap').append(input);
                filepond_trigger();
            })
            document.addEventListener('livewire:update', function () {
                main_js_trigger();
                $("[name='filepond']").attr('name', 'promo_pics');
                // $(':input').val('');
            })
        </script>
    @endpush

</div>
