<div>
    <div class="p-3 border-top">


        <form name="add-blog-post-form" class="mt-3" id="add-blog-post-form"
              method="post"
              wire:submit.prevent="editPromo(Object.fromEntries(new FormData($event.target)))">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Название</label>
                <input type="text" id="title" wire:model="title" name="title" class="form-control">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Процентов:</label>
                <input type="number" id="discount" wire:model="discount" name="discount" class="form-control">
            </div>


            <button type="submit" class="w-100 show_preloader_on_click btn btn-outline-primary">Сохранить</button>

        </form>
    </div>
</div>
