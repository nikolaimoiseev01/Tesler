<?php

namespace App\Http\Livewire\Admin\Staff;

use App\Models\Staff;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class StaffIndex extends Component
{
    public $found_yc_staffs;

    protected $listeners = ['refreshStaffIndex' => '$refresh'];

    public function render()
    {
        return view('livewire.admin.staff.staff-index');
    }

    public function search_for_staffs()
    {

        $YCLIENTS_SHOP_ID = ENV('YCLIENTS_SHOP_ID');
        $YCLIENTS_HEADERS = [
            'Accept' => 'application/vnd.yclients.v2+json',
            'Authorization' => 'Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN')
        ];


        $yc_staffs = Http::withHeaders($YCLIENTS_HEADERS)
            ->get('https://api.yclients.com/api/v1/company/' . $YCLIENTS_SHOP_ID . '/staff/')
            ->collect()['data'];
        $yc_staffs = array_values(Arr::where($yc_staffs, function ($value, $key) {
            return $value['fired'] == 0;
        })); // Только неуволенных сотрудников


        $this->found_yc_staffs = null;

        foreach ($yc_staffs as $yc_staff) { // Идем по всем услугам YCLIENTS
            if (Staff::where('yc_id', $yc_staff['id'])->exists()) {
            } else {
                $this->found_yc_staffs[] = [
                    'yc_id' => $yc_staff['id'],
                    'yc_name' => $yc_staff['name'],
                    'yc_avatar' => $yc_staff['avatar_big'],
                    'yc_position' => $yc_staff['position']['title'] ?? '',
                    'yc_specialization' => $yc_staff['specialization'],
                ];
            }

            if (empty($this->found_yc_staffs)) {
                $this->dispatchBrowserEvent('swal_fire', [
                    'type' => 'success',
                    'showDenyButton' => false,
                    'showConfirmButton' => false,
                    'title' => 'Все услуги актуальны!',
                    'text' => 'Новых сотрудников на YClients не найдено.',
                ]);
            } else {
                $this->dispatchBrowserEvent('swal_fire', [
                    'type' => 'info',
                    'showDenyButton' => false,
                    'showConfirmButton' => false,
                    'title' => 'Надены новые сотрудники!',
                    'text' => 'Их можно добавить в систему, если все в порядке.',
                ]);
            }
        }


    }

    public function add_found_staffs()
    {
        foreach ($this->found_yc_staffs as $found_yc_staff) {
            staff::create([
                'yc_id' => $found_yc_staff['yc_id'],
                'yc_name' => $found_yc_staff['yc_name'],
                'yc_avatar' => $found_yc_staff['yc_avatar'],
                'yc_position' => $found_yc_staff['yc_position'],
                'yc_specialization' => $found_yc_staff['yc_specialization'],
            ]);
        }
        $this->found_yc_staffs = null;
        $this->emit('pg:eventRefresh-default');
        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Новые сотрудники добавлены!',
        ]);

    }

    public function refresh_staff_yc_info()
    {
        $YCLIENTS_SHOP_ID = ENV('YCLIENTS_SHOP_ID');
        $YCLIENTS_HEADERS = [
            'Accept' => 'application/vnd.yclients.v2+json',
            'Authorization' => 'Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN')
        ];

        $yc_staffs = Http::withHeaders($YCLIENTS_HEADERS)
            ->get('https://api.yclients.com/api/v1/company/' . $YCLIENTS_SHOP_ID . '/staff/')
            ->collect()['data'];

        foreach ($yc_staffs as $yc_staff) { // Идем по всем стаффам YCLIENTS
            $staff_found = Staff::where('yc_id', $yc_staff['id'])->first();

            if($yc_staff['fired'] == 1 && $staff_found) { // Если сотрудник уволен и есть в системе - удаляем его
                $staff_found->delete();
            }

            if ($staff_found ?? null) { // Если есть такой сотрудник

                $staff_found->update([
                    'yc_id' => $yc_staff['id'],
                    'yc_name' => $yc_staff['name'],
                    'yc_avatar' => $yc_staff['avatar_big'],
                    'yc_position' => $yc_staff['position']['title'] ?? 'Другое',
                    'yc_specialization' => $yc_staff['specialization'],
                ]);

            }

            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'success',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Успешно!',
                'text' => 'Информация о всех сотрудниках успешно обновлена',
            ]);

            $this->emit('pg:eventRefresh-default');

        }
    }
}
