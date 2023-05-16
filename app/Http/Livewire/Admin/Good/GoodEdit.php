<?php

namespace App\Http\Livewire\Admin\Good;

use App\Models\Category;
use App\Models\Good;
use App\Models\Good_hair_type;
use App\Models\Good_skin_type;
use App\Models\GoodCategory;
use App\Models\GoodType;
use App\Models\Scope;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Spatie\Image\Image;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class GoodEdit extends Component
{
    public $good;
    public $flg_active;
    public $name;
    public $desc_small;
    public $desc;
    public $usage;
    public $compound;
    public $good_examples;

    public $specs_detailed;
    public $specs_title;
    public $specs_value;
    public $scopes;
    public $scope;
    public $good_categories;
    public $good_has_categories;

    public $good_skin_types;
    public $good_skin_type_id;
    public $good_has_skin_types;

    public $good_hair_types;
    public $good_hair_type_id;
    public $good_has_hair_type;

    public $good_types;

    public $capacity;
    public $capacity_type;
    public $good_category_id;
    public $flg_on_road;
    public $flg_gift_set;
    public $flg_discount;
    public $skin_type;
    public $hair_type;
    public $product_type;
    public $brand;

//    public $specs_detailed_number = [1];

    protected $listeners = ['refreshGoodEdit' => '$refresh', 'delete_good_example_media', 'delete_good'];


    public function render()
    {
        return view('livewire.admin.good.good-edit');
    }

    public function mount($good_id)
    {
        $this->good = Good::where('id', $good_id)->first();
        $this->flg_active = $this->good['flg_active'];

        $this->name = $this->good['name'];
        $this->scope = $this->good['scope_id'];
        $this->desc_small = $this->good['desc_small'];
        $this->desc = $this->good['desc'];
        $this->usage = $this->good['usage'];
        $this->compound = $this->good['compound'];
        $this->capacity = $this->good['capacity'];
        $this->capacity_type = $this->good['capacity_type'];
        $this->flg_on_road = $this->good['flg_on_road'];
        $this->flg_gift_set = $this->good['flg_gift_set'];
        $this->flg_discount = $this->good['flg_discount'];
        $this->product_type = $this->good['product_type'];
        $this->brand = $this->good['brand'];

        $this->scopes = Scope::orderBy('name')->get();
        $this->good_categories = GoodCategory::orderBy('title')->get();
        $this->good_skin_types = Good_skin_type::orderBy('title')->get();
        $this->good_hair_types = Good_hair_type::orderBy('title')->get();
        $this->good_types = GoodType::orderBy('title')->get();
    }

    public function toggleActivity()
    {
        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($this->name == null) {
            array_push($errors_array, 'Название не заполнено!');
        }

//        if ($this->desc_small == null) {
//            array_push($errors_array, 'Маленькое описание не заполнено!');
//        }

        if ($this->desc == null) {
            array_push($errors_array, 'Описание не заполнено!');
        }
        if ($this->usage == null) {
            array_push($errors_array, 'Применение не заполнено!');
        }

        if ($this->scope == null) {
            array_push($errors_array, 'Выберите сферу от услуг!');
        }


        if (!empty($errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);

            $this->flg_active = $this->good['flg_active'];
        }

        if (empty($errors_array)) {
            $this->good->update([
                'flg_active' => $this->flg_active ? 1 : 0
            ]);

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => $this->flg_active ? 'Товар появился на сайте' : 'Товар скрыт с сайта',
            ]);
        }

    }

    public function editGood($formData)
    {
        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if (empty($this->good['good_category_id']) || ($this->good['good_category_id'] ?? null) === null) {
            array_push($errors_array, 'У товара должна быть хотя бы одна категория!');
        }

        if ($this->name == null) {
            array_push($errors_array, 'Название не заполнено!');
        }

//        if ($this->desc_small == null) {
//            array_push($errors_array, 'Маленькое описание не заполнено!');
//        }

        if ($this->desc == null) {
            array_push($errors_array, 'Описание не заполнено!');
        }
        if ($this->usage == null) {
            array_push($errors_array, 'Применение не заполнено!');
        }

        if ($this->scope == null) {
            array_push($errors_array, 'Выберите сферу от услуг!');
        }

        if ($this->good['yc_category'] <> 'Сертификаты Сеть Tesler' && $this->good['yc_category'] <> 'Абонементы Сеть Tesler' && $this->product_type == null) {
            array_push($errors_array, 'Выберите тип товара!');
        }
        if ($this->good['yc_category'] <> 'Сертификаты Сеть Tesler' && $this->good['yc_category'] <> 'Абонементы Сеть Tesler' && $this->brand == null) {
            array_push($errors_array, 'Выберите бренд!');
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

            $this->good->update([
                'name' => $this->name,
                'scope_id' => $this->scope,
                'desc_small' => $this->desc_small,
                'desc' => $this->desc,
                'usage' => $this->usage,
                'capacity' => $this->capacity,
                'capacity_type' => $this->capacity_type,
                'flg_on_road' => $this->flg_on_road,
                'flg_gift_set' => $this->flg_gift_set,
                'flg_discount' => $this->flg_discount,
                'skin_type' => $this->skin_type,
                'hair_type' => $this->hair_type,
                'product_type' => $this->product_type,
                'brand' => $this->brand,
            ]);

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Товар успешно обновлен!',
            ]);
        }

    }

    public function new_good_examples()
    {
        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($this->good_examples == null || empty($this->good_examples)) {
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
            if (!$this->good_examples == null || !empty($this->good_examples)) {
                foreach ($this->good_examples as $key => $good_example) {
                    $file_path = public_path('media/filepond_temp/' . $good_example);
                    Image::load($file_path)
                        ->optimize()
                        ->save($file_path);
                    $this->good->addMedia($file_path)->toMediaCollection('good_examples');
                }
            }

            $this->dispatchBrowserEvent('update_filepond');
            $this->dispatchBrowserEvent('filepond_trigger');
            $this->emit('refreshGoodEdit');

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

        $this->emit('refreshGoodEdit');

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Порядок примеров успешно изменен!',
        ]);
    }

    public function delete_example_confirm($media_id)
    {
        $this->dispatchBrowserEvent('swal_fire', [
            'type' => 'warning',
            'title' => 'Предупреждение!',
            'text' => 'Вы уверены, что хотите удалить это фото примера?',
            'swal_detail_id' => $media_id,
            'showConfirmButton' => true,
            'showDenyButton' => true,
            'swal_function_to_confirm' => 'delete_good_example_media'
        ]);
    }

    public function delete_good_example_media($media_id)
    {
        $media = Media::where('id', $media_id)->first();
        $media->delete();
        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Фото примера успешно удалено!',
        ]);
        $this->emit('refreshGoodEdit');
    }

    public function refresh_from_yc()
    {
        $YCLIENTS_SHOP_ID = ENV('YCLIENTS_SHOP_ID');
        $YCLIENTS_HEADERS = [
            'Accept' => 'application/vnd.yclients.v2+json',
            'Authorization' => 'Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN')
        ];

        $yc_good = Http::withHeaders($YCLIENTS_HEADERS)
            ->get('https://api.yclients.com/api/v1/goods/' . $YCLIENTS_SHOP_ID . '/' . $this->good['yc_id'])
            ->collect()['data'];


        $storage_id_key = array_search(ENV('YCLIENTS_SHOP_STORAGE'), array_column($yc_good['actual_amounts'], 'storage_id'));
        $yc_actual_amounts = $yc_good['actual_amounts'][$storage_id_key]['amount'] ?? null;
