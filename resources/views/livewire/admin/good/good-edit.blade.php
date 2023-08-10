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
        <div class="d-flex flex-wrap gap-3  align-items-center card-header p-2">
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
                <div class="flex-wrap gap-2 d-flex">

                    <a target="_blank" class="mr-3 link"
                       href="https://yclients.com/goods/list/247576/?goodNameOrArticleOrBarcode={{preg_replace('/\s+/', '+', $good['yc_title'])}}">Страница
                        на
                        YClients</a>
                    <a target="_blank" class="mr-3 link" href="{{route('good_page', $good['id'])}}">Страница на
                        сайте</a>
                    <div class="d-flex ml-auto">

                        @if($good['flg_active'] ?? 0 == 1)
                            <p class="mr-2" style="color: #1ac71a">есть на сайте</p>
                        @else
                            <p class="mr-2" style="color: grey">неактивна</p>
                        @endif
                        <label class="mb-0 float-right relative inline-flex items-center cursor-pointer">

                            <input wire:model="flg_active" wire:change="toggleActivity" type="checkbox" value=""
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
                    <form wire:submit.prevent="editGood(Object.fromEntries(new FormData($event.target)))">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Название на сайте</label>
                                    <input wire:model="name" type="text" class="form-control"
                                           id="exampleInputEmail1"
                                           placeholder="Имя услуги">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="promo_text">Промо текст</label>
                                    <input wire:model="promo_text" type="text" class="form-control"
                                           id="promo_text"
                                           placeholder="Промотекст">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="promo_text">Скидка в процентах</label>
                                    <input wire:model="discount" type="text" class="form-control"
                                           id="promo_text"
                                           placeholder="Скидка">
                                </div>
                            </div>


                            <div class="col-md-2 form-group">
                                <label>Большой блок</label>
                                <select wire:model="flg_big_block" class="form-control"
                                        name="flg_big_block" aria-hidden="true">
                                    <option value="1">Да
                                    </option>
                                    <option value="0">Нет
                                    </option>
                                </select>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Сфера от услуг</label>
                                <select wire:model="scope" class="form-control"
                                        name="category_id" aria-hidden="true">
                                    @if(!($scope ?? null))
                                        <option value="" hidden>Выберите категорию</option>
                                    @endif
                                    @foreach($scopes as $scope)
                                        <option value="{{$scope['id']}}">{{$scope['name']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Категория от услуг</label>
                                <select wire:model="category" class="form-control"
                                        name="v" aria-hidden="true">
                                    @if(!($category ?? null))
                                        <option value="" hidden>Выберите категорию</option>
                                    @endif
                                    @foreach($categories as $category)
                                        <option value="{{$category['id']}}">{{$category['name']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Тип продукта</label>
                                <select wire:model="product_type" class="form-control"
                                        name="product_type" aria-hidden="true">
                                    @if(!($good_types ?? null))
                                        <option value="" hidden>Выберите тип</option>
                                    @endif
                                    @foreach($good_types as $good_type)
                                        <option value="{{$good_type['title']}}">{{$good_type['title']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="brand">Бренд</label>
                                    <input wire:model="brand" type="text" class="form-control"
                                           id="brand"
                                           placeholder="Тип объема">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Объем</label>
                                    <input wire:model="capacity" type="number" class="form-control"
                                           id="capacity"
                                           placeholder="Объем">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Тип измерения объема</label>
                                    <input wire:model="capacity_type" type="text" class="form-control"
                                           id="capacity_type"
                                           placeholder="Тип объема">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mt-3 mb-3 p-3 border form-group">
                                    <label for="">Категории у товара:</label>
                                    @if ($good['good_category_id'] !== null)
                                        <div class="mb-3">

                                            @foreach($good['good_category_id'] as $good_category)
                                                <div wire:key="{{ $loop->index }}">
                                                    {{\App\Models\GoodCategory::where('id', $good_category)->first(['title'])->title}}
                                                    <a wire:click.prevent="delete_good_category({{$good_category}})"
                                                       href="">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        еще нет ни одной
                                    @endif


                                    <select wire:model="good_category_id" class=" form-control"
                                            aria-hidden="true" id="service_to_add">
                                        <option value="">Выберите категорию</option>
                                        @foreach($good_categories as $good_category)
                                            <option
                                                value="{{$good_category['id']}}">{{$good_category['title']}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <a type="submit" wire:click.prevent="new_good_category()"
                                       class="mt-3 show_preloader_on_click btn btn-outline-primary">
                                        Добавить
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mt-3 mb-3 p-3 border form-group">
                                    <label for="">Типы кожи:</label>
                                    @if ($good['skin_type'] !== null && !(empty($good['skin_type'])))
                                        <div class="flex-wrap d-flex gap-3 mb-3">
                                            @foreach($good['skin_type'] as $good_skin_type)
                                                <div class="d-flex gap-1 align-items-center"
                                                     wire:key="{{ $loop->index }}">
                                                    {{\App\Models\Good_skin_type::where('id', $good_skin_type)->first(['title'])->title}}
                                                    <a wire:click.prevent="delete_good_skin_type({{$good_skin_type}})"
                                                       href="">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        еще нет ни одной
                                    @endif


                                    <select wire:model="good_skin_type_id" class=" form-control"
                                            aria-hidden="true" id="service_to_add">
                                        <option value="">Выберите тип</option>
                                        @foreach($good_skin_types as $good_skin_type)
                                            <option
                                                value="{{$good_skin_type['id']}}">{{$good_skin_type['title']}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <a type="submit" wire:click.prevent="new_good_skin_type()"
                                       class="mt-3 show_preloader_on_click btn btn-outline-primary">
                                        Добавить
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mt-3 mb-3 p-3 border form-group">
                                    <label for="">Типы волос:</label>
                                    @if ($good['hair_type'] !== null && !(empty($good['hair_type'])))
                                        <div class="flex-wrap d-flex gap-3 mb-3">
                                            @foreach($good['hair_type'] as $good_hair_type)
                                                <div class="d-flex gap-1 align-items-center"
                                                     wire:key="{{ $loop->index }}">
                                                    {{\App\Models\Good_hair_type::where('id', $good_hair_type)->first(['title'])->title}}
                                                    <a wire:click.prevent="delete_good_hair_type({{$good_hair_type}})"
                                                       href="">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        еще нет ни одной
                                    @endif


                                    <select wire:model="good_hair_type_id" class=" form-control"
                                            aria-hidden="true" id="service_to_add">
                                        <option value="">Выберите тип</option>
                                        @foreach($good_hair_types as $good_hair_type)
                                            <option
                                                value="{{$good_hair_type['id']}}">{{$good_hair_type['title']}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <a type="submit" wire:click.prevent="new_good_hair_type()"
                                       class="mt-3 show_preloader_on_click btn btn-outline-primary">
                                        Добавить
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="desc_small">Описание маленькое</label>
                                    <textarea wire:model="desc_small" name="desc_small" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Описание</label>
                                    <textarea wire:model="desc" name="desc" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Применение</label>
                                    <textarea wire:model="usage" name="usage" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Состав</label>
                                    <textarea wire:model="compound" name="compound" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>


                        {{--                        <div class="row p-3 ml-1 mb-3 border">--}}
                        {{--                            <div class="col-md-4">--}}
                        {{--                                <div class="form-check">--}}
                        {{--                                    <input wire:model="flg_on_road" type="checkbox" class="form-check-input"--}}
                        {{--                                           id="flg_on_road">--}}
                        {{--                                    <label class="form-check-label" for="flg_on_road">Можно взять в дорогу</label>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}

                        {{--                            <div class="col-md-4">--}}
                        {{--                                <div class="form-check">--}}
                        {{--                                    <input wire:model="flg_gift_set" type="checkbox" class="form-check-input"--}}
                        {{--                                           id="flg_gift_set">--}}
                        {{--                                    <label class="form-check-label" for="flg_gift_set">Подарочный набор</label>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}

                        {{--                            <div class="col-md-4">--}}
                        {{--                                <div class="form-check">--}}
                        {{--                                    <input wire:model="flg_discount" type="checkbox" class="form-check-input"--}}
                        {{--                                           id="flg_discount">--}}
                        {{--                                    <label class="form-check-label" for="flg_discount">Скидочный товар</label>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                        <button type="submit" class="w-100 show_preloader_on_click btn btn-outline-primary">
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
                                {{$good['yc_id']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">YC_Title</td>
                            <td>
                                {{$good['yc_title']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">YC_category</td>
                            <td>
                                {{$good['yc_category']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">YC_Price</td>
                            <td>
                                {{$good['yc_price']}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Остаток</td>
                            <td>
                                {{$good['yc_actual_amount']}}
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
            <h1 style="font-size: 22px;" class="ml-3">Подробные характеристики</h1>
        </div>
        <div class="card-body">
            @if(json_decode($good['specs_detailed']) != null)
                <table wire:sortable="updateSpecsOrder" class="col-md-6 table table-bordered">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Характеристика</th>
                        <th>Значение</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(json_decode($good['specs_detailed']) as $spec)
                        <tr
                            wire:sortable.item="{{$spec->title}}"
                            wire:key="spec-{{$spec->title}}"
                        >
                            <td>
                                <div wire:sortable.handle style="white-space: nowrap"
                                     class="d-flex align-items-center">
                                 <span class="grabbable handle ui-sortable-handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                 </span>
                                </div>
                            </td>
                            <td>{{$spec->title}}</td>
                            <td>{{$spec->value}}</td>
                            <td>
                                <div class="col-md-1"><i
                                        wire:click.prevent="deleteSpec('{{$spec->title}}')"
                                        class="cursor-pointer fa-solid fa-trash"></i></div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif

            <div class="mt-3 align-items-center row">
                <div class="col-md-6 form-group">
                    <label for="specs_title">Характеристика</label>
                    <input wire:model="specs_title" type="text" class="form-control"
                           placeholder="Название характеристики">
                </div>
                <div class="col-md-5 form-group">
                    <label for="specs_value">Значение</label>
                    <input wire:model="specs_value" type="text" class="form-control"
                           placeholder="Значение">
                </div>


            </div>

            <a type="submit" wire:click.prevent="make_specs_detailed"
               class="mt-3 show_preloader_on_click btn btn-outline-primary">
                Добавить характеристику
            </a>
        </div>
    </div>

    <div style="max-width: 1400px;" class="card">
        <div class="d-flex align-items-center card-header p-2">
            <h1 style="font-size: 22px;" class="ml-3">Фото примеров этого товара</h1>
        </div>
        <div class="card-body">

            <div wire:sortable="updateExamplesOrder" class="mb-3 overflow-auto d-flex">
                @foreach($good->getMedia('good_examples') as $good_example)
                    <div style="height: fit-content;" class="interior_pic_wrap"
                         wire:sortable.item="{{$good_example['id']}}"
                         wire:key="example-{{$good_example['id']}}">
                        <div class="p-2 buttons">
                            <div wire:sortable.handle style="white-space: nowrap"
                                 class="d-flex align-items-center">
                                 <span class="grabbable handle ui-sortable-handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                 </span>
                            </div>
                            <button wire:click.prevent="delete_example_confirm({{$good_example['id']}})"
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
                                 data-crop-width="712"
                                 data-crop-height="712"
                                 class="m-2" style="max-width: 150px;" src="{{$good_example->getFullUrl()}}" alt="">
                            <i class="image_edit_button fa-solid fa-pencil"></i>
                        </div>
                    </div>

                @endforeach
            </div>


            <div wire:ignore id="filepond_wrap" class="mt-2">
                <input type="file"
                       wire:model="good_examples"
                       class="filepond"
                       multiple
                       name="good_examples"
                       id="good_examples"
                       data-allow-reorder="true"
                       data-max-file-size="30MB"
                       data-max-files="30">

            </div>
            <a type="submit" wire:click.prevent="new_good_examples"
               class="mt-3 show_preloader_on_click btn btn-outline-primary">
                Сохранить примеры
            </a>
        </div>


    </div>

    <button type="button" wire:click.prevent="delete_confirm({{$good['id']}})" style="width: fit-content;"
            class="mt-3 btn btn-block btn-outline-danger btn-lg">Удалить товар
    </button>

    <button type="button" wire:click.prevent="test_make_sale(1)" style="width: fit-content;"
            class="mt-3 btn btn-block btn-outline-primary btn-lg">Продать товар
    </button>

    <button type="button" wire:click.prevent="test_make_sale(3)" style="width: fit-content;"
            class="mt-3 btn btn-block btn-outline-primary btn-lg">Приход товара
    </button>

    @push('scripts')
        <script>
            function filepond_trigger() {

                function make_livewire_var() {
                    var pics_array = []
                    $("[name='good_examples']").each(function () {
                        pics_array.push($(this).val())
                    })
                @this.set("good_examples", pics_array);
                }


                $('#good_examples').filepond({
                    allowMultiple: true,
                    allowImageValidateSize: true,
                    imageValidateSizeMinWidth: 712,
                    imageValidateSizeMinHeight: 480,
                    imageValidateSizeLabelImageSizeTooBig: 'размер изображения не верный!',
                    imageValidateSizeLabelImageSizeTooSmall: 'размер изображения не верный!',
                    allowFileTypeValidation: true,
                    acceptedFileTypes: ['image/png', 'image/jpeg'],

                    server: {
                        url: '/temp-uploads/good_examples',
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
                    labelIdle: 'Добавить примеры товара | min: 480:712px | png/jpg',
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
                    input = "<input type='file' wire:model='good_examples' class='filepond' multiple name='good_examples' id='good_examples' data-allow-reorder='true' data-max-file-size='3MB' data-max-files='3'>"
                    $('#filepond_wrap').append(input);
                    filepond_trigger();
                })

            })
        </script>
    @endpush
</div>
