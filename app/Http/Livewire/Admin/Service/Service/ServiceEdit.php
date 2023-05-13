<?php

namespace App\Http\Livewire\Admin\Service\Service;

use App\Models\Category;
use App\Models\Group;
use App\Models\Scope;
use App\Models\Service;
use App\Models\Service_type;
use App\Models\ServiceAdds;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Image\Image;
use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ServiceEdit extends Component
{
    use WithFileUploads;

    public $service;
    public $flg_active;
    public $name;
    public $scope;
    public $scopes;
    public $category;
    public $categories;
    public $group;
    public $groups;
    public $pic_main;
    public $desc_small;
    public $desc;
    public $proccess;
    public $pic_proccess;
    public $result;
    public $service_type;
    public $service_adds;
    public $all_service_adds;
    public $service_to_add;

    public $src_main;
    public $src_proccess;

    public $service_added_to;
    public $all_service_added_to;
    public $service_add_to;

    public $service_examples;


    protected $listeners = ['refreshServiceEdit' => '$refresh', 'update_img_pre', 'update_img', 'delete_service_example_media'];


    public function render()
    {
        $service_types = Service_type::orderBy('name')->get();
        $this->src_main = $this->service->getFirstMediaUrl('pic_main');
        $this->src_proccess = $this->service->getFirstMediaUrl('pic_proccess');
        return view('livewire.admin.service.service.service-edit', [
            'service' => $this->service,
            'scopes' => $this->scopes,
            'categories' => $this->categories,
            'service_types' => $service_types,
            'all_service_adds' => $this->all_service_adds,
            'src_main' => $this->src_main
        ]);
    }

    public function mount($service_id)
    {

        $this->service = Service::where('id', $service_id)->first();

        $this->flg_active = $this->service['flg_active'];
        $this->scopes = Scope::orderBy('name')->get();
        $this->categories = Category::orderBy('name')->get();
        $this->groups = Group::orderBy('name')->get();
        $this->scope = $this->service['scope_id'];
        $this->category = $this->service['category_id'];
        $this->group = $this->service['group_id'];
        $this->name = $this->service['name'];
        $this->desc_small = $this->service['desc_small'];
        $this->desc = $this->service['desc'];
        $this->proccess = $this->service['proccess'];
        $this->result = $this->service['result'];
        $this->service_type = $this->service['service_type_id'];
        $this->all_service_adds = Service::where('service_type_id', 2)->orWhere('service_type_id', 3)->get();
        $this->service_adds  = DB::table('service_adds as sa')
            ->Join('services as s', 'sa.service_add', '=', 's.id')
            ->select(DB::raw('sa.id, s.id as added_id, name'))
            ->where('to_service', '=', $this->service['id'])
            ->get();

        $this->all_service_added_to = Service::where('service_type_id', 1)->orWhere('service_type_id', 2)->get();
        $this->service_added_to  = DB::table('service_adds as sa')
            ->Join('services as s', 'sa.to_service', '=', 's.id')
            ->select(DB::raw('sa.id, s.id as added_id, name'))
            ->where('service_add', '=', $this->service['id'])
            ->get();


    }

    public function updatedScope()
    {
        $this->categories = Category::where('scope_id', $this->scope)->orderBy('name')->get();
        $this->groups = Group::where('scope_id', $this->scope)->orderBy('name')->get();
    }

    public function updatedCategory()
    {
        $this->scope = Category::where('id', $this->category)->first()['scope_id'];
        $this->groups = Group::where('category_id', $this->category)->orderBy('name')->get();

    }

    public function updatedGroup()
    {
        $this->scope = Group::where('id', $this->group)->first()['scope_id'];
        $this->category = Group::where('id', $this->group)->first()['category_id'];
    }

    public function toggleActivity()
    {
        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($this->name == null) {
            array_push($errors_array, 'Название не заполнено!');
        }
        if ($this->scope == null) {
            array_push($errors_array, 'Сфера не выбрана!');
        }
        if ($this->category == null) {
            array_push($errors_array, 'Категория не выбрана!');
        }
        if ($this->group == null) {
            array_push($errors_array, 'Группа не выбрана!');
        }

        if ($this->service->getMedia('pic_main')->count() == 0 && !$this->pic_main) {
            array_push($errors_array, 'Основное изображение не загружено!');
        }
//        if ($this->service->getMedia('pic_proccess')->count() == 0 && !$this->pic_proccess) {
//            array_push($errors_array, 'Изображение процесса не загружено!');
//        }
        if ($this->desc_small == null) {
            array_push($errors_array, 'Маленькое описание не заполнено!');
        }

        if ($this->desc == null) {
            array_push($errors_array, 'Описание не заполнено!');
        }
        if ($this->proccess == null) {
            array_push($errors_array, 'Процесс не заполнен!');
        }
        if ($this->result == null) {
            array_push($errors_array, 'Результат не заполнен!');
        }

        if ($this->service_type == null) {
            array_push($errors_array, 'Тип услуги не выбран!');
        }


        if (!empty($errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);

            $this->flg_active = 0;
        }

        if (empty($errors_array)) {
            $this->service->update([
                'flg_active' => $this->flg_active ? 1 : 0
            ]);

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => $this->flg_active ? 'Услуга появилась на сайте' : 'Услуга скрыта с сайта',
            ]);
        }

    }

    public function editService($formData)
    {


        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($this->pic_main) {
            $data = getimagesize($this->pic_main->getRealPath());
            $pic_main_width = $data[0];
            $pic_main_height = $data[1];
            if ($pic_main_width < 610 || $pic_main_height < 400) {
                array_push($errors_array, 'Основное изображение меньше, чем должно быть по размеру!');
            }
        }

//        if ($this->pic_proccess) {
//            $data = getimagesize($this->pic_proccess->getRealPath());
//            $pic_proccess_width = $data[0];
//            $pic_proccess_height = $data[1];
//        }


        if ($this->name == null) {
            array_push($errors_array, 'Название не заполнено!');
        }
        if ($this->scope == null) {
            array_push($errors_array, 'Сфера не выбрана!');
        }
        if ($this->category == null) {
            array_push($errors_array, 'Категория не выбрана!');
        }
        if ($this->group == null) {
            array_push($errors_array, 'Группа не выбрана!');
        }
        if ($this->service->getMedia('pic_main')->count() == 0 && !$this->pic_main) {
            array_push($errors_array, 'Основное изображение не загружено!');
        }
//        if ($this->service->getMedia('pic_proccess')->count() == 0 && !$this->pic_proccess) {
//            array_push($errors_array, 'Изображение процесса не загружено!');
//        }
        if ($this->desc_small == null) {
            array_push($errors_array, 'Маленькое описание не заполнено!');
        }
        if ($this->desc == null) {
            array_push($errors_array, 'Описание не заполнено!');
        }
        if ($this->proccess == null) {
            array_push($errors_array, 'Процесс не заполнен!');
        }
        if ($this->service_type == null) {
            array_push($errors_array, 'Тип услуги не выбран!');
        }
        if ($this->result == null) {
            array_push($errors_array, 'Результат не заполнен!');
        }


        if (!empty($errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);

        }

        if (empty($errors_array)) {

            $this->service->update([
                'name' => $this->name,
                'scope_id' => $this->scope,
                'category_id' => $this->category,
                'group_id' => $this->group,
                'desc_small' => $this->desc_small,
                'desc' => $this->desc,
                'proccess' => $this->proccess,
                'result' => $this->result,
                'service_type_id' => $this->service_type,
            ]);

            if ($this->pic_main) {
                $pic_main_path = $this->pic_main->getRealPath();
                Image::load($pic_main_path)
                    ->optimize()
                    ->save($pic_main_path);
                if ($this->service->getMedia('pic_main')->count() != 0) {
                    $this->service->getFirstMedia('pic_main')->delete();
                }
                $this->service->addMedia($pic_main_path)->toMediaCollection('pic_main');
            }

            if ($this->pic_proccess) {
                $pic_proccess_path = $this->pic_proccess->getRealPath();
                Image::load($pic_proccess_path)
                    ->optimize()
                    ->save($pic_proccess_path);
                if ($this->service->getMedia('pic_proccess')->count() != 0) {
                    $this->service->getFirstMedia('pic_proccess')->delete();
                }
                $this->service->addMedia($pic_proccess_path)->toMediaCollection('pic_proccess');

            }


            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Услуга успешно изменена!',
            ]);


            $this->emit('refreshServiceEdit');
        }
    }

    public function new_service_add() {

// --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        $service_add_check = ServiceAdds::where('service_add', $this->service_to_add)
            ->where('to_service',  $this->service['id'])->count();


        if ($this->service_to_add == null) {
            array_push($errors_array, 'Выберите доп!');
        }

        if ($service_add_check != 0) {
            array_push($errors_array, 'Этот доп уже добавлен!');
        }

        if (!empty($errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);

        }
        if (empty($errors_array)) {
            $service_add = ServiceAdds::create([
                'service_add' => $this->service_to_add,
                'to_service' => $this->service['id']
            ]);

            $this->service_adds = DB::table('service_adds as sa')
                ->Join('services as s', 'sa.service_add', '=', 's.id')
                ->select(DB::raw('sa.id, s.id as added_id, name'))
                ->where('to_service', '=', $this->service['id'])
                ->get();

            $this->emit('refreshServiceEdit');

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Доп успешно добавлен!',
            ]);
        }
    }

    public function delete_service_add($service_add_id) {


        $service_add = ServiceAdds::where('id', $service_add_id)->delete();

        $this->service_adds  = DB::table('service_adds as sa')
            ->Join('services as s', 'sa.service_add', '=', 's.id')
            ->select(DB::raw('sa.id, s.id as added_id, name'))
            ->where('to_service', '=', $this->service['id'])
            ->get();

        $this->emit('refreshServiceEdit');

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Доп успешно удален!',
        ]);
    }

    public function new_service_added_to() {

// --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        $service_add_check = ServiceAdds::where('to_service', $this->service_add_to)
            ->where('service_add',  $this->service['id'])->count();


        if ($this->service_add_to == null) {
            array_push($errors_array, 'Выберите доп!');
        }

        if ($service_add_check != 0) {
            array_push($errors_array, 'Эта услуга уже идет допом так!');
        }

        if (!empty($errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);

        }
        if (empty($errors_array)) {
            $service_add = ServiceAdds::create([
                'to_service' => $this->service_add_to,
                'service_add' => $this->service['id']
            ]);

            $this->service_added_to  = DB::table('service_adds as sa')
                ->Join('services as s', 'sa.to_service', '=', 's.id')
                ->select(DB::raw('sa.id, s.id as added_id, name'))
                ->where('service_add', '=', $this->service['id'])
                ->get();

            $this->emit('refreshServiceEdit');

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Услуга успешно добавлена допом!',
            ]);
        }
    }

    public function refresh_from_yc() {
        $YCLIENTS_SHOP_ID = ENV('YCLIENTS_SHOP_ID');
        $YCLIENTS_HEADERS = [
            'Accept' => 'application/vnd.yclients.v2+json',
            'Authorization' => 'Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN')
        ];

        $yc_service = Http::withHeaders($YCLIENTS_HEADERS)
            ->get('https://api.yclients.com/api/v1/company/' . $YCLIENTS_SHOP_ID . '/services/'. $this->service['yc_id'])
            ->collect()['data'];

        $yc_service_category = Http::withHeaders($YCLIENTS_HEADERS)
            ->get('https://api.yclients.com/api/v1/service_category/' . $YCLIENTS_SHOP_ID . '/' . $yc_service['category_id'])
            ->collect();
        if ($yc_service_category['data']['title'] ?? null) {
            $yc_service_category = $yc_service_category['data']['title'];
        } else {
            $yc_service_category = null;
        }

        $this->service->update([
            'yc_id' => $yc_service['id'],
            'yc_title' => $yc_service['title'],
            'yc_comment' => $yc_service['comment'],
            'yc_price_min' => $yc_service['price_min'],
            'yc_price_max' => $yc_service['price_max'],
            'yc_duration' => $yc_service['duration'],
            'yc_category_name' => $yc_service_category,
        ]);

        $this->emit('refreshServiceEdit');

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'YClients данные обновлены!',
        ]);
    }


    public function new_service_examples() {
        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

         if ($this->service_examples == null || empty($this->service_examples)) {
            array_push($errors_array, 'Выберите изображения!');
        }


        if (!empty($errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);

        }

        if (empty($errors_array)) {
            // Если есть картинки примеров
            if (!$this->service_examples == null || !empty($this->service_examples)) {
                foreach ($this->service_examples as $key => $service_example) {
                    $file_path = public_path('media/filepond_temp/' . $service_example);
                    Image::load($file_path)
                        ->optimize()
                        ->save($file_path);
                    $this->service->addMedia($file_path)->toMediaCollection('service_examples');
                }
            }

            $this->dispatchBrowserEvent('update_filepond');
            $this->dispatchBrowserEvent('filepond_trigger');
            $this->emit('refreshServiceEdit');

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Пример успешно добавлены!',
            ]);

            return redirect(request()->header('Referer'));
        }
    }

    public function updateExamplesOrder($list)
    {
        foreach ($list as $item) {
            Media::find($item['value'])->update(['order_column' => $item['order']]);
        }

        $this->emit('refreshServiceEdit');

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Порядок примеров успешно изменен!',
        ]);
    }

    public function delete_example_confirm($media_id) {
        $this->dispatchBrowserEvent('swal_fire', [
            'type' => 'warning',
            'title' => 'Предупреждение!',
            'text' => 'Вы уверены, что хотите это фото примера?',
            'swal_detail_id' => $media_id,
            'showConfirmButton' => true,
            'showDenyButton' => true,
            'swal_function_to_confirm' => 'delete_service_example_media'
        ]);
    }

    public function delete_service_example_media($media_id) {
        $media = Media::where('id', $media_id)->first();
        $media->delete();
        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Фото примера успешно удалено!',
        ]);
        $this->emit('refreshServiceEdit');
    }

    public function update_img_pre($media) {
        $files = $this->service->getMedia($media);
        $files->each(function ($file) use ($media) {
            $file_name  = Str::random(5) . '.' . $file->file_name;
            $this->service->addMedia($file->getPath())->usingName($file_name)->usingFileName($file_name)->toMediaCollection($media);
            $file->delete();
        });
        $this->src_main = $this->service->getMedia($media);
        $this->emit('update_img');
    }

    public function update_img() {
        $this->src_main = $this->service->getFirstMediaUrl('pic_main');
        $this->src_proccess = $this->service->getFirstMediaUrl('pic_proccess');
    }


}