//dd($yc_good);
        $this->good->update([
            'yc_title' => $yc_good['title'],
            'yc_category' => $yc_good['category'],
            'yc_price' => $yc_good['cost'],
            'yc_actual_amount' => $yc_actual_amounts
        ]);

        $this->emit('refreshGoodEdit');

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'YClients данные обновлены!',
        ]);

    }

    public function make_specs_detailed()
    {

        $this->specs_detailed = json_decode($this->good['specs_detailed']);


        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($this->specs_detailed != null) {
            $spec_copy_check = array_filter($this->specs_detailed, function ($var) {
                return ($var->title == $this->specs_title);
            });
            if (count($spec_copy_check) != 0) {
                array_push($errors_array, 'Такая характеристика уже есть!');
            }
        }


        if ($this->specs_title === null || $this->specs_value === null) {
            array_push($errors_array, 'Заполните поля!');
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
            $this->specs_detailed[] = [
                'title' => $this->specs_title,
                'value' => $this->specs_value,
            ];

            $this->specs_detailed = json_encode($this->specs_detailed, JSON_UNESCAPED_UNICODE);

            $this->good->update([
                'specs_detailed' => $this->specs_detailed
            ]);

            $this->specs_title = '';
            $this->specs_value = '';

            $this->emit('refreshGoodEdit');

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Характеристика успешно добавлена!',
            ]);
        }


    }

    public function deleteSpec($spec_title)
    {

        $this->specs_detailed = json_decode($this->good['specs_detailed']);

        if ($this->specs_detailed != null) {
            $found_spec = array_filter($this->specs_detailed, function ($var) use ($spec_title) {
                return ($var->title == $spec_title);
            });
        }

        unset($this->specs_detailed[array_search(current($found_spec), $this->specs_detailed)]);

        $this->good->update([
            'specs_detailed' => json_encode(array_values($this->specs_detailed))
        ]);

        $this->emit('refreshGoodEdit');

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Характеристика удалена!',
        ]);


    }

    public function updateSpecsOrder($list)
    {
        $this->specs_detailed = json_decode($this->good['specs_detailed']);

        foreach ($list as $item) {
            $found_spec = array_filter($this->specs_detailed, function ($var) use ($item) {
                return ($var->title == $item['value']);
            });
//            dd(array_values($found_spec));

            $specs_detailed_new[] = [
                'title' => array_values($found_spec)[0]->title,
                'value' => array_values($found_spec)[0]->value,
            ];
        }

        $this->good->update([
            'specs_detailed' => json_encode($specs_detailed_new)
        ]);

        $this->emit('refreshGoodEdit');

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Порядок успешно изменен!',
        ]);
    }

    public function new_good_category()
    {

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];


        $good_categories = $this->good['good_category_id'];

        if ($this->good['good_category_id'] !== null) {
            $good_category_check = array_filter($good_categories, function ($v) {
                return $v == intval($this->good_category_id);
            });
            $good_category_check = count($good_category_check);
        } else {
            $good_category_check = 0;
        }


        if ($this->good_category_id === null) {
            array_push($errors_array, 'Выберите категорию!');
        }

        if ($good_category_check ?? 0 > 0) {
            array_push($errors_array, 'Эта категория уже есть у товара!');
        }


        if (!empty($errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);

            $this->emit('refreshGoodEdit');
        }

        if (empty($errors_array)) {


            if ($good_categories !== null) {
                array_push($good_categories, intval($this->good_category_id));
                $this->good->update([
                    'good_category_id' => $good_categories,
                ]);
            } else {
                $good_categories_new = [intval($this->good_category_id)];
                $this->good->update([
                    'good_category_id' => $good_categories_new,
                ]);
            }

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Категория успешно применилась к товару!',
            ]);

            $this->emit('refreshGoodEdit');

        }
    }

    public function delete_good_category($good_category_id)
    {
        $good_categories = $this->good['good_category_id'];
        unset($good_categories[array_search($good_category_id, $good_categories)]);

        $this->good->update([
            'good_category_id' => array_values($good_categories),
        ]);

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Категория успешно удалена из товара!',
        ]);

    }

    public function new_good_skin_type()
    {

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];


        $good_skin_types = $this->good['skin_type'];

        if ($this->good['skin_type'] !== null) {
            $good_skin_type_check = array_filter($good_skin_types, function ($v) {
                return $v == intval($this->good_skin_type_id);
            });
            $good_skin_type_check = count($good_skin_type_check);
        } else {
            $good_skin_type_check = 0;
        }


        if ($this->good_skin_type_id === null) {
            array_push($errors_array, 'Выберите категорию!');
        }

        if ($good_skin_type_check ?? 0 > 0) {
            array_push($errors_array, 'Эта категория уже есть у товара!');
        }


        if (!empty($errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);

            $this->emit('refreshGoodEdit');
        }

        if (empty($errors_array)) {


            if ($good_skin_types !== null) {
                array_push($good_skin_types, intval($this->good_skin_type_id));
                $this->good->update([
                    'skin_type' => $good_skin_types,
                ]);
            } else {
                $good_skin_types_new = [intval($this->good_skin_type_id)];
                $this->good->update([
                    'skin_type' => $good_skin_types_new,
                ]);
            }

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Тип кожи успешно применилась к товару!',
            ]);

            $this->emit('refreshGoodEdit');

        }
    }

    public function delete_good_skin_type($good_skin_type_id)
    {
        $good_skin_types = $this->good['skin_type'];
        unset($good_skin_types[array_search($good_skin_type_id, $good_skin_types)]);

        $this->good->update([
            'skin_type' => array_values($good_skin_types),
        ]);

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Тип кожи успешно удалена из товара!',
        ]);

    }

    public function new_good_hair_type()
    {

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];


        $good_hair_types = $this->good['hair_type'];

        if ($this->good['hair_type'] !== null) {
            $good_hair_type_check = array_filter($good_hair_types, function ($v) {
                return $v == intval($this->good_hair_type_id);
            });
            $good_hair_type_check = count($good_hair_type_check);
        } else {
            $good_hair_type_check = 0;
        }


        if ($this->good_hair_type_id === null) {
            array_push($errors_array, 'Выберите категорию!');
        }

        if ($good_hair_type_check ?? 0 > 0) {
            array_push($errors_array, 'Эта категория уже есть у товара!');
        }


        if (!empty($errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);

            $this->emit('refreshGoodEdit');
        }

        if (empty($errors_array)) {


            if ($good_hair_types !== null) {
                array_push($good_hair_types, intval($this->good_hair_type_id));
                $this->good->update([
                    'hair_type' => $good_hair_types,
                ]);
            } else {
                $good_hair_types_new = [intval($this->good_hair_type_id)];
                $this->good->update([
                    'hair_type' => $good_hair_types_new,
                ]);
            }

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Тип кожи успешно применилась к товару!',
            ]);

            $this->emit('refreshGoodEdit');

        }
    }

    public function delete_good_hair_type($good_hair_type_id)
    {
        $good_hair_types = $this->good['hair_type'];
        unset($good_hair_types[array_search($good_hair_type_id, $good_hair_types)]);

        $this->good->update([
            'hair_type' => array_values($good_hair_types),
        ]);

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Тип кожи успешно удалена из товара!',
        ]);

    }

    public function delete_confirm($good_id)
    {
        $good = Good::where('id', $good_id)->first();
        $this->dispatchBrowserEvent('swal_fire', [
            'type' => 'warning',
            'title' => 'Предупреждение!',
            'text' => 'Вы уверены, что хотите удалить акцию "' . $good['name'] . '" ?',
            'swal_detail_id' => $good_id,
            'showConfirmButton' => true,
            'showDenyButton' => true,
            'swal_function_to_confirm' => 'delete_good'
        ]);
    }

    public function delete_good($good_id)
    {
//        dd($this->good);

        $this->good->delete();

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Товар успешно удален!',
        ]);
        return redirect(route('good.index'));
    }

    public function test_make_sale($type_id)
    {

        $YCLIENTS_SHOP_ID = ENV('YCLIENTS_SHOP_ID');
        $YCLIENTS_HEADERS = [
            'Accept' => 'application/vnd.yclients.v2+json',
            'Authorization' => 'Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN')
        ];
