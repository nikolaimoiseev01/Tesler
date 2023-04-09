<div>
    <form name="add-blog-post-form" class="p-3 mt-3" id="add-blog-post-form"
          method="post"
          wire:submit.prevent="createGroup(Object.fromEntries(new FormData($event.target)))">
        @csrf
        <h1 style="font-size: 1.8rem;" class="mb-3 pb-3 border-bottom">Добавление группы</h1>
        <div class="form-group">
            <label for="exampleInputEmail1">Название</label>
            <input wire:model="name" class="form-control">
        </div>

        <div class="form-group">
            <label>Сфера</label>
            <select wire:model="scope" class="form-control">
                <option hidden>Выберите сферу</option>
                @foreach($scopes as $scope)
                    <option value="{{$scope['id']}}">{{$scope['name']}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Категория</label>
            <select wire:model="category" class="form-control">
                <option hidden>Выберите категорию</option>
                @foreach($categories as $category)
                    <option value="{{$category['id']}}">{{$category['name']}}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="w-100 show_preloader_on_click btn btn-outline-primary">Сохранить</button>

    </form>

        <script>
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

            document.addEventListener('livewire:update', function () {
                // filepond_trigger();
                main_js_trigger();
                page_js_trigger();
                // $(':input').val('');
            })
        </script>

</div>
