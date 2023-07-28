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
                <div class="d-flex">
                    <a target="_blank" class="mr-3 link" href="{{route('staff_page', $staff['yc_id'])}}">Страница на
                        сайте</a>
                    <div class="d-flex ml-auto">

                        @if($staff['flg_active'] ?? 0 == 1)
                            <p class="mr-2" style="color: #1ac71a">есть на сайте</p>
                        @else
                            <p class="mr-2" style="color: grey">неактивна</p>
                        @endif
                        <label class="mb-0 float-right relative inline-flex items-center cursor-pointer">

                            <input wire:model="flg_active" wire:change="toggleActivity" type="checkbox" value=""
                                   class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>

                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="site_info" tabindex="-1">
                    <form wire:submit.prevent="editstaff(Object.fromEntries(new FormData($event.target)))">
                        @csrf
                        {{--                        <div class="row">--}}
                        {{--                            <div class="col-md-10">--}}
                        {{--                                <div class="form-group">--}}
                        {{--                                    <label for="name">Название на сайте</label>--}}
                        {{--                                    <input wire:model="name" type="text" class="form-control"--}}
                        {{--                                           id="exampleInputEmail1"--}}
                        {{--                                           placeholder="Имя услуги">--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                            <div class="col-md-2">--}}
                        {{--                                <div class="form-group">--}}
                        {{--                                    <label>Категория</label>--}}
                        {{--                                    <select wire:model="category" class="form-control"--}}
                        {{--                                            name="category_id" aria-hidden="true">--}}
                        {{--                                        @if(!($category ?? null))--}}
                        {{--                                            <option value="" hidden>Выберите категорию</option>--}}
                        {{--                                        @endif--}}
                        {{--                                        @foreach($categories as $category)--}}
                        {{--                                            <option value="{{$category['id']}}">{{$category['name']}}--}}
                        {{--                                            </option>--}}
                        {{--                                        @endforeach--}}
                        {{--                                    </select>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}

                        {{--                        </div>--}}


                        <div class="form-group">
                            <label for="desc_small">Описание маленькое</label>
                            <textarea wire:model="desc_small" name="desc_small" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Описание</label>
                            <textarea wire:model="desc" name="desc" class="form-control"></textarea>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="desc_small">Шопсет в подборке</label>
                                <select wire:model="selected_shopset" class="select2 form-control"
                                        aria-hidden="true" id="selected_shopset">
                                    @if(!($selected_shopset ?? null))
                                        <option value="" hidden>Не выбрано</option>
                                    @endif
                                    @foreach($shopsets_all as $shopset)
                                        <option
                                            value="{{$shopset['id']}}">{{$shopset['title']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="exampleInputEmail1">Опыт</label>
                                <input wire:model="experience" type="text" class="form-control"
                                       id="experience"
                                       placeholder="Опыт">
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="desc_small">Сертификат в подборке</label>
                            <select wire:model="selected_sert" class="select2 form-control"
                                    aria-hidden="true" id="selected_sert">
                                @if(!($selected_sert ?? null))
                                    <option value="" hidden>Не выбрано</option>
                                @endif
                                @foreach($serts_all as $sert)
                                    <option
                                        value="{{$sert['id']}}">{{$sert['name']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-3">
                            <label for="desc_small">Абонемент в подборке</label>
                            <select wire:model="selected_abon" class="select2 form-control"
                                    aria-hidden="true" id="selected_abon">
                                @if(!($selected_abon ?? null))
                                    <option value="" hidden>Не выбрано</option>
                                @endif
                                @foreach($abon_all as $abon)
                                    <option
                                        value="{{$abon['id']}}">{{$abon['name']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="mt-3 w-100 show_preloader_on_click btn btn-outline-primary">
                            Сохранить
                        </button>
                    </form>
                </div>

                <div class="tab-pane" id="yc_info" tabindex="-1">
                    <a class="mb-3 show_preloader_on_click btn btn-outline-primary"
                       wire:click.prevent="refresh_from_yc">Обновить из YClients</a>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td style="font-weight: bold">YC_ID</td>
                            <td>
                                {{$staff['yc_id']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">yc_name</td>
                            <td>
                                {{$staff['yc_name']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">yc_specialization</td>
                            <td>
                                {{$staff['yc_specialization']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">yc_position</td>
                            <td>
                                {{$staff['yc_position']}}
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
            <h1 style="font-size: 22px;" class="ml-3">Фото примеров этого мастера</h1>
        </div>
        <div class="card-body">

            <div wire:sortable="updateExamplesOrder" class="mb-3 overflow-auto d-flex">
                @foreach($staff->getMedia('staff_examples') as $staff_example)
                    <div style="height: fit-content;" class="interior_pic_wrap"
                         wire:sortable.item="{{$staff_example['id']}}"
                         wire:key="example-{{$staff_example['id']}}">
                        <div class="p-2 buttons">
                            <div wire:sortable.handle style="white-space: nowrap"
                                 class="d-flex align-items-center">
                                 <span class="grabbable handle ui-sortable-handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                 </span>
                            </div>
                            <button wire:click.prevent="delete_example_confirm({{$staff_example['id']}})"
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
                        <img class="m-2" style="max-width: 150px;" src="{{$staff_example->getFullUrl()}}" alt="">
                    </div>

                @endforeach
            </div>


            <div wire:ignore id="filepond_wrap" class="mt-2">
                <input type="file"
                       wire:model="staff_examples"
                       class="filepond"
                       multiple
                       name="staff_examples"
                       id="staff_examples"
                       data-allow-reorder="true"
                       data-max-file-size="30MB"
                       data-max-files="30">

            </div>
            <a type="submit" wire:click.prevent="new_staff_examples"
               class="mt-3 show_preloader_on_click btn btn-outline-primary">
                Сохранить примеры
            </a>
        </div>
    </div>


    <div style="max-width: 1400px;" class="card">
        <div class="d-flex align-items-center card-header p-2">
            <h1 style="font-size: 22px;" class="ml-3">Коллеги этого мастера</h1>
        </div>
        <div class="card-body">

            @if ($staff['collegues'] !== null)
                <div>
                    @foreach($staff['collegues'] as $collegue)
                        <div wire:key="{{ $loop->index }}">
                            <a target="_blank"
                               href="{{route('staff.edit', $collegue['id'])}}">{{$collegue['name']}}</a>
                            <a wire:click.prevent="delete_collegue({{$collegue['id']}})" href="">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                еще нет ни одного
            @endif

            <div class="mt-3" wire:ignore>
                <select wire:ignore class="select2 form-control"
                        aria-hidden="true" id="collegue_to_add">
                    @foreach($collegues_all as $collegue)
                        <option
                            value="{{$collegue['id']}}">{{$collegue['yc_name']}}
                        </option>
                    @endforeach
                </select>
            </div>
            <a type="submit" wire:click.prevent="new_collegue_to_add()"
               class="mt-3 show_preloader_on_click btn btn-outline-primary">
                Добавить
            </a>

        </div>


    </div>


    @push('scripts')
        <script>

            $('#collegue_to_add').on('change', function () {
            @this.set('collegue_to_add', $(this).val());
            })

            function filepond_trigger() {

                function make_livewire_var() {
                    var pics_array = []
                    $("[name='staff_examples']").each(function () {
                        pics_array.push($(this).val())
                    })
                @this.set("staff_examples", pics_array);
                }


                $('#staff_examples').filepond({
                    allowMultiple: true,
                    allowImageValidateSize: true,
                    imageValidateSizeMinWidth: 288,
                    imageValidateSizeMinHeight: 440,
                    allowImageResize: true,
                    imageResizeTargetWidth: 576,
                    imageResizeTargetHeight: 880,
                    imageValidateSizeLabelImageSizeTooBig: 'размер изображения не верный!',
                    imageValidateSizeLabelImageSizeTooSmall: 'размер изображения не верный!',
                    allowFileTypeValidation: true,
                    acceptedFileTypes: ['image/png', 'image/jpeg'],

                    server: {
                        url: '/temp-uploads/staff_examples',
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
                    labelIdle: 'Добавить примеры товара | min: 288:440px | png/jpg',
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
            document.addEventListener('update_filepond', function () {
                $('.filepond--root').remove();
                $(document).ready(function () {
                    input = "<input type='file' wire:model='staff_examples' class='filepond' multiple name='staff_examples' id='staff_examples' data-allow-reorder='true' data-max-file-size='3MB' data-max-files='3'>"
                    $('#filepond_wrap').append(input);
                    filepond_trigger();
                })

            })
        </script>
    @endpush
</div>
