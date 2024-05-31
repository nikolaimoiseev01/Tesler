<div>
    <style>
        .select2 {
            width: 100% !important;
        }

        .filepond--item {
            width: fit-content;
        }

    </style>
    <div style="max-width: 1400px;" class="card">
        <div class="d-flex align-items-center card-header p-2">
            <div>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="#site_info" data-toggle="tab">
                            На сайте
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#yc_info" data-toggle="tab">
                            Получено от YC_Clients
                        </a>
                    </li>
                </ul>
            </div>

            <div class="align-items-center d-flex ml-auto">
                <a target="_blank" href="{{route('service_page', $service['id'])}}" class="mr-3 link">Страница на
                    сайте</a>

                <div class="m-0 d-inline mr-3 form-group">
                    <select wire:model.live="service_type" class="form-control"
                            aria-hidden="true" id="group">
                        @if(!($service_type ?? null))
                            <option value="" hidden>Выберите тип</option>
                        @endif
                        @foreach($service_types as $service_type)
                            <option value="{{$service_type['id']}}">{{$service_type['name']}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="d-inline">
                    <div class="d-flex ml-auto">

                        @if($service['flg_active'] ?? 0 == 1)
                            <p class="mr-2" style="color: #1ac71a">есть на сайте</p>
                        @else
                            <p class="mr-2" style="color: grey">неактивна</p>
                        @endif
                        <label class="mb-0 float-right relative inline-flex items-center cursor-pointer">

                            <input wire:model.live="flg_active" wire:change="toggleActivity" type="checkbox" value=""
                                   class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>

                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="tab-content">
                <div class="tab-pane active" id="site_info" tabindex="-1">
                    <form wire:submit="editService(Object.fromEntries(new FormData($event.target)))">
                        @csrf
                        <div class="row">

                            <div class="col-md-6 form-group">
                                <label for="exampleInputEmail1">Название</label>
                                <input wire:model.live="name" type="text" class="form-control"
                                       id="exampleInputEmail1"
                                       placeholder="Имя услуги">
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Сфера</label>
                                    <select wire:model.live="scope" class="form-control"
                                            aria-hidden="true" id="scope">
                                        @if(!($scope ?? null))
                                            <option value="" hidden>Выберите сферу</option>
                                        @endif
                                        @foreach($scopes as $scope)
                                            <option value="{{$scope['id']}}">{{$scope['name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Категория</label>
                                    <select wire:model.live="category" class="form-control"
                                            name="category_id" aria-hidden="true">
                                        @if(!($category ?? null))
                                            <option value="" hidden>Выберите категорию</option>
                                        @endif
                                        @foreach($categories as $category)
                                            <option value="{{$category['id']}}">{{$category['name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Группа</label>
                                    <select wire:model.live="group" class="form-control"
                                            aria-hidden="true" id="group">
                                        @if(!($group ?? null))
                                            <option value="" hidden>Выберите группу</option>
                                        @endif
                                        @foreach($groups as $group)
                                            <option value="{{$group['id']}}">{{$group['name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div wire:ignore class="form-group">
                                    <label>Основное изображение</label>
                                    <div class="custom-file">
                                        <input wire:model.live="pic_main" type="file" class="custom-file-input"
                                               name="pic_main">
                                        <label class="custom-file-label" id="label_pic_main" for="exampleInputFile">
                                            Загрузить изображение <strong>(название на англиском)</strong> <strong>(мин-выс:
                                                400px; мин-шир: 610px;)</strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="desc_small">Описание маленькое</label>
                                    <textarea wire:model.live="desc_small" name="desc_small" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Описание</label>
                                    <textarea wire:model.live="desc" name="desc" class="form-control"></textarea>
                                </div>
                                <div wire:ignore class="form-group">
                                    <label>Изображение процесса</label>
                                    <div class="custom-file">
                                        <input wire:model.live="pic_proccess" type="file" class="custom-file-input"
                                               name="pic_process">
                                        <label class="custom-file-label" id="label_pic_process" for="exampleInputFile">
                                            Загрузить изображение <strong>(название на англиском)</strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Процесс</label>
                                    <textarea wire:model.live="proccess" class="form-control"></textarea>
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail1">Результат</label>
                                    <textarea wire:model.live="result" class="form-control"></textarea>
                                </div>
                            </div>


                            <div class="d-flex flex-col justify-content-centerы col-md-3">
                                @if($service->getMedia('pic_main')->count() == 1)
                                    <div>
                                        <label for="">Главное изображение</label>
                                        <div class="m-3 image_editable_wrap">
                                            <img data-crop-component="refreshPromoEdit"
                                                 data-crop-media="pic_main"
                                                 data-crop-width="610"
                                                 data-crop-height="400"
                                                 style="max-width: 80%; height: fit-content; max-height: 200px; object-fit: contain;" class="col-sm-6"
                                                 src="{{$src_main}}"
                                                 alt="">
                                            <i class="image_edit_button fa-solid fa-pencil"></i>
                                        </div>
                                    </div>
                                @endif
                                @if($service->getMedia('pic_proccess')->count() == 1)
                                    <div>
                                        <label for="">Изображение процесса</label>
                                        <div class="m-3 image_editable_wrap">
                                            <img data-crop-component="refreshServiceEdit"
                                                 data-crop-media="pic_proccess"
                                                 data-crop-width="610"
                                                 data-crop-height="400"
                                                 style="max-width: 80%; height: fit-content; max-height: 200px; object-fit: contain;" class="m-3"
                                                 src="{{$src_proccess}}"
                                                 alt="">
                                            <i class="image_edit_button fa-solid fa-pencil"></i>
                                        </div>

                                    </div>
                                @endif


                            </div>

                        </div>

                        <button type="submit" class="w-100 show_preloader_on_click btn btn-outline-primary">Сохранить
                        </button>
                    </form>
                </div> {{-- End of tab content--}}

                <div class="tab-pane" id="yc_info" tabindex="-1">
                    <a class="mb-3 show_preloader_on_click btn btn-outline-primary"
                       wire:click.prevent="refresh_from_yc">Обновить из YClients</a>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td style="font-weight: bold">YC_ID</td>
                            <td>
                                {{$service['yc_id']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Название из YC</td>
                            <td>
                                {{$service['yc_title']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Категория из YC</td>
                            <td>
                                {{$service['yc_category_name']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Коммент из YC</td>
                            <td>
                                {{$service['yc_comment']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">YC_Price_Min</td>
                            <td>
                                {{$service['yc_price_min']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">YC_Price_Max</td>
                            <td>
                                {{$service['yc_price_max']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Длительность из YC</td>
                            <td>
                                {{$service['yc_duration']}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div style="max-width: 1400px;" class="card">
        <div class="d-flex align-items-center card-header p-2">
            <h1 style="font-size: 22px;" class="ml-3">Блок дополнительных услуг</h1>
        </div>
        <div class="card-body">
            <div class="row">
                @if($service['service_type_id'] == 1 || $service['service_type_id'] == 2)
                    <div class="col-md-6">
                        <div class="p-3 border">
                            <label for="exampleInputEmail1">К этой услуге идут допы:</label>
                            <div class="gap-3 d-flex flex-wrap">
                                @foreach($this->service_adds as $service_add)
                                    <span wire:key="service_add_{{collect($service_add)['id']}}">
                                            <a target="_blank"
                                               href="{{route('service.edit', collect($service_add)['added_id'])}}">{{collect($service_add)['name']}}</a>
                                            <a wire:click.prevent="delete_service_add({{collect($service_add)['id']}})"
                                               href="">
                                            <i class="fa-solid fa-xmark"></i>
                                            </a>
                                        </span>
                                @endforeach
                            </div>
                            <div class="mt-3 form-group">
                                <select wire:ignore class="select2 form-control"
                                        aria-hidden="true" id="service_to_add">
                                    @foreach($all_service_adds as $all_service_add)
                                        <option
                                            value="{{$all_service_add['id']}}">{{$all_service_add['name']}}
                                        </option>
                                    @endforeach
                                </select>
                                <a type="submit" wire:click.prevent="new_service_add"
                                   class="mt-3 show_preloader_on_click btn btn-outline-primary">
                                    Добавить
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                @if($service['service_type_id'] == 2 || $service['service_type_id'] == 3)
                    <div class="col-md-6">
                        <div class="p-3 border">
                            <label for="exampleInputEmail1">Эта услуга идет допом к:</label>
                            <div class="gap-3 d-flex flex-wrap">
                                @foreach($this->service_added_to as $service_added_to)
                                    <span wire:key="added_to_{{collect($service_added_to)['id']}}">
                                            <a target="_blank"
                                               href="{{route('service.edit', collect($service_added_to)['added_id'])}}">{{collect($service_added_to)['name']}}</a>
                                            <a wire:click.prevent="delete_service_add({{collect($service_added_to)['id']}})"
                                               href="">
                                            <i class="fa-solid fa-xmark"></i>
                                            </a>
                                        </span>
                                @endforeach
                            </div>
                            <div class="mt-3 form-group">
                                <select wire:ignore class="select2 form-control"
                                        aria-hidden="true" id="service_add_to">
                                    @foreach($all_service_added_to as $all_service_added_to)
                                        <option
                                            value="{{$all_service_added_to['id']}}">{{$all_service_added_to['name']}}
                                        </option>
                                    @endforeach
                                </select>
                                <a type="submit" wire:click.prevent="new_service_added_to"
                                   class="mt-3 show_preloader_on_click btn btn-outline-primary">
                                    Добавить
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div style="max-width: 1400px;" class="card">
        <div class="d-flex align-items-center card-header p-2">
            <h1 style="font-size: 22px;" class="ml-3">Фото примеров этой услуги</h1>
        </div>
        <div class="card-body">
            <div wire:sortable="updateExamplesOrder" class="mb-3 overflow-auto d-flex">
                @foreach($service->getMedia('service_examples') as $service_example)
                    <div class="interior_pic_wrap" wire:sortable.item="{{$service_example['id']}}"
                         wire:key="example-{{$service_example['id']}}">
                        <div class="p-2 buttons">
                            <div wire:sortable.handle style="white-space: nowrap"
                                 class="d-flex align-items-center">
                                 <span class="grabbable handle ui-sortable-handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                 </span>
                            </div>
                            <button wire:click.prevent="delete_example_confirm({{$service_example['id']}})"
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
                            <img data-crop-component="refreshServiceEdit"
                                 data-crop-width="280"
                                 data-crop-height="440"
                                 class="m-2" style="max-width: 150px;" src="{{$service_example->getFullUrl()}}" alt="">
                            <i class="image_edit_button fa-solid fa-pencil"></i>
                        </div>

                    </div>

                @endforeach
            </div>
            <div wire:ignore id="filepond_wrap" class="mt-2">
                <input type="file"
                       wire:model.live="service_examples"
                       class="filepond"
                       multiple
                       name="service_examples"
                       id="service_examples"
                       data-allow-reorder="true"
                       data-max-file-size="30MB"
                       data-max-files="30">

            </div>
            <a type="submit" wire:click.prevent="new_service_examples"
               class="mt-3 show_preloader_on_click btn btn-outline-primary">
                Сохранить примеры
            </a>
        </div>
    </div>

    @push('scripts')

        <script>

            $('#service_to_add').on('change', function () {
            @this.set('service_to_add', $(this).val());
            })

            $('#service_add_to').on('change', function () {
            @this.set('service_add_to', $(this).val());
            })


            //
            // $('#category').on('change', function () {
            //     @this.set('category', $(this).val());
            // })

            function page_js_trigger() {
                $('.select2').select2()
            }

            page_js_trigger()


            document.addEventListener('livewire:update', function () {
                // filepond_trigger();
                main_js_trigger();
                page_js_trigger();
                // $(':input').val('');
            })

            function make_livewire_var() {
                var pics_array = []
                $("[name='service_examples']").each(function () {
                    pics_array.push($(this).val())
                })
                console.log(pics_array)
            @this.set("service_examples", pics_array);
            }

            function filepond_trigger() {


                $('#service_examples').filepond({
                    allowMultiple: true,
                    allowImageValidateSize: true,
                    imageValidateSizeMinWidth: 280,
                    imageValidateSizeMinHeight: 440,
                    allowImageResize: true,
                    imageResizeTargetWidth: 576,
                    imageResizeTargetHeight: 880,
                    imageValidateSizeLabelImageSizeTooBig: 'размер изображения не верный!',
                    imageValidateSizeLabelImageSizeTooSmall: 'размер изображения не верный!',
                    allowFileTypeValidation: true,
                    // acceptedFileTypes: ['image/png', 'image/jpeg', 'image/heic'],
                    server: {
                        url: '/temp-uploads/service_examples',
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
                    labelIdle: 'Добавить примеры услуги | (min: 288x440) | png/jpg',
                    maxFileSize: '30MB',
                    maxTotalFileSize: '100MB',
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
            document.addEventListener('update_filepond', function () {
                $(document).ready(function () {
                    $('.filepond--root').remove();
                    setTimeout(function () {
                        input = "<input type='file' wire:model.live='service_examples' class='filepond' multiple name='service_examples' id='service_examples' data-allow-reorder='true' data-max-file-size='3MB' data-max-files='3'>"
                        $('#filepond_wrap').append(input);
                        filepond_trigger();
                    }, 500)
                })
            })
        </script>
    @endpush
</div>