//        dd('Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN'));

        $url = 'https://api.yclients.com/api/v1/storage_operations/operation/' . $YCLIENTS_SHOP_ID;


        $data = "{
              \"type_id\": " . $type_id . ",
              \"create_date\": \"" . date('Y-m-d H:i:s') . "\",
              \"storage_id\": " . ENV('YCLIENTS_SHOP_STORAGE') . ",
              \"master_id\" : 724514,
              \"goods_transactions\": [
                  {
                    \"document_id\": 123456,
                    \"good_id\": " . $this->good['yc_id'] . ",
                    \"amount\": 1,
                    \"cost_per_unit\": " . $this->good['yc_price'] . ",
                    \"discount\": 0,
                    \"cost\": 1,
                    \"operation_unit_type\": 1,
                    \"master_id\" : 724514
                  }
              ]
        }";


        $make_operation = Http::withHeaders($YCLIENTS_HEADERS)
            ->withBody($data)
            ->post($url)
            ->collect();

//        // Создаем продажу по операции
//
//        $document_id = $make_operation['data']['document_id'];
//        $total_price = 1;
//        $url_selling = 'https://api.yclients.com/api/v1/company/' . $YCLIENTS_SHOP_ID . '/sale/' . $document_id . '/payment';
//
//        $data_selling = "{
//            \"payment\": {
//                \"method\": {
//                    \"slug\": \"account\",
//                    \"account_id\": 472965
//                },
//            \"amount\": " . $total_price . "
//            }
//            }";
//
//        $make_selling = Http::withHeaders($YCLIENTS_HEADERS)
//            ->withBody($data_selling)
//            ->post($url_selling)
//            ->collect();
//
//        dd($make_selling);


        $this->good->update([
            'yc_actual_amount' => $this->good['yc_actual_amount'] + (($type_id === 1) ? -1 : 1)
        ]);

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => '1 единица товара была успешно ' . (($type_id === 1) ? 'продана' : 'добавлена'),
        ]);

        $this->emit('refreshGoodEdit');
    }


}
