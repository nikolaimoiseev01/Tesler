<div>
    <div style="max-width: 1000px;" class="card">
        <div class="card-body p-0">
            <ul class="products-list product-list-in-card pl-2 pr-2">
                @foreach($promos as $promo)
                    <li x-data="{ open_{{$promo['id']}}: false }"
                        wire:key="promo-{{$promo['id']}}" class="item">
                        <div class="d-flex align-items-center">


                            <div class="ml-0 mr-3 product-info">
                                <a onclick='Livewire.emit("openModal", "admin.promocodes.promocodes-edit", {{ json_encode(["promo_id" => $promo['id']]) }})'
                                   class="product-title">
                                    {{$promo['title']}} : {{$promo['discount']}} %
                                </a>
                            </div>
                            <div class="ml-auto mr-3">
                                <a onclick='Livewire.emit("openModal", "admin.promocodes.promocodes-edit", {{ json_encode(["promo_id" => $promo['id']]) }})' class="mr-3">
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
                  wire:submit="createPromo(Object.fromEntries(new FormData($event.target)))">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Название</label>
                    <input type="text" id="title" name="title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Процентов:</label>
                    <input type="number" id="discount" name="discount" class="form-control">
                </div>


                <button type="submit" class="w-100 show_preloader_on_click btn btn-outline-primary">Сохранить</button>

            </form>
        </div>
    </div>
    @push('scripts')

        <script>

            document.addEventListener('close_form_edit', function () {
                $('.edit_promo').hide();
            })


        </script>
    @endpush
</div>
